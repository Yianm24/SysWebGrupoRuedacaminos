<?php

namespace App\Model;

use App\Config\Conexion;

class Vehiculo extends Conexion
{
    private $cod_vehiculo;
    private $placa;
    private $color;
    private $anio;
    private $anchura;
    private $altura;
    private $peso_max;
    private $cod_modelo;
    private $estado;


    public function __construct()
    {
        parent::__construct();
    }


    public function verificarVehiculoDuplicado($placa, $cod_vehiculo = null)
    {
        $placa = strtoupper($placa);
        if ($cod_vehiculo === null) {
            $sentencia = "SELECT COUNT(*) FROM vehiculo WHERE placa = ? AND estado = 1;";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1, $placa);
            $count->execute();
            return $count->fetchColumn() > 0;
        } else {
            $sentencia = "SELECT COUNT(*) FROM vehiculo WHERE placa = ? AND cod_vehiculo != ? AND estado = 1;";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1, $placa);
            $count->bindValue(2, $cod_vehiculo);
            $count->execute();
            return $count->fetchColumn() > 0;
        }
    }

    public function regDatosVehiculo($placa, $color, $anio, $anchura, $altura, $peso_max, $cod_modelo)
    {
        $this->placa = strtoupper($placa);
        $this->color = $this->formatearPalabra($color);
        $this->anchura = $anchura;
        $this->altura = $altura;
        $this->peso_max = $peso_max;
        $this->cod_modelo = $cod_modelo;
        $this->anio = $anio;
        $this->estado = 1;

        return $this->registrarVehiculo();
    }

    private function registrarVehiculo()
    {
        try {
            $sentencia = "INSERT INTO vehiculo (placa, color, anio, anchura, altura, peso_max, cod_modelo, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->placa);
            $insert->bindValue(2, $this->color);
            $insert->bindValue(3, $this->anio);
            $insert->bindValue(4, $this->anchura);
            $insert->bindValue(5, $this->altura);
            $insert->bindValue(6, $this->peso_max);
            $insert->bindValue(7, $this->cod_modelo);
            $insert->bindValue(8, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el vehiculo: " . $e->getMessage() . "');</script>";
        }
    }

    public function obt_RegistrosVehiculos()
    {
        try {
            $sentencia = "SELECT vehiculo.* , modelo.nombre AS nombremodelo
                            FROM vehiculo
                            INNER JOIN modelo
                            ON vehiculo.cod_modelo = modelo.cod_modelo
                            WHERE vehiculo.estado= 1;";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
    public function actDatosVehiculo($cod_vehiculo, $placa, $color, $anio, $anchura, $altura, $peso_max, $cod_modelo)
    {
        $this->cod_vehiculo = $cod_vehiculo;
        $this->placa = strtoupper($placa);
        $this->color = $this->formatearPalabra($color);
        $this->anio = $anio;
        $this->anchura = $anchura;
        $this->altura = $altura;
        $this->peso_max = $peso_max;
        $this->cod_modelo = $cod_modelo;

        return $this->actualizarVehiculo();
    }

    private function actualizarVehiculo()
    {
        try {
            $sentencia = "UPDATE `vehiculo` SET placa = ?, color = ?, anio = ?, anchura = ?, altura = ?, peso_max = ?, cod_modelo = ? WHERE cod_vehiculo = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->placa);
            $update->bindValue(2, $this->color);
            $update->bindValue(3, $this->anio);
            $update->bindValue(4, $this->anchura);
            $update->bindValue(5, $this->altura);
            $update->bindValue(6, $this->peso_max);
            $update->bindValue(7, $this->cod_modelo);
            $update->bindValue(8, $this->cod_vehiculo);

            $update->execute();
        } catch (\PDOException $e) {
            return "Error al actualizar el vehículo: " . $e->getMessage();
        }
    }

    public function elmDatosVehiculo(int $cod_vehiculo)
    {
        $this->cod_vehiculo = $cod_vehiculo;

        return $this->eliminarVehiculo();
    }

    private function eliminarVehiculo()
    {
        try {
            $sentencia = "UPDATE `vehiculo` SET estado = 0 WHERE cod_vehiculo = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_vehiculo);
            $delete->execute();

            return "Vehículo eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el vehículo: " . $e->getMessage();
        }
    }
}
