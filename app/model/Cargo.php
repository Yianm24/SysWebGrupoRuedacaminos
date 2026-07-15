<?php

namespace App\Model;

use App\Config\Conexion;

class Cargo extends Conexion
{

    private $cod_cargo;
    private $estado;
    private $nombre;

    public function __construct()
    {
        parent::__construct();
    }

    public function obt_RegistrosCargo()
    {
        try {
            $sentencia = "SELECT * FROM cargo WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
    
    public function verificarCargoExiste($nombre)
    {
        $sentencia = "SELECT COUNT(*) FROM cargo WHERE nombre = ?  AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->execute();
        return $count->fetchColumn() > 0;
    }
    public function regDatosCargo($nombre)
    {

        $this->nombre = $this->formatearPalabra($nombre);
        $this->estado = 1;

        return $this->registrarCargo();
    }


    private function registrarCargo()
    {
        try {
            $sentencia = "INSERT INTO cargo (nombre, estado) VALUES (?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el cargo: " . $e->getMessage() . "');</script>";
        }
    }


    public function modDatosCargo($cod_cargo, $nombre)
    {
        $this->cod_cargo = $cod_cargo;
        $this->nombre = $this->formatearPalabra($nombre);

        return $this->modificarCargo();
    }

    private function modificarCargo()
    {
        try {
            $sentencia = "UPDATE `cargo` SET nombre = ? WHERE cod_cargo = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_cargo);

            $update->execute();
        } catch (\PDOException $e) {
            return "Error al modificar el cargo: " . $e->getMessage();
        }
    }

    public function elmDatosCargo(int $cod_cargo)
    {
        $this->cod_cargo = $cod_cargo;

        return $this->eliminarCargo();
    }


    private function eliminarCargo()
    {
        try {
            $sentencia = "UPDATE `cargo` SET estado = 0 WHERE cod_cargo = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_cargo);
            $delete->execute();

            return "Cargo eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el cargo: " . $e->getMessage();
        }
    }
}
