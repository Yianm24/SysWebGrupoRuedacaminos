<?php

namespace App\Model;

use App\Config\Conexion;

class Pago extends Conexion
{
    private $cod_pago;
    private $fecha;
    private $hora;
    private $monto;
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

    // Consultar Registros de Pago y Envío.
    public function obt_RegistrosPago()
    {
        try {
            $sentencia = "SELECT e.cod_envio, e.monto_total, e.estado as estado_envio, p.cod_pago, p.fecha, p.hora, p.referencia, p.estado_pago, d.cod_detallepago, d.referencia as ref_detalle, d.monto as monto_abonado, m.nombre as metodo_pago, b.nombre as banco_nombre, d.cod_metodopago, d.cod_banco, (SELECT SUM(dp2.monto) FROM pago p2 INNER JOIN detalle_pago dp2 ON p2.cod_detallepago = dp2.cod_detallepago WHERE p2.cod_envio = e.cod_envio AND p2.estado = 1) as total_abonado_envio FROM envio e LEFT JOIN pago p ON e.cod_envio = p.cod_envio AND p.estado = 1 LEFT JOIN detalle_pago d ON p.cod_detallepago = d.cod_detallepago LEFT JOIN metodo_pago m ON d.cod_metodopago = m.cod_metodo LEFT JOIN banco b ON d.cod_banco = b.cod_banco WHERE e.estado = 1 ORDER BY e.cod_envio DESC, p.cod_pago DESC";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    // Obtener registros de otras tablas.
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

    //validaciones de pago.
    public function verificarPagoCompletado($cod_envio)
    {
        $sentencia = "SELECT COUNT(*) FROM pago WHERE cod_envio = ? AND estado_pago = 1 AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $cod_envio);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function verificarPagoPendiente($cod_pago)
    {
        $sentencia = "SELECT COUNT(*) FROM pago WHERE cod_pago = ? AND estado_pago = 0 AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $cod_pago);
        $count->execute();
        return $count->fetchColumn() > 0;
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

    // Registrar otros Pagos
    public function regDatosPago($fecha, $hora, $monto, $referencia, $estado_pago, $cod_envio, $cod_metodopago, $cod_banco)
    {
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->monto = $monto;
        $this->referencia = $referencia;
        $this->estado_pago = $estado_pago;
        $this->cod_envio = $cod_envio;
        $this->cod_metodopago = $cod_metodopago;
        $this->cod_banco = $cod_banco;
        $this->estado = 1;

        return $this->registrarPago();
    }

    private function registrarPago()
    {
        try {
            $this->conexion->beginTransaction();
            
            $sqlDetalle = "INSERT INTO detalle_pago (referencia, cod_metodopago, cod_banco, monto) VALUES (?, ?, ?, ?)";
            $insertDetalle = $this->conexion->prepare($sqlDetalle);
            $insertDetalle->execute([$this->referencia, $this->cod_metodopago, $this->cod_banco, $this->monto]);
            $this->cod_detallepago = $this->conexion->lastInsertId();

            $sqlPago = "INSERT INTO pago (fecha, hora, monto, referencia, estado_pago, cod_envio, estado, cod_detallepago) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $insertPago = $this->conexion->prepare($sqlPago);
            $insertPago->execute([$this->fecha, $this->hora, $this->monto, $this->referencia, $this->estado_pago, $this->cod_envio, $this->estado, $this->cod_detallepago]);

            $this->conexion->commit();
            return true;
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }

    // actualizar Pago.
    public function actDatosPago($cod_pago, $fecha, $hora, $monto, $referencia, $estado_pago, $cod_detallepago, $cod_metodopago, $cod_banco)
    {
        $this->cod_pago = $cod_pago;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->monto = $monto;
        $this->referencia = $referencia;
        $this->estado_pago = $estado_pago;
        $this->cod_detallepago = $cod_detallepago;
        $this->cod_metodopago = $cod_metodopago;
        $this->cod_banco = $cod_banco;

        return $this->actualizarPago();
    }

    
    private function actualizarPago()
    {
        try {
            $this->conexion->beginTransaction();
            $sqlDetalle = "UPDATE detalle_pago SET referencia = ?, cod_metodopago = ?, cod_banco = ?, monto = ? WHERE cod_detallepago = ?";
            $updateDetalle = $this->conexion->prepare($sqlDetalle);
            $updateDetalle->execute([$this->referencia, $this->cod_metodopago, $this->cod_banco, $this->monto, $this->cod_detallepago]);

            $sqlPago = "UPDATE pago SET fecha = ?, hora = ?, monto = ?, referencia = ?, estado_pago = ? WHERE cod_pago = ?";
            $updatePago = $this->conexion->prepare($sqlPago);
            $updatePago->execute([$this->fecha, $this->hora, $this->monto, $this->referencia, $this->estado_pago, $this->cod_pago]);

            $this->conexion->commit();
            return true;
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }

    // Eliminar Pago.
    public function elmDatosPago(int $cod_pago)
    {
        $this->cod_pago = $cod_pago;
        $this->estado = 0;

        return $this->eliminarPago();
    }

    private function eliminarPago()
    {
        try {
            $sentencia = "UPDATE pago SET estado = ? WHERE cod_pago = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->bindValue(1, $this->estado);
            $delete->bindValue(2, $this->cod_pago);
            $delete->execute();
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}