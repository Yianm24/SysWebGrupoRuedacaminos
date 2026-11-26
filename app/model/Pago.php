<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;
use App\Traits\ExpRegexTrait;

class Pago extends Conexion
{
    use ValidadorTraitAjax, ExpRegexTrait;

    private $cod_pago;
    private $fecha;
    private $hora;
    private $monto;
    private $monto_original;
    private $referencia;
    private $estado_pago;
    private $cod_envio;
    private $estado;
    private $cod_detallepago;
    private $cod_metodopago;
    private $cod_banco;

    public function __construct()
    {
        parent::__construct();
    }

    private function prepararCamposDesdePayload(array $datosObt, bool $esEdicion = false): array
    {
        $ref = trim((string)($datosObt['referencia'] ?? ''));
        $cta = trim((string)($datosObt['cuentas'] ?? ''));
        $refSegura = $ref !== '' ? $ref : 'N/A';
        $ctaSegura = $cta !== '' ? $cta : 'N/A';

        if ($esEdicion) {
            return [
                $datosObt['cod_pago'] ?? '',
                $datosObt['fecha_pago'] ?? date('Y-m-d'),
                $datosObt['monto'] ?? '',
                $datosObt['monto_ingresado'] ?? '',
                $refSegura,
                $datosObt['cod_detallepago'] ?? '',
                $datosObt['metodos'] ?? '',
                $ctaSegura
            ];
        }

        return [
            $datosObt['fecha_pago'] ?? date('Y-m-d'),
            $datosObt['monto'] ?? '',
            $datosObt['monto_ingresado'] ?? '',
            $refSegura,
            $datosObt['cod_envio'] ?? '',
            $datosObt['metodos'] ?? '',
            $ctaSegura
        ];
    }

    private function obtenerMontoTotalEnvio(int $cod_envio): float
    {
        $stmt = $this->conexion->prepare("SELECT monto_total FROM envio WHERE cod_envio = ? LIMIT 1");
        $stmt->execute([$cod_envio]);
        return (float)($stmt->fetchColumn() ?: 0);
    }

    private function obtenerTotalAbonadoEnvio(int $cod_envio, $excluirCodPago = null): float
    {
        if ($excluirCodPago !== null && $excluirCodPago !== '') {
            $stmt = $this->conexion->prepare(
                "SELECT COALESCE(SUM(monto), 0) FROM pago WHERE cod_envio = ? AND estado = 1 AND cod_pago != ?"
            );
            $stmt->execute([$cod_envio, (int)$excluirCodPago]);
        } else {
            $stmt = $this->conexion->prepare(
                "SELECT COALESCE(SUM(monto), 0) FROM pago WHERE cod_envio = ? AND estado = 1"
            );
            $stmt->execute([$cod_envio]);
        }
        return (float)($stmt->fetchColumn() ?: 0);
    }

    private function construirExpresionEstatusPagoSql(): string
    {
        return "CASE
            WHEN e.estado = 0 OR UPPER(TRIM(COALESCE(e.estatus, ''))) = 'ANULADO' THEN 'Anulado'
            WHEN COALESCE(agg.total_abonado, 0) >= e.monto_total
                AND COALESCE(agg.total_abonado, 0) > 0 THEN 'Completado'
            WHEN COALESCE(agg.tiene_pago_activo, 0) = 1 THEN 'Pendiente'
            ELSE 'Sin pagos'
        END";
    }

    private function sqlBaseAgregada(): string
    {
        return " FROM envio e
                LEFT JOIN (
                    SELECT
                        p.cod_envio,
                        COALESCE(SUM(CASE WHEN p.estado = 1 THEN p.monto ELSE 0 END), 0) AS total_abonado,
                        COUNT(CASE WHEN p.estado = 1 AND p.monto > 0 THEN 1 END) AS cantidad_pagos,
                        MAX(CASE WHEN p.estado = 1 THEN 1 ELSE 0 END) AS tiene_pago_activo,
                        MAX(CASE WHEN p.estado = 1 THEN p.cod_pago END) AS ultimo_cod_pago,
                        MAX(CASE WHEN p.estado = 1 THEN p.cod_pago ELSE p.cod_pago END) AS ultimo_cod_pago_any
                    FROM pago p
                    GROUP BY p.cod_envio
                ) agg ON agg.cod_envio = e.cod_envio
                LEFT JOIN pago pu ON pu.cod_pago = agg.ultimo_cod_pago
                LEFT JOIN detalle_pago du ON du.cod_detallepago = pu.cod_detallepago
                LEFT JOIN pago pu_any ON pu_any.cod_pago = agg.ultimo_cod_pago_any ";
    }

    public function obt_RegistrosPagos()
    {
        try {
            $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
            $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
            $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
            $searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

            $exprEstatus = $this->construirExpresionEstatusPagoSql();

            $columnasOrder = [
                0 => 'e.cod_envio',
                1 => $exprEstatus,
                2 => 'e.monto_total',
                3 => 'total_abonado_envio',
                4 => 'cantidad_pagos',
                5 => 'total_abonado_envio',
                6 => 'estado_registro_pago'
            ];

            $orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
            $orderColumn = $columnasOrder[$orderColumnIndex] ?? 'e.cod_envio';
            $orderDir = (isset($_POST['order'][0]['dir']) && strtoupper($_POST['order'][0]['dir']) === 'ASC') ? 'ASC' : 'DESC';

            $sqlBase = $this->sqlBaseAgregada();

            $stmtTotal = $this->conexion->query("SELECT COUNT(*) AS total FROM envio");
            $recordsTotal = (int)($stmtTotal->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0);

            $condiciones = [];
            $params = [];

            if ($searchValue !== '') {
                $mapaEstatusBusqueda = [
                    'COMPLETADOS' => 'Completado',
                    'PENDIENTES'  => 'Pendiente',
                    'ANULADOS'    => 'Anulado',
                    'SIN_PAGOS'   => 'Sin pagos'
                ];
                $busquedaEstatus = $mapaEstatusBusqueda[strtoupper($searchValue)] ?? $searchValue;
                $busquedaDecimal = str_replace(',', '.', $searchValue);

                $condiciones[] = " (
                    CAST(e.cod_envio AS CHAR) LIKE :search
                    OR CAST(e.monto_total AS CHAR) LIKE :search
                    OR CAST(e.monto_total AS CHAR) LIKE :search_dec
                    OR COALESCE(e.estatus, '') LIKE :search
                    OR ({$exprEstatus}) LIKE :search
                    OR ({$exprEstatus}) LIKE :search_estatus
                    OR EXISTS (
                        SELECT 1
                        FROM pago px
                        LEFT JOIN detalle_pago dx ON px.cod_detallepago = dx.cod_detallepago
                        LEFT JOIN metodo_pago mx ON dx.cod_metodopago = mx.cod_metodo
                        LEFT JOIN banco bx ON dx.cod_banco = bx.cod_banco
                        WHERE px.cod_envio = e.cod_envio
                            AND px.estado = 1
                            AND (
                                CAST(px.cod_pago AS CHAR) LIKE :search
                                OR CAST(px.monto AS CHAR) LIKE :search_dec
                                OR CAST(dx.monto AS CHAR) LIKE :search_dec
                                OR COALESCE(CAST(px.referencia AS CHAR), '') LIKE :search
                                OR COALESCE(mx.nombre, '') LIKE :search
                                OR COALESCE(bx.nombre, '') LIKE :search
                            )
                    )
                ) ";
                $params[':search'] = "%{$searchValue}%";
                $params[':search_dec'] = "%{$busquedaDecimal}%";
                $params[':search_estatus'] = "%{$busquedaEstatus}%";
            }

            $sqlWhere = count($condiciones) > 0 ? (" WHERE " . implode(" AND ", $condiciones)) : "";

            $stmtFiltered = $this->conexion->prepare("SELECT COUNT(*) AS total " . $sqlBase . $sqlWhere);
            foreach ($params as $key => $val) {
                $stmtFiltered->bindValue($key, $val, \PDO::PARAM_STR);
            }
            $stmtFiltered->execute();
            $recordsFiltered = (int)($stmtFiltered->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0);

            $ordenPredeterminadoSql = "
                CASE ({$exprEstatus})
                    WHEN 'Sin pagos'  THEN 1
                    WHEN 'Pendiente'  THEN 2
                    WHEN 'Completado' THEN 3
                    WHEN 'Anulado'    THEN 4
                    ELSE 5
                END ASC,
                CASE WHEN ({$exprEstatus}) = 'Completado' THEN COALESCE(agg.ultimo_cod_pago, e.cod_envio) END DESC,
                CASE WHEN ({$exprEstatus}) = 'Anulado' THEN e.cod_envio END ASC,
                e.cod_envio DESC
            ";

            $tieneOrdenManual = isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir']);
            $orderClauseSql = $tieneOrdenManual
                ? " ORDER BY {$orderColumn} {$orderDir}, {$ordenPredeterminadoSql} "
                : " ORDER BY {$ordenPredeterminadoSql} ";

            $sqlData = "SELECT
                            e.cod_envio,
                            e.fecha AS fecha_envio,
                            e.monto_total,
                            e.estado AS estado_envio,
                            e.estatus AS estatus_envio,
                            ({$exprEstatus}) AS estatus_calculado,
                            COALESCE(agg.total_abonado, 0) AS total_abonado_envio,
                            COALESCE(agg.cantidad_pagos, 0) AS cantidad_pagos,
                            agg.ultimo_cod_pago,
                            pu.estado_pago,
                            pu_any.estado AS estado_registro_pago,
                            pu.cod_detallepago,
                            pu.fecha,
                            pu.hora,
                            pu.referencia,
                            pu.monto AS ultimo_monto_usd,
                            du.monto AS monto_ingresado_original,
                            du.cod_metodopago,
                            du.cod_banco
                        " . $sqlBase
                        . $sqlWhere
                        . $orderClauseSql;

            if ($length != -1) {
                $sqlData .= " LIMIT :start, :length";
            }

            $stmtData = $this->conexion->prepare($sqlData);
            foreach ($params as $key => $val) {
                $stmtData->bindValue($key, $val, \PDO::PARAM_STR);
            }
            if ($length != -1) {
                $stmtData->bindValue(':start', max(0, $start), \PDO::PARAM_INT);
                $stmtData->bindValue(':length', max(1, $length), \PDO::PARAM_INT);
            }

            $stmtData->execute();
            $data = $stmtData->fetchAll(\PDO::FETCH_ASSOC);

            return json_encode([
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            ]);
        } catch (\PDOException $e) {
            return json_encode([
                "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "error" => $e->getMessage()
            ]);
        }
    }

    public function obt_HistorialEnvio($cod_envio)
    {
        try {
            $codEnvioLimpio = (int)$cod_envio;
            if ($codEnvioLimpio <= 0) {
                return ['envio' => null, 'remitente' => null, 'pagos' => []];
            }

            $stmtEnvio = $this->conexion->prepare(
                "SELECT e.cod_envio, e.fecha AS fecha_envio, e.monto_total, e.estado AS estado_envio, e.estatus AS estatus_envio, e.descrip_contenido,
                    COALESCE((
                        SELECT SUM(p2.monto) FROM pago p2 WHERE p2.cod_envio = e.cod_envio AND p2.estado = 1
                    ), 0) AS total_abonado_envio
                FROM envio e WHERE e.cod_envio = ? LIMIT 1"
            );
            $stmtEnvio->execute([$codEnvioLimpio]);
            $envio = $stmtEnvio->fetch(\PDO::FETCH_ASSOC);

            $stmtRem = $this->conexion->prepare(
                "SELECT c.cod_cliente, c.tipo_documento, c.doc_identidad, c.razon_social, c.apellido, c.telefono, c.email, pe.rol_cliente
                FROM participante_envio pe
                INNER JOIN cliente c ON pe.cod_cliente = c.cod_cliente
                WHERE pe.cod_envio = ? AND LOWER(TRIM(pe.rol_cliente)) = 'remitente' LIMIT 1"
            );
            $stmtRem->execute([$codEnvioLimpio]);
            $remitente = $stmtRem->fetch(\PDO::FETCH_ASSOC);

            $stmtPagos = $this->conexion->prepare(
                "SELECT p.cod_pago, p.fecha, p.hora, p.monto AS monto_abonado_usd,
                    p.referencia, p.estado_pago, p.estado AS estado_registro_pago,
                    d.cod_detallepago, d.referencia AS ref_detalle,
                    d.monto AS monto_ingresado_original,
                    d.cod_metodopago, d.cod_banco, m.nombre AS metodo_pago,
                    mo.cod_moneda, mo.abreviatura AS moneda_metodo,
                    b.nombre AS banco_nombre,
                    cm_met.tasa AS tasa_moneda_metodo,
                    cm_met.fecha AS fecha_tasa_moneda_metodo,
                    cm_usd.tasa AS tasa_usd_ref,
                    cm_usd.fecha AS fecha_tasa_usd_ref
                FROM pago p
                LEFT JOIN detalle_pago d ON p.cod_detallepago = d.cod_detallepago
                LEFT JOIN metodo_pago m ON d.cod_metodopago = m.cod_metodo
                LEFT JOIN moneda mo ON m.cod_moneda = mo.cod_moneda
                LEFT JOIN banco b ON d.cod_banco = b.cod_banco
                LEFT JOIN cambio_moneda cm_met ON cm_met.cod_cambio = (
                    SELECT cm.cod_cambio FROM cambio_moneda cm
                    WHERE cm.cod_moneda = m.cod_moneda AND cm.estado = 1
                    ORDER BY (DATE(cm.fecha) <= p.fecha) DESC, cm.fecha DESC, cm.cod_cambio DESC LIMIT 1
                )
                LEFT JOIN cambio_moneda cm_usd ON cm_usd.cod_cambio = (
                    SELECT cm.cod_cambio FROM cambio_moneda cm
                    INNER JOIN moneda mo_usd ON cm.cod_moneda = mo_usd.cod_moneda
                    WHERE UPPER(TRIM(mo_usd.abreviatura)) = 'USD' AND cm.estado = 1
                    ORDER BY (DATE(cm.fecha) <= p.fecha) DESC, cm.fecha DESC, cm.cod_cambio DESC LIMIT 1
                )
                WHERE p.cod_envio = ?
                ORDER BY p.cod_pago ASC"
            );
            $stmtPagos->execute([$codEnvioLimpio]);
            $pagos = $stmtPagos->fetchAll(\PDO::FETCH_ASSOC);

            $montoTotalEnvio = $envio ? (float)$envio['monto_total'] : 0.0;
            $acumuladoActivo = 0.0;

            foreach ($pagos as &$pagoItem) {
                $esActivo = ((int)$pagoItem['estado_registro_pago'] === 1);
                $montoUsd = (float)$pagoItem['monto_abonado_usd'];
                $monedaAb = strtoupper(trim((string)($pagoItem['moneda_metodo'] ?? 'USD')));
                $tasaUsdRef = (isset($pagoItem['tasa_usd_ref']) && (float)$pagoItem['tasa_usd_ref'] > 0)
                    ? (float)$pagoItem['tasa_usd_ref']
                    : 1.00;
                $tasaMetodo = (isset($pagoItem['tasa_moneda_metodo']) && (float)$pagoItem['tasa_moneda_metodo'] > 0)
                    ? (float)$pagoItem['tasa_moneda_metodo']
                    : 1.00;

                $pagoItem['tasa_usd_dia'] = $tasaUsdRef;

                if ($monedaAb === 'USD') {
                    $pagoItem['tasa_referencia'] = 1.00;
                    $pagoItem['unidad_tasa'] = 'USD';
                    $pagoItem['fecha_tasa'] = null;
                } elseif ($monedaAb === 'VES') {
                    $pagoItem['tasa_referencia'] = $tasaUsdRef;
                    $pagoItem['unidad_tasa'] = 'VES/USD';
                    $pagoItem['fecha_tasa'] = $pagoItem['fecha_tasa_usd_ref'] ?? null;
                } else {
                    $pagoItem['tasa_referencia'] = $tasaMetodo;
                    $pagoItem['unidad_tasa'] = 'VES/' . $monedaAb;
                    $pagoItem['fecha_tasa'] = $pagoItem['fecha_tasa_moneda_metodo'] ?? null;
                }

                if ($esActivo) {
                    $acumuladoActivo = round($acumuladoActivo + $montoUsd, 2);
                }

                $pagoItem['saldo_restante_tras_pago'] = max(0, round($montoTotalEnvio - $acumuladoActivo, 2));
            }
            unset($pagoItem);

            return [
                'envio' => $envio ?: null,
                'remitente' => $remitente ?: null,
                'pagos' => $pagos
            ];
        } catch (\PDOException $e) {
            return ['envio' => null, 'remitente' => null, 'pagos' => []];
        }
    }

    public function obt_TasasDelDia()
    {
        try {
            $sentencia = "SELECT m.abreviatura, c.tasa, c.fecha FROM cambio_moneda c
                        INNER JOIN moneda m ON c.cod_moneda = m.cod_moneda WHERE c.estado = 1
                        ORDER BY c.fecha DESC, c.cod_cambio DESC";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();

            $tasas = ['VES' => 1];
            while ($row = $select->fetch(\PDO::FETCH_ASSOC)) {
                $abrev = strtoupper(trim((string)$row['abreviatura']));
                $tasaVal = (float)$row['tasa'];
                if ($abrev !== '' && $tasaVal > 0 && !isset($tasas[$abrev])) {
                    $tasas[$abrev] = $tasaVal;
                }
            }
            $tasas['VES'] = 1;
            if (!isset($tasas['USD']) || $tasas['USD'] <= 0) {
                $tasas['USD'] = 1;
            }
            return $tasas;
        } catch (\PDOException $e) {
            return ['VES' => 1, 'USD' => 1];
        }
    }

    public function obt_BancosActivos()
    {
        try {
            $select = $this->conexion->prepare("SELECT * FROM banco WHERE estado = 1");
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function obt_MetodosPagoActivos()
    {
        try {
            $select = $this->conexion->prepare("SELECT mp.*, m.abreviatura FROM metodo_pago mp INNER JOIN moneda m ON mp.cod_moneda = m.cod_moneda WHERE mp.estado = 1");
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    private function validarCamposComunesPago($fecha, $montoUsd, $montoOriginal, $referencia, $codMetodo, $codBanco)
    {
        $dt = \DateTime::createFromFormat('Y-m-d', (string)$fecha);
        if (!$dt || $dt->format('Y-m-d') !== (string)$fecha) {
            return json_encode(['status' => 'error', 'message' => 'La fecha del pago no tiene un formato válido.']);
        }

        if (!is_numeric($montoUsd) || !is_numeric($montoOriginal) || (float)$montoUsd <= 0 || (float)$montoOriginal <= 0) {
            return json_encode(['status' => 'error', 'message' => 'El monto ingresado no es válido.']);
        }

        if ((float)$montoOriginal > 999999.99 || (float)$montoUsd > 999999.99) {
            return json_encode(['status' => 'error', 'message' => 'El monto supera el límite permitido.']);
        }

        foreach ([$montoUsd, $montoOriginal] as $montoVal) {
            $val = $this->ExplorarDatos(['numeros-decimales' => $montoVal]);
            if ($val !== true) return $val;
        }

        $valMetodo = $this->ExplorarDatos(['solo-numeros' => $codMetodo]);
        if ($valMetodo !== true) return $valMetodo;

        $stmtMet = $this->conexion->prepare("SELECT nombre FROM metodo_pago WHERE cod_metodo = ? AND estado = 1 LIMIT 1");
        $stmtMet->execute([(int)$codMetodo]);
        $nombreMetodo = $stmtMet->fetchColumn();
        if (!$nombreMetodo) {
            return json_encode(['status' => 'error', 'message' => 'El método de pago seleccionado no es válido o está inactivo.']);
        }

        if (stripos((string)$nombreMetodo, 'efectivo') !== false) {
            return ['ok' => true, 'referencia' => null, 'cod_banco' => null];
        }

        if ($codBanco === null || $codBanco === '' || in_array(strtoupper((string)$codBanco), ['0', 'N/A'], true)) {
            return json_encode(['status' => 'error', 'message' => 'Seleccione una cuenta destino.']);
        }

        $valBanco = $this->ExplorarDatos(['solo-numeros' => $codBanco]);
        if ($valBanco !== true) return $valBanco;

        $stmtBan = $this->conexion->prepare("SELECT nombre FROM banco WHERE cod_banco = ? AND estado = 1 LIMIT 1");
        $stmtBan->execute([(int)$codBanco]);
        if (!$stmtBan->fetchColumn()) {
            return json_encode(['status' => 'error', 'message' => 'La cuenta o banco seleccionado no es válido o está inactivo.']);
        }

        $refTrim = trim((string)$referencia);
        if ($refTrim === '' || in_array(strtoupper($refTrim), ['N/A', '0'], true)) {
            return json_encode(['status' => 'error', 'message' => 'La referencia es obligatoria.']);
        }

        $valRef = $this->ExplorarDatos(['solo-numeros' => $refTrim]);
        if ($valRef !== true) return $valRef;

        return [
            'ok' => true,
            'referencia' => (int)$refTrim,
            'cod_banco' => (int)$codBanco
        ];
    }

    public function verificarPagoCompletado($cod_envio)
    {
        $monto_total = $this->obtenerMontoTotalEnvio((int)$cod_envio);
        $total_abonado = $this->obtenerTotalAbonadoEnvio((int)$cod_envio);
        return round($total_abonado, 2) >= round($monto_total, 2);
    }

    public function verificarReferenciaDuplicada($referencia, $cod_pago_actual = null)
    {
        if ($referencia === null || trim((string)$referencia) === '') {
            return false;
        }

        if ($cod_pago_actual !== null && $cod_pago_actual !== '') {
            $count = $this->conexion->prepare("SELECT COUNT(*) FROM pago WHERE referencia = ? AND cod_pago != ? AND estado = 1");
            $count->execute([$referencia, (int)$cod_pago_actual]);
        } else {
            $count = $this->conexion->prepare("SELECT COUNT(*) FROM pago WHERE referencia = ? AND estado = 1");
            $count->execute([$referencia]);
        }
        return (int)$count->fetchColumn() > 0;
    }

    private function insertarMovimientoPago(
        string $fecha,
        string $hora,
        float $montoUsd,
        float $montoOriginal,
        $referencia,
        int $codEnvio,
        int $codMetodo,
        $codBanco,
        int $estadoPago,
        string $mensajeExito
    ): string {
        try {
            $this->conexion->beginTransaction();

            $insertDetalle = $this->conexion->prepare(
                "INSERT INTO detalle_pago (referencia, cod_metodopago, cod_banco, monto) VALUES (?, ?, ?, ?)"
            );
            $insertDetalle->execute([$referencia, $codMetodo, $codBanco, $montoOriginal]);
            $codDetalle = $this->conexion->lastInsertId();

            $insertPago = $this->conexion->prepare(
                "INSERT INTO pago (fecha, hora, monto, referencia, estado_pago, cod_envio, estado, cod_detallepago) VALUES (?, ?, ?, ?, ?, ?, 1, ?)"
            );
            $insertPago->execute([
                $fecha,
                $hora,
                $montoUsd,
                $referencia,
                $estadoPago,
                $codEnvio,
                $codDetalle
            ]);

            $this->sincronizarEstatusPagosEnvio($codEnvio);

            $this->conexion->commit();
            return json_encode(['status' => 'success', 'message' => $mensajeExito]);
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function regDatosPago(array $campos, $hora)
    {
        $camposPosicionales = $this->prepararCamposDesdePayload($campos, false);
        $resultadoTrait = $this->validarPost($camposPosicionales);
        if (!is_array($resultadoTrait)) {
            return $resultadoTrait;
        }

        [$fecha, $montoUsd, $montoOriginal, $referencia, $codEnvio, $codMetodo, $codBanco] = $resultadoTrait;

        $valEnv = $this->ExplorarDatos(['solo-numeros' => $codEnvio]);
        if ($valEnv !== true) return $valEnv;

        $stmtEnv = $this->conexion->prepare("SELECT monto_total, estado, estatus FROM envio WHERE cod_envio = ? LIMIT 1");
        $stmtEnv->execute([(int)$codEnvio]);
        $envio = $stmtEnv->fetch(\PDO::FETCH_ASSOC);
        if (!$envio) {
            return json_encode(['status' => 'error', 'message' => 'El envío indicado no existe.']);
        }
        if ((int)$envio['estado'] === 0 || strtoupper((string)$envio['estatus']) === 'ANULADO') {
            return json_encode(['status' => 'error', 'message' => 'No se pueden registrar pagos a un envío anulado.']);
        }

        $validacion = $this->validarCamposComunesPago($fecha, $montoUsd, $montoOriginal, $referencia, $codMetodo, $codBanco);
        if (is_string($validacion)) {
            return $validacion;
        }

        if ($this->verificarPagoCompletado((int)$codEnvio)) {
            return json_encode(['status' => 'error', 'message' => 'El pago del envío ya fue completado previamente al 100%.']);
        }

        $abonadoActual = $this->obtenerTotalAbonadoEnvio((int)$codEnvio);
        $restanteActual = round((float)$envio['monto_total'] - $abonadoActual, 2);

        if (round((float)$montoUsd, 2) > $restanteActual) {
            return json_encode(['status' => 'error', 'message' => 'El monto abonado supera el saldo restante del envío.']);
        }

        if ($this->verificarReferenciaDuplicada($validacion['referencia'])) {
            return json_encode(['status' => 'exists', 'message' => 'Ya existe un pago registrado con la referencia bancaria ingresada.']);
        }

        $estadoPago = $this->determinarEstatusPago((int)$codEnvio, (float)$montoUsd);

        return $this->insertarMovimientoPago(
            (string)$fecha,
            (string)$hora,
            (float)$montoUsd,
            (float)$montoOriginal,
            $validacion['referencia'],
            (int)$codEnvio,
            (int)$codMetodo,
            $validacion['cod_banco'],
            $estadoPago,
            'El pago ha sido registrado correctamente.'
        );
    }

    public function regReembolsoPago(array $campos, $hora)
    {
        $camposPosicionales = $this->prepararCamposDesdePayload($campos, false);
        $resultadoTrait = $this->validarPost($camposPosicionales);
        if (!is_array($resultadoTrait)) {
            return $resultadoTrait;
        }

        [$fecha, $montoUsd, $montoOriginal, $referencia, $codEnvio, $codMetodo, $codBanco] = $resultadoTrait;

        $valEnv = $this->ExplorarDatos(['solo-numeros' => $codEnvio]);
        if ($valEnv !== true) return $valEnv;

        $stmtEnv = $this->conexion->prepare("SELECT estado, estatus FROM envio WHERE cod_envio = ? LIMIT 1");
        $stmtEnv->execute([(int)$codEnvio]);
        $envio = $stmtEnv->fetch(\PDO::FETCH_ASSOC);
        if (!$envio) {
            return json_encode(['status' => 'error', 'message' => 'El envío indicado no existe.']);
        }
        if ((int)$envio['estado'] !== 0 && strtoupper((string)$envio['estatus']) !== 'ANULADO') {
            return json_encode(['status' => 'error', 'message' => 'Solo se pueden reembolsar pagos de un envío anulado.']);
        }

        $validacion = $this->validarCamposComunesPago($fecha, $montoUsd, $montoOriginal, $referencia, $codMetodo, $codBanco);
        if (is_string($validacion)) {
            return $validacion;
        }

        $totalAbonado = $this->obtenerTotalAbonadoEnvio((int)$codEnvio);
        if ($totalAbonado <= 0 || round((float)$montoUsd, 2) > round($totalAbonado, 2)) {
            return json_encode(['status' => 'error', 'message' => 'El monto a reembolsar supera el total abonado o no hay saldo disponible.']);
        }

        if ($this->verificarReferenciaDuplicada($validacion['referencia'])) {
            return json_encode(['status' => 'exists', 'message' => 'Ya existe un registro con la referencia bancaria ingresada.']);
        }

        return $this->insertarMovimientoPago(
            (string)$fecha,
            (string)$hora,
            -abs((float)$montoUsd),
            (float)$montoOriginal,
            $validacion['referencia'],
            (int)$codEnvio,
            (int)$codMetodo,
            $validacion['cod_banco'],
            0,
            'El reembolso ha sido procesado correctamente.'
        );
    }

    public function actDatosPago(array $campos, $hora = null)
    {
        $camposPosicionales = $this->prepararCamposDesdePayload($campos, true);
        $resultadoTrait = $this->validarPost($camposPosicionales);
        if (!is_array($resultadoTrait)) {
            return $resultadoTrait;
        }

        [$codPago, $fecha, $montoUsd, $montoOriginal, $referencia, $codDetalle, $codMetodo, $codBanco] = $resultadoTrait;

        foreach ([$codPago, $codDetalle] as $idNum) {
            $valId = $this->ExplorarDatos(['solo-numeros' => $idNum]);
            if ($valId !== true) return $valId;
        }

        $validacion = $this->validarCamposComunesPago($fecha, $montoUsd, $montoOriginal, $referencia, $codMetodo, $codBanco);
        if (is_string($validacion)) {
            return $validacion;
        }

        if ($this->verificarReferenciaDuplicada($validacion['referencia'], $codPago)) {
            return json_encode(['status' => 'exists_ref', 'message' => 'Ya existe otro pago registrado con la referencia bancaria ingresada.']);
        }

        $stmt = $this->conexion->prepare("SELECT cod_envio, fecha, hora FROM pago WHERE cod_pago = ? AND estado = 1 LIMIT 1");
        $stmt->execute([(int)$codPago]);
        $pagoActual = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$pagoActual) {
            return json_encode(['status' => 'error', 'message' => 'No se encontró el pago activo a modificar.']);
        }

        $horaActualBd = trim((string)($pagoActual['hora'] ?? ''));
        $horaBdValida = ($horaActualBd !== '' && $horaActualBd !== '00:00:00');
        $horaLimpiaParam = trim((string)($hora ?? ''));

        $this->cod_pago = (int)$codPago;
        $this->cod_envio = (int)$pagoActual['cod_envio'];
        $this->fecha = !empty($pagoActual['fecha']) ? $pagoActual['fecha'] : $fecha;
        $this->monto = (float)$montoUsd;
        $this->monto_original = (float)$montoOriginal;
        $this->referencia = $validacion['referencia'];
        $this->cod_detallepago = (int)$codDetalle;
        $this->cod_metodopago = (int)$codMetodo;
        $this->cod_banco = $validacion['cod_banco'];
        $this->hora = ($horaLimpiaParam !== '' && $horaLimpiaParam !== '00:00:00')
            ? $horaLimpiaParam
            : ($horaBdValida ? $horaActualBd : date('H:i:s'));
        $this->estado_pago = $this->determinarEstatusPago($this->cod_envio, $this->monto, $this->cod_pago);

        return $this->actualizarPago();
    }

    private function actualizarPago()
    {
        try {
            $this->conexion->beginTransaction();

            $updateDetalle = $this->conexion->prepare(
                "UPDATE detalle_pago SET referencia = ?, cod_metodopago = ?, cod_banco = ?, monto = ? WHERE cod_detallepago = ?"
            );
            $updateDetalle->execute([$this->referencia, $this->cod_metodopago, $this->cod_banco, $this->monto_original, $this->cod_detallepago]);

            $updatePago = $this->conexion->prepare(
                "UPDATE pago SET fecha = ?, hora = ?, monto = ?, referencia = ?, estado_pago = ? WHERE cod_pago = ?"
            );
            $updatePago->execute([$this->fecha, $this->hora, $this->monto, $this->referencia, $this->estado_pago, $this->cod_pago]);

            $this->sincronizarEstatusPagosEnvio($this->cod_envio);

            $this->conexion->commit();
            return json_encode(['status' => 'updated', 'message' => 'El pago ha sido modificado correctamente.']);
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function elmDatosPago(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (!is_array($resultadoTrait)) {
            return $resultadoTrait;
        }

        $valId = $this->ExplorarDatos(['solo-numeros' => $resultadoTrait[0]]);
        if ($valId !== true) return $valId;

        $this->cod_pago = (int)$resultadoTrait[0];

        $stmt = $this->conexion->prepare(
            "SELECT e.cod_envio, e.estado AS estado_envio, e.estatus AS estatus_envio FROM envio e
            INNER JOIN pago p ON e.cod_envio = p.cod_envio WHERE p.cod_pago = ? AND p.estado = 1 LIMIT 1"
        );
        $stmt->execute([$this->cod_pago]);
        $envioPago = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$envioPago) {
            return json_encode(['status' => 'error', 'message' => 'No se encontró el registro de pago activo.']);
        }

        $envioAnulado = ((int)$envioPago['estado_envio'] === 0) || (strtoupper((string)$envioPago['estatus_envio']) === 'ANULADO');
        if (!$envioAnulado) {
            return json_encode(['status' => 'error', 'message' => 'Solo se puede anular un pago cuando el envío asociado ya se encuentra anulado.']);
        }

        $saldoRestante = round($this->obtenerTotalAbonadoEnvio((int)$envioPago['cod_envio']), 2);
        if ($saldoRestante > 0) {
            return json_encode(['status' => 'error', 'message' => 'Primero debe reembolsar el saldo abonado del envío antes de anular este registro de pago.']);
        }

        return $this->eliminarPago();
    }

    private function eliminarPago()
    {
        try {
            $this->conexion->beginTransaction();

            $delete = $this->conexion->prepare("UPDATE pago SET estado = 0 WHERE cod_pago = ?");
            $delete->execute([$this->cod_pago]);

            $this->conexion->commit();
            return json_encode(['status' => 'deleted', 'message' => 'El registro de pago ha sido anulado correctamente.']);
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function sincronizarEstatusPagosEnvio($cod_envio)
    {
        $monto_total = $this->obtenerMontoTotalEnvio((int)$cod_envio);
        $total_abonado = $this->obtenerTotalAbonadoEnvio((int)$cod_envio);
        $nuevo_estatus = (round($total_abonado, 2) >= round($monto_total, 2)) ? 1 : 0;

        $update = $this->conexion->prepare("UPDATE pago SET estado_pago = ? WHERE cod_envio = ? AND estado = 1");
        $update->execute([$nuevo_estatus, (int)$cod_envio]);
    }

    public function determinarEstatusPago($cod_envio, $monto_nuevo, $cod_pago_actual = null)
    {
        $monto_total = $this->obtenerMontoTotalEnvio((int)$cod_envio);
        $total_abonado = $this->obtenerTotalAbonadoEnvio((int)$cod_envio, $cod_pago_actual);
        $total_con_nuevo_pago = round($total_abonado + (float)$monto_nuevo, 2);

        return ($total_con_nuevo_pago >= round($monto_total, 2)) ? 1 : 0;
    }
}