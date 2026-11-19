<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;
use App\Traits\ExpRegexTrait;

class Modelo extends Conexion
{
use ValidadorTraitAjax;
use ExpRegexTrait;

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

    public function regDatosModelo(array $campos, array $validar)
    {
        $resultadoTrait = $this->ExplorarDatos($validar);
        if(is_string($resultadoTrait)){
            return $resultadoTrait;
        }else{
            $resultadoTrait = $this->validarPost($campos);
            if(is_array($resultadoTrait)){
            $this->nombre =strtoupper($resultadoTrait[0]);
            $this->marca = $resultadoTrait[1];
            $this->estado = 1;
            }else{
                return $resultadoTrait;
            }
        }
        return $this->registrarModelo();
    }

    private function registrarModelo()
    {
        try {
            $sentencia = "INSERT INTO modelo (nombre,cod_marca,estado) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);
            $insert->execute([$this->nombre,$this->marca,$this->estado]);

            return json_encode(['status' => 'success', 'message' => 'El Modelo ha sido registrado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
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
            return json_encode($select->fetchAll(\PDO::FETCH_ASSOC));
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function actDatosModelo(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos); 
        if(is_array($resultadoTrait)){    
            $this->cod_modelo = $resultadoTrait[0];
            $this->nombre =strtoupper($resultadoTrait[1]);
            $this->marca = $resultadoTrait[2];
        }else{
            return $resultadoTrait;
        }

        return $this->actualizarModelo();
    }


    private function actualizarModelo()
    {
        try {
            $sentencia = "UPDATE `modelo` SET nombre = ?, cod_marca = ? WHERE cod_modelo = ?";

            $update = $this->conexion->prepare($sentencia);
            $update->execute([$this->nombre,$this->marca,$this->cod_modelo]);

            return json_encode(['status' => 'updated', 'message' => 'El Modelo ha sido actualizado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }


    public function elmDatosModelo(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos); 
        if(is_array($resultadoTrait)){
            $this->cod_modelo = $resultadoTrait[0];
        }else{
            return $resultadoTrait;
        }

        return $this->eliminarModelo();
    }

    private function eliminarModelo()
    {
        try {
            $sentencia = "UPDATE `modelo` SET estado = 0 WHERE cod_modelo = ?";
            
            $delete = $this->conexion->prepare($sentencia);
            $delete->execute([$this->cod_modelo]);

            return json_encode(['status' => 'deleted', 'message' => 'El Modelo ha sido eliminado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}
