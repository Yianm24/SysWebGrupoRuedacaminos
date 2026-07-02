<?php
namespace App\Model;
use App\Config\Conexion;

class CambioMoneda extends Conexion
{
    private $cod_cambio;
    private $tasa;
    private $fecha;
    private $cod_moneda;
    private $estado;

    public function __construct() {
        parent::__construct();
    }

    public function verificarTasaDiaExiste($cod_moneda, $fecha) {
        $sentencia = "SELECT COUNT(*) FROM cambio_moneda WHERE cod_moneda = ? AND DATE(fecha) = ? AND estado = 1";
        $stmt = $this->conexion->prepare($sentencia);
        $stmt->bindValue(1, $cod_moneda);
        $stmt->bindValue(2, $fecha);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function regDatosCambio($tasa, $cod_moneda) {
        $this->tasa = $tasa;
        $this->cod_moneda = $cod_moneda;
        $this->fecha = date('Y-m-d H:i:s');
        $this->estado = 1;
        return $this->registrarCambio();
    }

    private function registrarCambio() {
        $sentencia = "INSERT INTO cambio_moneda (tasa, fecha, cod_moneda, estado) VALUES (?, ?, ?, ?)";
        $insert = $this->conexion->prepare($sentencia);
        $insert->bindValue(1, $this->tasa);
        $insert->bindValue(2, $this->fecha);
        $insert->bindValue(3, $this->cod_moneda);
        $insert->bindValue(4, $this->estado);
        return $insert->execute();
    }

    public function obt_RegistrosCambios() {
        $sentencia ="SELECT c.cod_cambio, c.tasa, c.fecha, m.abreviatura 
                    FROM cambio_moneda c 
                    INNER JOIN moneda m ON c.cod_moneda = m.cod_moneda 
                    WHERE c.estado = 1 ORDER BY c.fecha DESC";
        $select = $this->conexion->prepare($sentencia);
        $select->execute();
        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function actDatosCambio($id, $tasa) {
        $this->cod_cambio = $id;
        $this->tasa = $tasa;
        return $this->actualizarCambio();
    }

    private function actualizarCambio() {
        $sentencia = "UPDATE cambio_moneda SET tasa = ? WHERE cod_cambio = ?";
        $update = $this->conexion->prepare($sentencia);
        $update->bindValue(1, $this->tasa);
        $update->bindValue(2, $this->cod_cambio);
        return $update->execute();
    }

    public function elmDatosCambio($id) {
        $this->cod_cambio = $id;
        $this->estado = 0;
        return $this->eliminarCambio();
    }

    private function eliminarCambio() {
        $sentencia = "UPDATE cambio_moneda SET estado = ? WHERE cod_cambio = ?";
        $delete = $this->conexion->prepare($sentencia);
        $delete->bindValue(1, $this->estado);
        $delete->bindValue(2, $this->cod_cambio);
        return $delete->execute();
    }
}
?>