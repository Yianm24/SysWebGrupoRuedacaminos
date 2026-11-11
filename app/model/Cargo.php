<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;
use App\Traits\ExpRegexTrait;

class Cargo extends Conexion
{
    use ValidadorTraitAjax, ExpRegexTrait;

    private $cod_cargo;
    private $estado;
    private $nombre;

    public function __construct()
    {
        parent::__construct();
    }

    public function obt_RegistrosCargo()
    {
        try {
            $sentencia = "SELECT * FROM cargo WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function verificarCargoDuplicado($nombre, $cod_cargo = null)
    {
        if ($cod_cargo === null) {$sentencia = "SELECT COUNT(*) FROM cargo WHERE nombre = ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1,$nombre);
        } else {
            $sentencia = "SELECT COUNT(*) FROM cargo WHERE nombre = ? AND cod_cargo != ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1,$nombre);
            $count->bindValue(2,$cod_cargo);
        }
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function verificarEmpleadosAsociados($cod_cargo)
    {
        try {
            $sentencia = "SELECT COUNT(*) FROM empleado WHERE cod_cargo = ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1, $cod_cargo);
            $count->execute();
            return $count->fetchColumn() > 0;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function regDatosCargo(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $nombreLimpio = $this->formatearPalabra($resultadoTrait[0]);

            //comprobar que la expresion regular se cumpla
            if(strlen($nombreLimpio) < 3 || strlen($nombreLimpio) > 15) {
                return json_encode(['status' => 'error', 'message' => 'El cargo debe tener entre 3 y 15 letras.']);
            }
            $validacionRegex = $this->ExplorarDatos(['solo-letras' => $nombreLimpio]);
            if($validacionRegex !== true) {
                return $validacionRegex;
            }
            $this->nombre = $nombreLimpio;
            $this->estado = 1;
        } else {
            return $resultadoTrait;
        }

        return $this->registrarCargo();
    }

    private function registrarCargo()
    {
        try {
            $sentencia = "INSERT INTO cargo (nombre, estado) VALUES (?, ?)";
            $insert = $this->conexion->prepare($sentencia);
            $insert->execute([$this->nombre,$this->estado]);
            return 'success';
        } catch (\PDOException $e) {
            return "exception";
        }
    }


    public function modDatosCargo(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $nombreLimpio = $this->formatearPalabra($resultadoTrait[1]);

            //comprobar que la expresion regular se cumpla
            if(strlen($nombreLimpio) < 3 || strlen($nombreLimpio) > 15) {
                return json_encode(['status' => 'error', 'message' => 'El cargo debe tener entre 3 y 15 letras.']);
            }
            $validacionRegex = $this->ExplorarDatos(['solo-letras' => $nombreLimpio]);
            if ($validacionRegex !== true) {
                return $validacionRegex;
            }

            $this->cod_cargo = $resultadoTrait[0];
            $this->nombre = $nombreLimpio;
        } else {
            return $resultadoTrait;
        }
        return $this->modificarCargo();
    }

    private function modificarCargo()
    {
        try {
            $sentencia = "UPDATE `cargo` SET nombre = ? WHERE cod_cargo = ?";
            $update = $this->conexion->prepare($sentencia);
            $update->execute([$this->nombre,$this->cod_cargo]);
            return 'updated';
        } catch (\PDOException $e) {
            return "exception";
        }
    }

    public function elmDatosCargo(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $this->cod_cargo = $resultadoTrait[0];
        } else {
            return $resultadoTrait;
        }
        return $this->eliminarCargo();
    }


    private function eliminarCargo()
    {
        try {
            $sentencia = "UPDATE `cargo` SET estado = 0 WHERE cod_cargo = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->execute([$this->cod_cargo]);
            return 'deleted';
        } catch (\PDOException $e) {
            return "exception";
        }
    }
}
