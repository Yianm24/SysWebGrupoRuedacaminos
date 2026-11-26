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
            $sentencia = "SELECT * FROM cargo ORDER BY estado DESC, cod_cargo DESC";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function verificarCargoDuplicado($nombre, $cod_cargo = null)
    {
        if ($cod_cargo === null) {
            $sentencia = "SELECT COUNT(*) FROM cargo WHERE nombre = ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1, $nombre);
        } else {
            $sentencia = "SELECT COUNT(*) FROM cargo WHERE nombre = ? AND cod_cargo != ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1, $nombre);
            $count->bindValue(2, $cod_cargo);
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

            if ($this->verificarCargoDuplicado($nombreLimpio)) {
                return json_encode(['status' => 'exists', 'message' => 'El cargo ya existe.']);
            }

            if (strlen($nombreLimpio) < 3 || strlen($nombreLimpio) > 15) {
                return json_encode(['status' => 'error', 'message' => 'El cargo debe tener entre 3 y 15 letras.']);
            }
            $validacionRegex = $this->ExplorarDatos(['solo-letras' => $nombreLimpio]);
            if ($validacionRegex !== true) {
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
            $insert->execute([$this->nombre, $this->estado]);
            return json_encode(['status' => 'success', 'message' => 'El cargo ha sido registrado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function modDatosCargo(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $codCargo = $resultadoTrait[0];
            $nombreLimpio = $this->formatearPalabra($resultadoTrait[1]);
            $estadoRecibido = isset($campos[2]) ? (int)$campos[2] : 1;

            if (!in_array($estadoRecibido, [0, 1], true)) {
                return json_encode(['status' => 'error', 'message' => 'El estatus seleccionado no es válido.']);
            }

            if ($estadoRecibido === 1 && $this->verificarCargoDuplicado($nombreLimpio, $codCargo)) {
                return json_encode(['status' => 'exists', 'message' => 'El cargo ya existe.']);
            }

            if (strlen($nombreLimpio) < 3 || strlen($nombreLimpio) > 15) {
                return json_encode(['status' => 'error', 'message' => 'El cargo debe tener entre 3 y 15 letras.']);
            }
            $validacionRegex = $this->ExplorarDatos(['solo-letras' => $nombreLimpio]);
            if ($validacionRegex !== true) {
                return $validacionRegex;
            }

            $this->cod_cargo = $codCargo;
            $this->nombre = $nombreLimpio;
            $this->estado = $estadoRecibido;
        } else {
            return $resultadoTrait;
        }
        return $this->modificarCargo();
    }

    private function modificarCargo()
    {
        try {
            $sentencia = "UPDATE `cargo` SET nombre = ?, estado = ? WHERE cod_cargo = ?";
            $update = $this->conexion->prepare($sentencia);
            $update->execute([$this->nombre, $this->estado, $this->cod_cargo]);
            return json_encode(['status' => 'updated', 'message' => 'El cargo ha sido modificado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function elmDatosCargo(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $this->cod_cargo = $resultadoTrait[0];

            if ($this->verificarEmpleadosAsociados($this->cod_cargo)) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'No se puede eliminar este cargo porque esta asignado a empleados.'
                ]);
            }
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
            return json_encode(['status' => 'deleted', 'message' => 'El cargo ha sido eliminado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}
