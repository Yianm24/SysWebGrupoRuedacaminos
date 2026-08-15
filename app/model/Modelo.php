<?php

namespace App\Model;

use App\Config\Conexion;

class Modelo extends Conexion
{

    private $cod_modelo;
    private $nombre;
    private $marca;
    private $estado;



    public function __construct()
    {
        parent::__construct();
    }

    public function verificarModeloDuplicado($nombre, $marca, $cod_modelo = null)
    {
        $this->formatearPalabra($nombre);
        if ($cod_modelo === null) {
            $sentencia = "SELECT COUNT(*) FROM modelo WHERE nombre = ? AND cod_marca = ?";
        } else {
            $sentencia = "SELECT COUNT(*) FROM modelo WHERE nombre = ? AND cod_marca = ? AND cod_modelo != ? AND estado = 1";
        }
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2, $marca);
        $count->bindValue(3, $cod_modelo);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function regDatosModelo($nombre, $marca)
    {
        // $this->nombre =strtoupper($nombre);
        $this->nombre = $this->formatearPalabra($nombre);
        $this->marca = $marca;
        $this->estado = 1;

        return $this->registrarModelo();
    }

    private function registrarModelo()
    {
        try {
            $sentencia = "INSERT INTO modelo (nombre,cod_marca,estado) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->marca);
            $insert->bindValue(3, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el modelo: " . $e->getMessage() . "');</script>";
        }
    }

    public function obt_RegistrosModelo()
    {
        try {
            $sentencia = "SELECT modelo.*, marca.nombre AS nombre_marca, 
            marca.cod_marca
            FROM modelo
            INNER JOIN marca 
            ON modelo.cod_marca= marca.cod_marca
            WHERE modelo.estado=1";

            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function modDatosModelo($cod_modelo, $nombre, $marca)
    {
        $this->cod_modelo = $cod_modelo;
        $this->nombre = $this->formatearPalabra($nombre);
        $this->marca = $marca;

        return $this->modificarModelo();
    }


    private function modificarModelo()
    {
        try {
            $sentencia = "UPDATE `modelo` SET nombre = ?, cod_marca = ? WHERE cod_modelo = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->marca);
            $update->bindValue(3, $this->cod_modelo);

            $update->execute();
        } catch (\PDOException $e) {
            return "Error al actualizar el modelo: " . $e->getMessage();
        }
    }


    public function elmDatosModelo(int $cod_modelo)
    {
        $this->cod_modelo = $cod_modelo;

        return $this->eliminarModelo();
    }

    private function eliminarModelo()
    {
        try {
            $sentencia = "UPDATE `modelo` SET estado = 0 WHERE cod_modelo = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_modelo);
            $delete->execute();

            return "Modelo de vehiculo eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el Modelo de vehiculo: " . $e->getMessage();
        }
    }
}
