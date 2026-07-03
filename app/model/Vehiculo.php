<?php

namespace App\Model;
use App\Config\Conexion;

class Vehiculo extends Conexion 
{
    private $cod_vehiculo;
    private $placa;
    private $color;
    private $tipo_vehiculo;
    private $modelo;
    private $ano;
    private $estado;


    public function __construct( $placa = null, $color = null, $tipo_vehiculo = null, $modelo = null, $ano = null, $estado = null)
    {
        parent::__construct();

        if ($placa !== null) {
            $this->placa = $placa;
        }
        $this->color = $color;
        $this->tipo_vehiculo = $tipo_vehiculo;
        $this->modelo = $modelo;
        $this->ano = $ano;
        $this->estado = $estado;
        
    }

    public function regDatosVehiculo($placa, $color,$tipo_vehiculo, $modelo, $ano)
    {
        $this->placa = $placa;
        $this->color = $color;
        $this->tipo_vehiculo = $tipo_vehiculo;
        $this->modelo = $modelo;
        $this->ano = $ano;
        $this->estado = 1;

        return $this->registrarVehiculo();
    }

    private function registrarVehiculo()
    {
        try {
            $sentencia = "INSERT INTO vehiculo (placa, color, cod_tipovehiculo, cod_modelo, ano, estado) VALUES (?, ?, ?, ?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->placa);
            $insert->bindValue(2, $this->color);
            $insert->bindValue(3, $this->tipo_vehiculo);
            $insert->bindValue(4, $this->modelo);
            $insert->bindValue(5, $this->ano);
            $insert->bindValue(6, $this->estado);

            $resultado = $insert->execute();

            return $resultado;

        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el vehiculo: " . $e->getMessage() . "');</script>";
        }
    }
    
    public function obt_RegistrosVehiculos()
        {
            try {
                $sentencia = "SELECT vehiculo.* , tipos_vehiculo.nombre AS nombretipovehiculo, modelo.nombre AS nombremodelo
                            FROM vehiculo
                            INNER JOIN tipos_vehiculo
                            ON vehiculo.cod_tipovehiculo = tipos_vehiculo.cod_tipovehiculo
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
    public function actDatosVehiculo($cod_vehiculo, $placa, $color, $tipo_vehiculo, $modelo, $ano)
    {
        $this->cod_vehiculo = $cod_vehiculo;
        $this->placa = $placa;
        $this->color = $color;
        $this->tipo_vehiculo = $tipo_vehiculo;
        $this->modelo = $modelo;
        $this->ano = $ano;
        

        return $this->actualizarVehiculo();
    }

    private function actualizarVehiculo()
    {
        try {
            $sentencia = "UPDATE `vehiculo` SET placa = ?, color = ?, cod_tipovehiculo = ?, cod_modelo = ?, ano = ? WHERE cod_vehiculo = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->placa);
            $update->bindValue(2, $this->color);
            $update->bindValue(3, $this->tipo_vehiculo);
            $update->bindValue(4, $this->modelo);
            $update->bindValue(5, $this->ano);
            $update->bindValue(6, $this->cod_vehiculo);

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
