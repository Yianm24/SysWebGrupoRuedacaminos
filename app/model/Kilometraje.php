<?php
namespace App\Model;
use App\Config\Conexion;

class Kilometraje extends Conexion
{
    private $cod_preciokilometraje;
    private $monto_tarifa;
    private $cod_tipovehiculo;
    private $estado;

    public function __construct() {
        parent::__construct();
    }

    public function regDatosKilometraje($cod_tipovehiculo, $monto) {
        $this->cod_tipovehiculo = $cod_tipovehiculo;
        $this->monto_tarifa = $monto;
        return $this->registrarKilometraje();
    }

    private function registrarKilometraje() {
        $sentencia = "INSERT INTO precio_kilometraje (cod_tipovehiculo, monto_tarifa, estado) VALUES (?, ?, 1)";
        $insert = $this->conexion->prepare($sentencia);
        return $insert->execute([$this->cod_tipovehiculo, $this->monto_tarifa]);
    }

    public function verificarTarifaExiste($cod_tipovehiculo) {
        $sentencia = "SELECT COUNT(*) FROM precio_kilometraje WHERE cod_tipovehiculo = ? AND estado = 1";
        $stmt = $this->conexion->prepare($sentencia);
        $stmt->execute([$cod_tipovehiculo]);
        return $stmt->fetchColumn() > 0;
    }

    public function obt_RegistrosKilometraje() {
        $sentencia = "SELECT p.*, t.nombre AS nombre_vehiculo 
                        FROM precio_kilometraje p
                        INNER JOIN tipos_vehiculo t ON t.cod_tipovehiculo = p.cod_tipovehiculo
                        WHERE p.estado = 1";
        $select = $this->conexion->prepare($sentencia);
        $select->execute();
        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function elmDatosKilometraje($id) {
        $sentencia = "UPDATE precio_kilometraje SET estado = 0 WHERE cod_preciokilometraje = ?";
        return $this->conexion->prepare($sentencia)->execute([$id]);
    }

    public function actDatosKilometraje($id, $monto) {
        $sentencia = "UPDATE precio_kilometraje SET monto_tarifa = ? WHERE cod_preciokilometraje = ?";
        return $this->conexion->prepare($sentencia)->execute([$monto, $id]);
    }
}