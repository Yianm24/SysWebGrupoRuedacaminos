<?php
namespace App\Model;
use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;
use App\Traits\ExpRegexTrait;

class CambioMoneda extends Conexion
{
    use ValidadorTraitAjax, ExpRegexTrait;

    private $cod_cambio;
    private $tasa;
    private $fecha;
    private $cod_moneda;
    private $estado;

    public function __construct() {
        parent::__construct();
    }

    public function obt_TodasLasMonedas() {
        try {
            $sentencia = "SELECT cod_moneda, nombre, abreviatura FROM moneda WHERE estado = 1 AND abreviatura != 'VES'";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function obtenerFechaPorId($cod_cambio) {
        try {
            $sentencia = "SELECT DATE(fecha) AS fecha_dia FROM cambio_moneda WHERE cod_cambio = ? LIMIT 1";
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->execute([$cod_cambio]);
            $fila = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $fila ? $fila['fecha_dia'] : null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function verificarTasaDuplicada($cod_moneda, $fecha, $id_actual = null) {
        if ($id_actual === null || $id_actual === '') {
            $sentencia = "SELECT COUNT(*) FROM cambio_moneda WHERE cod_moneda = ? AND DATE(fecha) = ?";
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->bindValue(1, $cod_moneda);
            $stmt->bindValue(2, $fecha);
        } else {
            $sentencia = "SELECT COUNT(*) FROM cambio_moneda WHERE cod_moneda = ? AND DATE(fecha) = ? AND cod_cambio != ?";
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->bindValue(1, $cod_moneda);
            $stmt->bindValue(2, $fecha);
            $stmt->bindValue(3, $id_actual);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn() > 0;
    }

    private function contarTasasActivasMoneda($cod_moneda, $excluir_cod_cambio = null) {
        try {
            if ($excluir_cod_cambio === null || $excluir_cod_cambio === '') {
                $sql = "SELECT COUNT(*) FROM cambio_moneda WHERE cod_moneda = ? AND estado = 1";
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute([$cod_moneda]);
            } else {
                $sql = "SELECT COUNT(*) FROM cambio_moneda WHERE cod_moneda = ? AND estado = 1 AND cod_cambio != ?";
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute([$cod_moneda, $excluir_cod_cambio]);
            }
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }

    public function verificarUsoEnPagos($cod_cambio) {
        try {
            $stmt = $this->conexion->prepare("SELECT cod_cambio, cod_moneda, fecha FROM cambio_moneda WHERE cod_cambio = ? LIMIT 1");
            $stmt->execute([$cod_cambio]);
            $cambio = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$cambio) {
                return false;
            }

            $sql = "SELECT COUNT(*)
                    FROM pago p
                    INNER JOIN detalle_pago dp ON p.cod_detallepago = dp.cod_detallepago
                    INNER JOIN metodo_pago mp ON dp.cod_metodopago = mp.cod_metodo
                    WHERE mp.cod_moneda = ?
                        AND DATE(p.fecha) = DATE(?)
                        AND p.estado = 1";
            $check = $this->conexion->prepare($sql);
            $check->execute([(int)$cambio['cod_moneda'], $cambio['fecha']]);
            return (int)$check->fetchColumn() > 0;
        } catch (\PDOException $e) {
            return true;
        }
    }

    public function obt_RegistrosCambiosServerSide() {
        try {
            $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
            $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
            $length = isset($_POST['length']) ? intval($_POST['length']) : 5;
            $searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

            $columnas = [
                0 => 'c.fecha',
                1 => 'c.fecha',
                2 => 'm.abreviatura',
                3 => 'c.tasa',
                4 => 'c.estado'
            ];

            $orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
            $orderColumn = $columnas[$orderColumnIndex] ?? 'c.fecha';
            $orderDir = (isset($_POST['order'][0]['dir']) && strtoupper($_POST['order'][0]['dir']) === 'ASC') ? 'ASC' : 'DESC';

            $sqlBase = " FROM cambio_moneda AS c
                        INNER JOIN moneda AS m ON c.cod_moneda = m.cod_moneda";

            $stmtTotal = $this->conexion->query("SELECT COUNT(*) AS total " . $sqlBase);
            $recordsTotal = (int) $stmtTotal->fetch(\PDO::FETCH_ASSOC)['total'];

            $sqlSearch = "";
            $params = [];

            if ($searchValue !== '') {
                // Normaliza separadores decimales (. y ,) y espacios alrededor de ':' o AM/PM
                $busquedaNormalizada = preg_replace('/\s+/', ' ', $searchValue);
                $busquedaPunto = str_replace(',', '.', $busquedaNormalizada);
                $busquedaComa = str_replace('.', ',', $busquedaNormalizada);
                $busquedaHoraLimpia = preg_replace('/\s*(am|pm)\s*/i', ' $1', trim($busquedaNormalizada));

                $sqlSearch = " WHERE (
                    m.abreviatura LIKE :search
                    OR m.nombre LIKE :search
                    OR CAST(c.tasa AS CHAR) LIKE :search_punto
                    OR REPLACE(CAST(c.tasa AS CHAR), '.', ',') LIKE :search_coma
                    OR DATE_FORMAT(c.fecha, '%d/%m/%Y') LIKE :search
                    OR DATE_FORMAT(c.fecha, '%H:%i:%s') LIKE :search_hora
                    OR DATE_FORMAT(c.fecha, '%H:%i') LIKE :search_hora
                    OR DATE_FORMAT(c.fecha, '%h:%i %p') LIKE :search_hora
                    OR DATE_FORMAT(c.fecha, '%l:%i %p') LIKE :search_hora
                    OR DATE_FORMAT(c.fecha, '%p') LIKE :search_hora
                ) ";

                $params[':search'] = "%{$busquedaNormalizada}%";
                $params[':search_punto'] = "%{$busquedaPunto}%";
                $params[':search_coma'] = "%{$busquedaComa}%";
                $params[':search_hora'] = "%{$busquedaHoraLimpia}%";
            }

            $stmtFiltered = $this->conexion->prepare("SELECT COUNT(*) AS total " . $sqlBase . $sqlSearch);
            foreach ($params as $key => $val) {
                $stmtFiltered->bindValue($key, $val, \PDO::PARAM_STR);
            }
            $stmtFiltered->execute();
            $recordsFiltered = (int) $stmtFiltered->fetch(\PDO::FETCH_ASSOC)['total'];

            $orderClause = " ORDER BY c.estado DESC, {$orderColumn} {$orderDir} ";
            if ($orderColumnIndex === 4) {
                $orderClause = " ORDER BY {$orderColumn} {$orderDir}, c.fecha DESC ";
            }

            $sqlData = "SELECT c.cod_cambio, c.cod_moneda, c.tasa, c.fecha, c.estado, m.abreviatura,
                            (
                                SELECT c2.tasa FROM cambio_moneda AS c2
                                WHERE c2.cod_moneda = c.cod_moneda AND c2.estado = 1
                                AND c2.fecha < c.fecha ORDER BY c2.fecha DESC LIMIT 1
                            ) AS tasa_anterior
                        " . $sqlBase
                        . $sqlSearch
                        . $orderClause;

            if ($length != -1) {
                $sqlData .= " LIMIT :start, :length";
            }

            $stmtData = $this->conexion->prepare($sqlData);
            foreach ($params as $key => $val) {
                $stmtData->bindValue($key, $val, \PDO::PARAM_STR);
            }

            if ($length != -1) {
                $stmtData->bindValue(':start', $start, \PDO::PARAM_INT);
                $stmtData->bindValue(':length', $length, \PDO::PARAM_INT);
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

    public function regDatosCambio(array $campos) {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            date_default_timezone_set('America/Caracas');
            $fecha_actual = date('Y-m-d');

            if ($this->verificarTasaDuplicada($resultadoTrait[1], $fecha_actual)) {
                return json_encode(['status' => 'exists', 'message' => 'Esta moneda ya posee una tasa registrada el día de hoy.']);
            }

            if (strlen($resultadoTrait[0]) < 1 || strlen($resultadoTrait[0]) > 10) {
                return json_encode(['status' => 'error', 'message' => 'La tasa supera el límite numérico permitido.']);
            }
            $valTasa = $this->ExplorarDatos(['numeros-decimales' => $resultadoTrait[0]]);
            if ($valTasa !== true) return $valTasa;

            $valMoneda = $this->ExplorarDatos(['solo-numeros' => $resultadoTrait[1]]);
            if ($valMoneda !== true) return $valMoneda;

            $this->tasa = $resultadoTrait[0];
            $this->cod_moneda = $resultadoTrait[1];
            $this->fecha = date('Y-m-d H:i:s');
            $this->estado = 1;
        } else {
            return $resultadoTrait;
        }
        return $this->registrarCambio();
    }

    private function registrarCambio() {
        try {
            $sentencia = "INSERT INTO cambio_moneda (tasa, fecha, cod_moneda, estado) VALUES (?, ?, ?, ?)";
            $insert = $this->conexion->prepare($sentencia);
            $insert->bindValue(1, $this->tasa);
            $insert->bindValue(2, $this->fecha);
            $insert->bindValue(3, $this->cod_moneda);
            $insert->bindValue(4, $this->estado);
            $insert->execute();
            return json_encode(['status' => 'success', 'message' => 'La tasa de cambio ha sido registrada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function actDatosCambio(array $campos) {
        $codCambioEntrada = $campos[0] ?? '';
        $tasaEntrada = $campos[1] ?? '';
        $monedaEntrada = $campos[2] ?? '';
        $estadoEntrada = $campos[3] ?? '1';

        $resultadoTrait = $this->validarPost([$codCambioEntrada, $tasaEntrada, $monedaEntrada]);
        if (is_array($resultadoTrait)) {
            $codCambio = $resultadoTrait[0];
            $tasa = $resultadoTrait[1];
            $moneda = $resultadoTrait[2];
            $estadoRecibido = is_numeric($estadoEntrada) ? (int)$estadoEntrada : 1;

            if (!in_array($estadoRecibido, [0, 1], true)) {
                return json_encode(['status' => 'error', 'message' => 'El estatus seleccionado no es válido.']);
            }

            if ($estadoRecibido === 0) {
                if ($this->verificarUsoEnPagos($codCambio)) {
                    return json_encode([
                        'status' => 'error',
                        'message' => 'No se puede inactivar esta tasa porque ya fue usada en cálculos dentro de pagos.'
                    ]);
                }
                if ($this->contarTasasActivasMoneda($moneda, $codCambio) < 1) {
                    return json_encode([
                        'status' => 'error',
                        'message' => 'No se puede inactivar esta tasa, debe existir al menos una tasa de cambio activa para esta moneda.'
                    ]);
                }
            }

            $fechaRegistro = $this->obtenerFechaPorId($codCambio);
            if (!empty($fechaRegistro) && $this->verificarTasaDuplicada($moneda, $fechaRegistro, $codCambio)) {
                return json_encode(['status' => 'exists', 'message' => 'Esta moneda ya posee otra tasa registrada en esa fecha.']);
            }

            if (strlen($tasa) < 1 || strlen($tasa) > 10) {
                return json_encode(['status' => 'error', 'message' => 'La tasa supera el límite numérico permitido.']);
            }
            $valTasa = $this->ExplorarDatos(['numeros-decimales' => $tasa]);
            if ($valTasa !== true) return $valTasa;

            $valMoneda = $this->ExplorarDatos(['solo-numeros' => $moneda]);
            if ($valMoneda !== true) return $valMoneda;

            $this->cod_cambio = $codCambio;
            $this->tasa = $tasa;
            $this->cod_moneda = $moneda;
            $this->estado = $estadoRecibido;
        } else {
            return $resultadoTrait;
        }
        return $this->actualizarCambio();
    }

    private function actualizarCambio() {
        try {
            $sentencia = "UPDATE cambio_moneda SET tasa = ?, cod_moneda = ?, estado = ? WHERE cod_cambio = ?";
            $update = $this->conexion->prepare($sentencia);
            $update->bindValue(1, $this->tasa);
            $update->bindValue(2, $this->cod_moneda);
            $update->bindValue(3, $this->estado);
            $update->bindValue(4, $this->cod_cambio);
            $update->execute();
            return json_encode(['status' => 'updated', 'message' => 'La tasa de cambio ha sido modificada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function elmDatosCambio(array $campos) {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $this->cod_cambio = $resultadoTrait[0];

            if ($this->verificarUsoEnPagos($this->cod_cambio)) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'No se puede eliminar esta tasa de cambio porque ya fue usada en cálculos dentro de pagos.'
                ]);
            }

            $stmt = $this->conexion->prepare("SELECT cod_moneda FROM cambio_moneda WHERE cod_cambio = ? LIMIT 1");
            $stmt->execute([$this->cod_cambio]);
            $fila = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($fila && $this->contarTasasActivasMoneda($fila['cod_moneda'], $this->cod_cambio) < 1) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'No se puede eliminar esta tasa, debe existir al menos una tasa de cambio activa para esta moneda.'
                ]);
            }
        } else {
            return $resultadoTrait;
        }
        return $this->eliminarCambio();
    }

    private function eliminarCambio() {
        try {
            $sentencia = "UPDATE cambio_moneda SET estado = 0 WHERE cod_cambio = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->bindValue(1, $this->cod_cambio);
            $delete->execute();
            return json_encode(['status' => 'deleted', 'message' => 'La tasa de cambio ha sido eliminada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}
?>