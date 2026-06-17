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

    public function regDatosKilometraje($kilometraje, $monto_tarifa) {
        $this->kilometraje = $kilometraje;
        $this->monto_tarifa = $monto_tarifa;
        $this->estado = 1;
        return $this->registrarKilometraje();
    }

    private function registrarKilometraje() {
        $sentencia = "INSERT INTO precio_kilometraje (kilometraje, monto_tarifa, estado) VALUES (?, ?, ?)";
        $insert = $this->conexion->prepare($sentencia);
        return $insert->execute([$this->kilometraje, $this->monto_tarifa, $this->estado]);
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
        return $this->conexion->prepare($sentencia)->execute([$this->kilometraje, $this->monto_tarifa, $this->cod_preciokilometraje]);
    }

    public function elmDatosKilometraje($id) {
        $this->cod_preciokilometraje = $id;
        $this->estado = 0;
        return $this->eliminarKilometraje();
    }

    private function eliminarKilometraje() {
        $sentencia = "UPDATE precio_kilometraje SET estado = ? WHERE cod_preciokilometraje = ?";
        return $this->conexion->prepare($sentencia)->execute([$this->estado, $this->cod_preciokilometraje]);
    }
}