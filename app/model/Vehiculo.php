<?php

namespace App\Model;
use App\Config\Conexion;

class Vehiculo extends Conexion 
{
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

    public function getAllVehiculos()
    {
        try {
            $consult = $this->conexion->prepare("SELECT * FROM vehiculo WHERE estado = 1");
            $consult->execute();
            return $consult->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function addVehiculo($placa, $color, $ano)
    {
        $this->placa = $placa;
        $this->color = $color;
        $this->ano = $ano;
        $this->estado = 1;

        return $this->registerVehiculo();
    }

    private function registerVehiculo()
    {
        try {
            $query = "INSERT INTO vehiculo (placa, color, estado, ano) VALUES (?, ?, ?, ?)";

            $stmt = $this->conexion->prepare($query);

            $stmt->bindValue(1, $this->placa);
            $stmt->bindValue(2, $this->color);
            $stmt->bindValue(3, $this->estado);
            $stmt->bindValue(4, $this->ano);
            

            $result = $stmt->execute();

            return $result;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el vehiculo: " . $e->getMessage() . "');</script>";
        }
    }

    public function updateVehiculo($placa, $color, $ano, $estado)
    {
        $this->placa = $placa;
        $this->color = $color;
        $this->ano = $ano;
        $this->estado = $estado;

        return $this->updateVehiculoById();
    }

    private function updateVehiculoById()
    {
        try {
            $query = "UPDATE `vehiculo` SET color = ?, ano = ?, estado = ? WHERE placa = ?";
            $update = $this->conexion->prepare($query);

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

    public function deleteVehiculo(int $id)
    {
        $this->id = $id;

        return $this->deleteVehiculoById();
    }

    private function deleteVehiculoById()
    {
        try {
            $query = "UPDATE `vehiculo` SET estado = 0 WHERE placa = ?";
            $delete = $this->conexion->prepare($query);

            $delete->bindValue(1, $this->id);
            $delete->execute();

            return "Vehículo eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el vehículo: " . $e->getMessage();
        }
    }
}
