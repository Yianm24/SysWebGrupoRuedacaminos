<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTrait;

class Vehiculo extends Conexion
{
use ValidadorTrait;    
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

    public function regDatosVehiculo(array $campos)
    {
        if(is_array($this->validarPost($campos,"vehiculo"))){
            $datos = $this->validarPost($campos,"vehiculo");
            $this->placa = strtoupper($datos['placa']);
            $this->color = $this->formatearPalabra($datos['color']);
            $this->anio = $datos['anio'];
            $this->anchura = $datos['anchura'];
            $this->altura = $datos['altura'];
            $this->peso_max = $datos['peso_max'];
            $this->cod_modelo = $datos['modelo'];
            $this->estado = 1;
        }else{
            return 'error&msg=Registrar';
        }

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

            $insert->execute();

            return 'success';
        } catch (\PDOException $e) {
            return  "exception&msg=".urlencode($e->getMessage());
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
    public function actDatosVehiculo(array $campos)
    {
        if(is_array($this->validarPost($campos,"vehiculo"))){

            $datos = $this->validarPost($campos,"vehiculo");
            $this->cod_vehiculo = $datos['cod_vehiculo'];
            $this->placa = strtoupper($datos['placa']);
            $this->color = $this->formatearPalabra($datos['color']);
            $this->anio = $datos['anio'];
            $this->anchura = $datos['anchura'];
            $this->altura = $datos['altura'];
            $this->peso_max = $datos['peso_max'];
            $this->cod_modelo = $datos['modelo'];
        }else{
            return 'error&msg=Actualizar'; 
        }

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
            return 'updated';
        } catch (\PDOException $e) {
            return  "exception&msg=".urlencode($e->getMessage());
        }
    }

    public function elmDatosVehiculo(array $campos)
    {
        if(is_array($this->validarPost($campos,"vehiculo"))){
            $datos = $this->validarPost($campos,"vehiculo");
            $this->cod_vehiculo = $datos['cod_vehiculo'];
        }else{
            return 'error&msg=Eliminar'; 
        }
        return $this->eliminarVehiculo();
    }

    private function eliminarVehiculo()
    {
        try {
            $sentencia = "UPDATE `vehiculo` SET estado = 0 WHERE cod_vehiculo = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->execute([$this->cod_vehiculo]);

            return 'deleted';
        } catch (\PDOException $e) {
            return  "exception&msg=".urlencode($e->getMessage());
        }
    }
}
