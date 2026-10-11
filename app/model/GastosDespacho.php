<?php
namespace App\Model;

use App\Config\Conexion;

class GastosDespacho extends Conexion {
    private $cod_gasto;
    private $cod_despacho;
    private $descripcion;
    private $monto;
    private $fecha_gasto;

    public function __construct() {
        parent::__construct();
    }

    // Setters para Encapsulación
    public function setCodDespacho($cod_despacho) {
        $this->cod_despacho = htmlspecialchars(strip_tags($cod_despacho));
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = htmlspecialchars(strip_tags($descripcion));
    }

    public function setMonto($monto) {
        $this->monto = htmlspecialchars(strip_tags($monto));
    }

    // Método Transaccional (Garantiza atomicidad: si falla, no guarda nada)
    public function registrarGastoTransaccional() {
        try {
            $this->conexion->beginTransaction();

            $sql = "INSERT INTO gastos_despacho (cod_despacho, descripcion, monto, fecha_gasto) VALUES (:cod_despacho, :descripcion, :monto, NOW())";
            $stmt = $this->conexion->prepare($sql);
            
            $stmt->bindParam(':cod_despacho', $this->cod_despacho);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->bindParam(':monto', $this->monto);
            
            $stmt->execute();

            $this->conexion->commit();
            return true;

        } catch (\Exception $e) {
            $this->conexion->rollBack();
            return false;
        }
    }
}
?>