<?php

namespace App\Model;

use App\Config\Conexion;

class Moneda extends Conexion
{

    private $cod_moneda;
    private $estado;
    private $nombre;
    private $abreviatura;

    public function __construct()
    {
        parent::__construct();
    }

    public function regDatosMoneda($nombre, $abreviatura)
    {

        $this->nombre = $nombre;
        $this->abreviatura = $abreviatura;
        $this->estado = 1;

        return $this->registrarMoneda();
    }


    private function registrarMoneda()
    {
        try {
            $sentencia = "INSERT INTO moneda (nombre,abreviatura, estado) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->abreviatura);
            $insert->bindValue(3, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el vehiculo: " . $e->getMessage() . "');</script>";
        }
    }
    public function obt_RegistrosMoneda()
    {
        try {
            $sentencia = "SELECT * FROM moneda WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function modDatosMoneda($cod_moneda, $nombre, $abreviatura)
    {
        $this->cod_moneda = $cod_moneda;
        $this->nombre = $nombre;
        $this->abreviatura = $abreviatura;

        return $this->modificarMoneda();
    }

    private function modificarMoneda()
    {
        try {
            $sentencia = "UPDATE `moneda` SET nombre = ?, abreviatura = ? WHERE cod_moneda = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->abreviatura);
            $update->bindValue(3, $this->cod_moneda);

            $update->execute();
        } catch (\PDOException $e) {
            return "Error al actualizar la moneda: " . $e->getMessage();
        }
    }

    public function elmDatosMoneda(int $cod_moneda)
    {
        $this->cod_moneda = $cod_moneda;

        return $this->eliminarMoneda();
    }


    private function eliminarMoneda()
    {
        try {
            $sentencia = "UPDATE `moneda` SET estado = 0 WHERE cod_moneda = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_moneda);
            $delete->execute();

            return "Moneda eliminada exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar la moneda: " . $e->getMessage();
        }
    }
}
