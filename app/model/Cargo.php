<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\CargoTrait;

class Cargo extends Conexion
{
    use CargoTrait;

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

    public function regDatosCargo(array $campos)
    {
        if (is_array($this->validarPost($campos))) {$datos = $this->validarPost($campos);
            $this->nombre =$this->formatearPalabra($datos['nombre']);
            $this->estado = 1;
        } else {
            return 'error&msg=Registrar';
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
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }


    public function modDatosCargo(array $campos)
    {
        if (is_array($this->validarPost($campos))) {$datos = $this->validarPost($campos);
            $this->cod_cargo = $datos['cod-cargo'];
            $this->nombre = $this->formatearPalabra($datos['nombre']);
        } else {
            return 'error&msg=Actualizar';
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
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function elmDatosCargo(array $campos)
    {
        if (is_array($this->validarPost($campos))) {$datos = $this->validarPost($campos);
            $this->cod_cargo = $datos['cod_cargo'];
        } else {
            return 'error&msg=Eliminar';
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
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }
}
