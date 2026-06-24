<?php
namespace App\Model;
use App\Config\Conexion;

class Kilometraje extends Conexion
{
    private $cod_preciokilometraje;
    private $kilometraje;
    private $monto_tarifa;
    private $estado;

    public function __construct() {
        parent::__construct();
    }

    public function verificarTarifaExiste($kilometraje) {
        $sentencia = "SELECT COUNT(*) FROM precio_kilometraje WHERE kilometraje = ? AND estado = 1";
        $stmt = $this->conexion->prepare($sentencia);
        $stmt->bindValue(1, $kilometraje);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
    public function verificarTarifaDuplicada($kilometraje, $id_actual) {
        $sentencia = "SELECT COUNT(*) FROM precio_kilometraje WHERE kilometraje = ? AND cod_preciokilometraje != ? AND estado = 1";
        $stmt = $this->conexion->prepare($sentencia);
        $stmt->bindValue(1, $kilometraje);
        $stmt->bindValue(2, $id_actual);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function regDatosKilometraje($kilometraje, $monto_tarifa) {
        $this->kilometraje = $kilometraje;
        $this->monto_tarifa = $monto_tarifa;
        $this->estado = 1;
        return $this->registrarKilometraje();
    }

    private function registrarKilometraje() {
        $sentencia = "INSERT INTO precio_kilometraje (kilometraje, monto_tarifa, estado) VALUES (?, ?, ?)";
        $insert = $this->conexion->prepare($sentencia);
        $insert->bindValue(1, $this->kilometraje);
        $insert->bindValue(2, $this->monto_tarifa);
        $insert->bindValue(3, $this->estado);
        return $insert->execute();
    }

    public function obt_RegistrosKilometraje() {
        $sentencia = "SELECT * FROM precio_kilometraje WHERE estado = 1";
        $select = $this->conexion->prepare($sentencia);
        $select->execute();
        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function actDatosKilometraje($id, $kilometraje, $monto_tarifa) {
        $this->cod_preciokilometraje = $id;
        $this->kilometraje = $kilometraje;
        $this->monto_tarifa = $monto_tarifa;
        return $this->actualizarKilometraje();
    }

    private function actualizarKilometraje() {
        $sentencia = "UPDATE precio_kilometraje SET kilometraje = ?, monto_tarifa = ? WHERE cod_preciokilometraje = ?";
        $update = $this->conexion->prepare($sentencia);
        $update->bindValue(1, $this->kilometraje);
        $update->bindValue(2, $this->monto_tarifa);
        $update->bindValue(3, $this->cod_preciokilometraje);

        return $update->execute();
    }

    public function elmDatosKilometraje($id) {
        $this->cod_preciokilometraje = $id;
        $this->estado = 0;
        return $this->eliminarKilometraje();
    }

    private function eliminarKilometraje() {
        $sentencia = "UPDATE precio_kilometraje SET estado = ? WHERE cod_preciokilometraje = ?";
        $delete = $this->conexion->prepare($sentencia);
        $delete->bindValue(1, $this->estado);
        $delete->bindValue(2, $this->cod_preciokilometraje);
        return $delete->execute();
    }
}