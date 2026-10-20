<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTrait;

class Modelo extends Conexion
{
use ValidadorTrait;
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

    public function regDatosModelo(array $campos)
    {
        if(is_array($this->validarPost($campos))){

        $datos = $this->validarPost($campos);
        $this->nombre =strtoupper($datos['nombre_modelo']);
        $this->marca = $datos['marca'];
        $this->estado = 1;
        }else{
            return 'error&msg=Registrar';
        }
        return $this->registrarModelo();
    }

    private function registrarModelo()
    {
        try {
            $sentencia = "INSERT INTO modelo (nombre,cod_marca,estado) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);
            $insert->execute([$this->nombre,$this->marca,$this->estado]);

            return 'success';
        } catch (\PDOException $e) {
            return  "exception&msg=".urlencode($e->getMessage());
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
            echo "Error al obtener los registros de unidad de medida: " . $e->getMessage();
            return [];
        }
    }

    public function actDatosModelo(array $campos)
    {
        if(is_array($this->validarPost($campos))){
            $datos = $this->validarPost($campos);    
            $this->cod_modelo = $datos['cod_modelo'];
            $this->nombre =strtoupper($datos['nombre_modelo']);
            $this->marca = $datos['marca'];
        }else{
            return 'error&msg=Registrar';
        }

        return $this->actualizarModelo();
    }


    private function actualizarModelo()
    {
        try {
            $sentencia = "UPDATE `modelo` SET nombre = ?, cod_marca = ? WHERE cod_modelo = ?";

            $update = $this->conexion->prepare($sentencia);
            $update->execute([$this->nombre,$this->marca,$this->cod_modelo]);

            return 'updated';
        } catch (\PDOException $e) {
            return "exception&msg=".urlencode($e->getMessage());
        }
    }


    public function elmDatosModelo(array $campos)
    {
        if(is_array($this->validarPost($campos))){
            $datos = $this->validarPost($campos);
            $this->cod_modelo = $datos['cod_modelo'];
        }else{
            return 'error&msg=Registrar';
        }

        return $this->eliminarModelo();
    }

    private function eliminarModelo()
    {
        try {
            $sentencia = "UPDATE `modelo` SET estado = 0 WHERE cod_modelo = ?";
            
            $delete = $this->conexion->prepare($sentencia);
            $delete->execute([$this->cod_modelo]);

            return 'deleted';
        } catch (\PDOException $e) {
            return "exception&msg=".urlencode($e->getMessage());
        }
    }
}
