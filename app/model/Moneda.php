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

    public function regDatosMetodoPago($nombre, $abreviatura)
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
}
