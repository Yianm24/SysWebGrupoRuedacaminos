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

    public function obt_RegistrosPago()
    {
        try {
            $sentencia = "SELECT e.cod_envio, e.monto_total, e.estado as estado_envio, p.cod_pago, p.fecha, p.hora, p.referencia, p.estado_pago, d.cod_detallepago, d.referencia as ref_detalle, p.monto as monto_abonado_usd, d.monto as monto_ingresado_original, m.nombre as metodo_pago, b.nombre as banco_nombre, d.cod_metodopago, d.cod_banco, (SELECT SUM(p2.monto) FROM pago p2 WHERE p2.cod_envio = e.cod_envio AND p2.estado = 1) as total_abonado_envio FROM envio e LEFT JOIN pago p ON e.cod_envio = p.cod_envio AND p.estado = 1 LEFT JOIN detalle_pago d ON p.cod_detallepago = d.cod_detallepago LEFT JOIN metodo_pago m ON d.cod_metodopago = m.cod_metodo LEFT JOIN banco b ON d.cod_banco = b.cod_banco WHERE e.estado = 1 ORDER BY e.cod_envio DESC, p.cod_pago DESC";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function obt_TasasDelDia()
    {
        try {
            $sentencia = "SELECT m.abreviatura, c.tasa FROM cambio_moneda c INNER JOIN moneda m ON c.cod_moneda = m.cod_moneda WHERE c.estado = 1 ORDER BY c.fecha ASC";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
        
            $tasas = ['VES' => 1]; 
            while($row = $select->fetch(\PDO::FETCH_ASSOC)) {
                $tasas[$row['abreviatura']] = (float)$row['tasa'];
            }
            return $tasas;
        } catch (\PDOException $e) {
            return ['VES' => 1, 'USD' => 1];
        }
    }

    public function obt_BancosActivos()
    {
        try {
            $sentencia = "SELECT * FROM banco WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function obt_MetodosPagoActivos()
    {
        try {
            $sentencia = "SELECT mp.*, m.abreviatura FROM metodo_pago mp INNER JOIN moneda m ON mp.cod_moneda = m.cod_moneda WHERE mp.estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function verificarPagoCompletado($cod_envio)
    {
        $stmtEnvio = $this->conexion->prepare("SELECT monto_total FROM envio WHERE cod_envio = ?");
        $stmtEnvio->execute([$cod_envio]);
        $monto_total = (float) $stmtEnvio->fetchColumn();

        $stmtPagos = $this->conexion->prepare("SELECT SUM(monto) FROM pago WHERE cod_envio = ? AND estado = 1");
        $stmtPagos->execute([$cod_envio]);
        $total_abonado = (float) $stmtPagos->fetchColumn();
        return round($total_abonado, 2) >= round($monto_total, 2);
    }

    public function verificarReferenciaDuplicada($referencia, $cod_pago_actual = null)
    {
        if (strtoupper(trim($referencia)) === 'EFECTIVO' || strtoupper(trim($referencia)) === 'S/N') {
            return false;
        }

        if ($cod_pago_actual) {
            $sentencia = "SELECT COUNT(*) FROM pago WHERE referencia = ? AND cod_pago != ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1, $referencia);
            $count->bindValue(2, $cod_pago_actual);
        } else {
            $sentencia = "SELECT COUNT(*) FROM pago WHERE referencia = ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1, $referencia);
        }
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function regDatosPago(array $campos, $hora, $estatus_calculado)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $this->fecha = $resultadoTrait[0];
            $this->monto = $resultadoTrait[1];
            $this->monto_original = $resultadoTrait[2];
            $this->referencia = $resultadoTrait[3];
            $this->cod_envio = $resultadoTrait[4];
            $this->cod_metodopago = $resultadoTrait[5];
            $this->cod_banco = $resultadoTrait[6];

            // Validaciones con ExpRegexTrait
            if (!is_numeric($this->monto_original)) {
                return json_encode(['status' => 'error', 'message' => "El campo monto no tiene un formato válido."]);
            }

            $this->hora = $hora;
            $this->estado_pago = $estatus_calculado;
            $this->estado = 1;
        } else {
            return $resultadoTrait;
        }
        return $this->registrarPago();
    }

    private function registrarPago()
    {
        try {
            $this->conexion->beginTransaction();
            
            $sqlDetalle = "INSERT INTO detalle_pago (referencia, cod_metodopago, cod_banco, monto) VALUES (?, ?, ?, ?)";
            $insertDetalle = $this->conexion->prepare($sqlDetalle);
            $insertDetalle->execute([$this->referencia, $this->cod_metodopago, $this->cod_banco, $this->monto_original]);
            $this->cod_detallepago = $this->conexion->lastInsertId();

            $sqlPago = "INSERT INTO pago (fecha, hora, monto, referencia, estado_pago, cod_envio, estado, cod_detallepago) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $insertPago = $this->conexion->prepare($sqlPago);
            $insertPago->execute([$this->fecha, $this->hora, $this->monto, $this->referencia, $this->estado_pago, $this->cod_envio, $this->estado, $this->cod_detallepago]);

            $this->sincronizarEstatusPagosEnvio($this->cod_envio);

            $this->conexion->commit();
            return 'success';
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function actDatosPago(array $campos, $hora, $estatus_calculado)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $this->cod_pago = $resultadoTrait[0];
            $this->fecha = $resultadoTrait[1];
            $this->monto = $resultadoTrait[2];
            $this->monto_original = $resultadoTrait[3];
            $this->referencia = $resultadoTrait[4];
            $this->cod_detallepago = $resultadoTrait[5];
            $this->cod_metodopago = $resultadoTrait[6];
            $this->cod_banco = $resultadoTrait[7];

            if (!is_numeric($this->monto_original)) {
                return json_encode(['status' => 'error', 'message' => "El campo monto no tiene un formato válido."]);
            }

            $this->hora = $hora;
            $this->estado_pago = $estatus_calculado;
        } else {
            return $resultadoTrait;
        }
        return $this->actualizarPago();
    }

    private function actualizarPago()
    {
        try {
            $this->conexion->beginTransaction();
            $sqlDetalle = "UPDATE detalle_pago SET referencia = ?, cod_metodopago = ?, cod_banco = ?, monto = ? WHERE cod_detallepago = ?";
            $updateDetalle = $this->conexion->prepare($sqlDetalle);
            $updateDetalle->execute([$this->referencia, $this->cod_metodopago, $this->cod_banco, $this->monto_original, $this->cod_detallepago]);

            $sqlPago = "UPDATE pago SET fecha = ?, hora = ?, monto = ?, referencia = ?, estado_pago = ? WHERE cod_pago = ?";
            $updatePago = $this->conexion->prepare($sqlPago);
            $updatePago->execute([$this->fecha, $this->hora, $this->monto, $this->referencia, $this->estado_pago, $this->cod_pago]);

            $stmt = $this->conexion->prepare("SELECT cod_envio FROM pago WHERE cod_pago = ?");
            $stmt->execute([$this->cod_pago]);
            $cod_envio = $stmt->fetchColumn();
            if ($cod_envio) {
                $this->sincronizarEstatusPagosEnvio($cod_envio);
            }

            $this->conexion->commit();
            return 'updated';
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
        if (is_array($resultadoTrait)) {
            $this->cod_pago = $resultadoTrait[0];

            $stmt = $this->conexion->prepare("SELECT e.estado FROM envio e INNER JOIN pago p ON e.cod_envio = p.cod_envio WHERE p.cod_pago = ?");
            $stmt->execute([$this->cod_pago]);
            $estado_envio = $stmt->fetchColumn();

            if ($estado_envio != 0) {
                return json_encode(['status' => 'pending_error', 'message' => 'No se puede anular este pago porque el envío asociado no ha sido anulado.']);
            }
        } else {
            return $resultadoTrait;
        }
        return $this->eliminarPago();
    }

    private function eliminarPago()
    {
        try {
            $this->conexion->beginTransaction();
            $stmt = $this->conexion->prepare("SELECT cod_envio FROM pago WHERE cod_pago = ?");
            $stmt->execute([$this->cod_pago]);
            $cod_envio_afectado = $stmt->fetchColumn();

            $sentencia = "UPDATE pago SET estado = 0 WHERE cod_pago = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->bindValue(1, $this->cod_pago);
            $delete->execute();

            if ($cod_envio_afectado) {
                $this->sincronizarEstatusPagosEnvio($cod_envio_afectado);
            }

            $this->conexion->commit();
            return 'deleted';
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function sincronizarEstatusPagosEnvio($cod_envio) {
        $stmtEnvio = $this->conexion->prepare("SELECT monto_total FROM envio WHERE cod_envio = ?");
        $stmtEnvio->execute([$cod_envio]);
        $monto_total = (float) $stmtEnvio->fetchColumn();
        $stmtPagos = $this->conexion->prepare("SELECT SUM(monto) FROM pago WHERE cod_envio = ? AND estado = 1");
        $stmtPagos->execute([$cod_envio]);
        $total_abonado = (float) $stmtPagos->fetchColumn();
        $nuevo_estatus = (round($total_abonado, 2) >= round($monto_total, 2)) ? 1 : 0;
        $update = $this->conexion->prepare("UPDATE pago SET estado_pago = ? WHERE cod_envio = ? AND estado = 1");
        $update->execute([$nuevo_estatus, $cod_envio]);
    }

    public function determinarEstatusPago($cod_envio, $monto_nuevo, $cod_pago_actual = null)
    {
        $stmtEnvio = $this->conexion->prepare("SELECT monto_total FROM envio WHERE cod_envio = ?");
        $stmtEnvio->execute([$cod_envio]);
        $monto_total = (float) $stmtEnvio->fetchColumn();

        $sqlPagos = "SELECT SUM(p.monto) FROM pago p INNER JOIN detalle_pago dp ON p.cod_detallepago = dp.cod_detallepago WHERE p.cod_envio = ? AND p.estado = 1";
        
        if ($cod_pago_actual) {
            $sqlPagos .= " AND p.cod_pago != ?";
            $stmtPagos = $this->conexion->prepare($sqlPagos);
            $stmtPagos->execute([$cod_envio, $cod_pago_actual]);
        } else {
            $stmtPagos = $this->conexion->prepare($sqlPagos);
            $stmtPagos->execute([$cod_envio]);
        }
        
        $total_abonado = (float) $stmtPagos->fetchColumn();
        $total_con_nuevo_pago = round($total_abonado + (float)$monto_nuevo, 2);
        $monto_total_redondeado = round($monto_total, 2);

        if ($total_con_nuevo_pago >= $monto_total_redondeado) {
            return 1; 
        } else {
            return 0; 
        }
    }
}