<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;

class Rol extends Conexion
{
    use ValidadorTraitAjax;

    private $cod_rol;
    private $estado;
    private $nombre;
    //private $permisos

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

            $registros = json_encode($select->fetchAll(\PDO::FETCH_ASSOC));
            return $registros;
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de Estado: " . $e->getMessage();
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
    public function regDatosRol(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $this->nombre = $this->formatearPalabra($resultadoTrait[0]);
            $this->estado = 1;
        } else {
            return $resultadoTrait;
        }
        return $this->registrarRol();
    }


    private function registrarRol()
    {
        try {
            $sentencia = "INSERT INTO rol (nombre, estado) VALUES (?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado);

            $insert->execute();

            return json_encode(['status' => 'success', 'message' => 'El Rol ha sido registrado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function actDatosRol(array $campos)
    {

        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $this->cod_rol = $resultadoTrait[0];
            $this->nombre = $this->formatearPalabra($resultadoTrait[1]);
        }

        return $this->actualizarRol();
    }

    private function actualizarRol()
    {
        try {
            $sentencia = "UPDATE `rol` SET nombre = ? WHERE cod_rol = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_rol);

            $update->execute();

            return json_encode(['status' => 'updated', 'message' =>  'El Rol ha sido actualizada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
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
