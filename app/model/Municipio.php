<?php

namespace App\Model;

use App\Config\Conexion;

class Municipio extends Conexion
{

    private $cod_municipio;
    private $nombre;
    private $estado_ubi;
    private $estado;



    public function __construct()
    {
        parent::__construct();
    }

    public function verificarMunicipioDuplicado($nombre, $estado_ubi, $cod_municipio = null)
    {
        $this->formatearPalabra($nombre);
        if ($cod_municipio === null) {
            $sentencia = "SELECT COUNT(*) FROM municipio WHERE nombre = ? AND cod_estado = ?";
        } else {
            $sentencia = "SELECT COUNT(*) FROM municipio WHERE nombre = ? AND cod_estado = ? AND cod_municipio != ? AND estado = 1";
        }
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2, $estado_ubi);
        $count->bindValue(3, $cod_municipio);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function regDatosMunicipio($nombre, $estado_ubi)
    {
        // $this->nombre =strtoupper($nombre);
        $this->nombre = $this->formatearPalabra($nombre);
        $this->estado_ubi = $estado_ubi;
        $this->estado = 1;

        return $this->registrarMunicipio();
    }

    private function registrarMunicipio()
    {
        try {
            $sentencia = "INSERT INTO municipio (nombre,cod_estado,estado) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado_ubi);
            $insert->bindValue(3, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el municipio: " . $e->getMessage() . "');</script>";
        }
    }

    public function obt_RegistrosMunicipio()
    {
        try {
            $sentencia = "SELECT municipio.*, estado.nombre AS nombre_estado, 
            estado.cod_estado
            FROM municipio
            INNER JOIN estado 
            ON municipio.cod_estado= estado.cod_estado
            WHERE municipio.estado=1";

            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function modDatosMunicipio($cod_municipio, $nombre, $estado_ubi)
    {
        $this->cod_municipio = $cod_municipio;
        $this->nombre = $this->formatearPalabra($nombre);
        $this->estado_ubi = $estado_ubi;

        return $this->modificarMunicipio();
    }


    private function modificarMunicipio()
    {
        try {
            $sentencia = "UPDATE `municipio` SET nombre = ?, cod_estado = ? WHERE cod_municipio = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->estado_ubi);
            $update->bindValue(3, $this->cod_municipio);

            $update->execute();
        } catch (\PDOException $e) {
            return "Error al actualizar el modelo: " . $e->getMessage();
        }
    }


    public function elmDatosMunicipio(int $cod_municipio)
    {
        $this->cod_municipio = $cod_municipio;

        return $this->eliminarMunicipio();
    }

    private function eliminarMunicipio()
    {
        try {
            $sentencia = "UPDATE `municipio` SET estado = 0 WHERE cod_municipio = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_municipio);
            $delete->execute();

            return "Modelo de vehiculo eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el Modelo de vehiculo: " . $e->getMessage();
        }
    }
}
