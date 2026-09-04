<?php

namespace App\Model;

use App\Config\Conexion;

class Banco extends Conexion
{

    private $cod_banco;
    private $nombre;
    private $estado;

    function __construct()
    {
        parent::__construct();
    }

    public function verificarBancoDuplicado($nombre, $cod_banco = null)
    {
        if ($cod_banco === null) {
            $sentencia = "SELECT COUNT(*) FROM banco WHERE nombre = ? AND estado = 1;";
        } else {
            $sentencia = "SELECT COUNT(*) FROM banco WHERE nombre = ? AND cod_banco != ? AND estado = 1;";
        }
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2, $cod_banco);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function regDatosBanco($nombre)
    {
        $this->nombre = $this->formatearPalabra($nombre);
        $this->estado = 1;

        return $this->registrarBanco();
    }

    private function registrarBanco()
    {
        try {
            $sentencia = "INSERT INTO banco (nombre,estado) VALUES (?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado);
            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el Banco: " . $e->getMessage() . "');</script>";
        }
    }

    public function obt_RegistrosBanco()
    {

        try {
            $sentencia = "SELECT * FROM banco WHERE estado = 1";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            return $consulta->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de banco: " . $e->getMessage();
            return [];
        }
    }

    public function actBanco($cod_banco, $nombre)
    {
        $this->cod_banco = $cod_banco;
        $this->nombre = $nombre;

        return $this->actualizarBanco();
    }

    private function actualizarBanco()
    {
        try {
            $sentencia = "UPDATE `banco` SET nombre = ? WHERE cod_banco = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_banco);

            $update->execute();
        } catch (\PDOException $e) {
            return "Error al actualizar el registro del banco: " . $e->getMessage();
        }
    }

    public function elmDatosBanco(int $cod_banco)
    {
        $this->cod_banco = $cod_banco;

        return $this->eliminarBanco();
    }

    private function eliminarBanco()
    {
        try {
            $sentencia = "UPDATE `banco` SET estado = 0 WHERE cod_banco = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_banco);
            $delete->execute();

            return "Banco eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el Banco: " . $e->getMessage();
        }
    }
}
