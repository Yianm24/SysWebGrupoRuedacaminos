<?php

namespace App\Model;

use App\Config\Conexion;

class Rol extends Conexion
{

    private $cod_rol;
    private $estado;
    private $nombre;

    public function __construct()
    {
        parent::__construct();
    }

    public function obt_RegistrosRol()
    {
        try {
            $sentencia = "SELECT * FROM rol WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function verificarRolExiste($nombre)
    {
        $sentencia = "SELECT COUNT(*) FROM rol WHERE nombre = ?  AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->execute();
        return $count->fetchColumn() > 0;
    }
    public function regDatosRol($nombre)
    {

        $this->nombre = $this->formatearPalabra($nombre);
        $this->estado = 1;

        return $this->registrarRol();
    }


    private function registrarRol()
    {
        try {
            $sentencia = "INSERT INTO rol (nombre, estado) VALUES (?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el rol: " . $e->getMessage() . "');</script>";
        }
    }


    public function modDatosRol($cod_rol, $nombre)
    {
        $this->cod_rol = $cod_rol;
        $this->nombre = $this->formatearPalabra($nombre);

        return $this->modificarRol();
    }

    private function modificarRol()
    {
        try {
            $sentencia = "UPDATE `rol` SET nombre = ? WHERE cod_rol = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_rol);

            $update->execute();
        } catch (\PDOException $e) {
            return "Error al modificar el rol: " . $e->getMessage();
        }
    }

    public function elmDatosRol(int $cod_rol)
    {
        $this->cod_rol = $cod_rol;

        return $this->eliminarRol();
    }


    private function eliminarRol()
    {
        try {
            $sentencia = "UPDATE `rol` SET estado = 0 WHERE cod_rol = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_rol);
            $delete->execute();

        } catch (\PDOException $e) {
            return "Error al eliminar el rol: " . $e->getMessage();
        }
    }
}