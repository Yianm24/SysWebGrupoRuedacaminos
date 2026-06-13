<?php

namespace App\Model;
use App\Config\Conexion;

class Vehiculo extends Conexion 
{
    private $cod_vehiculo;
    private $placa;
    private $color;
    private $ano;
    private $estado;


    public function __construct( $placa = null, $color = null, $ano = null, $estado = null)
    {
        parent::__construct();

        if ($placa !== null) {
            $this->placa = $placa;
        }
        $this->color = $color;
        $this->ano = $ano;
        $this->estado = $estado;
        
    }

    public function regDatosVehiculo($placa, $color, $ano)
    {
        $this->placa = $placa;
        $this->color = $color;
        $this->ano = $ano;
        $this->estado = 1;

        return $this->registrarVehiculo();
    }

    private function registrarVehiculo()
    {
        try {
            $sentencia = "INSERT INTO vehiculo (placa, color, ano, estado) VALUES (?, ?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->placa);
            $insert->bindValue(2, $this->color);
            $insert->bindValue(3, $this->ano);
            $insert->bindValue(4, $this->estado);
            

            $resultado = $insert->execute();

            return $resultado;

        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el vehiculo: " . $e->getMessage() . "');</script>";
        }
    }
    
    public function obt_RegistrosVehiculos()
        {
            try {
                $sentencia = "SELECT * FROM vehiculo WHERE estado = 1";
                $select = $this->conexion->prepare($sentencia);
                $select->execute();
                return $select->fetchAll(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                return [];
            }
        }
    public function actDatosVehiculo($placa, $color, $ano, $estado)
    {
        $this->placa = $placa;
        $this->color = $color;
        $this->ano = $ano;
        $this->estado = $estado;

        return $this->actualizarVehiculo();
    }

    private function actualizarVehiculo()
    {
        try {
            $sentencia = "UPDATE `vehiculo` SET color = ?, ano = ?, estado = ? WHERE placa = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->color);
            $update->bindValue(2, $this->ano);
            $update->bindValue(3, $this->estado);
            $update->bindValue(4, $this->placa);

            $update->execute();

            return "Vehículo actualizado exitosamente";
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
