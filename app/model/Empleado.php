<?php

namespace App\Model;

use App\Config\Conexion;

class Empleado extends Conexion
{
    private $cod_empleado;
    private $cedula;
    private $nombre;
    private $apellido;
    private $telefono;
    private $telefono_emergencia;
    private $cod_cargo;
    private $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function obt_TodosLosCargos() {
        $sentencia = "SELECT cod_cargo, nombre FROM cargo WHERE estado = 1";
        $select = $this->conexion->prepare($sentencia);
        $select->execute();
        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obt_RegistrosEmpleado()
    {
        try {
            $sentencia = "SELECT * FROM empleado WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
    
    public function verificarEmpleadoExiste($nombre)
    {
        $sentencia = "SELECT COUNT(*) FROM empleado WHERE nombre = ?  AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function verificarEmpleadoDuplicado($nombre, $id_actual)
    {
        $sentencia = "SELECT COUNT(*) FROM empleado WHERE nombre = ? AND cod_empleado != ? AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2, $id_actual);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function regDatosEmpleado($nombre, $apellido, $cedula, $telefono, $telefono_emergencia, $cod_cargo)
    {

        $this->nombre = $this->formatearPalabra($nombre);
        $this->apellido = $this->formatearPalabra($apellido);
        $this->cedula = $cedula;
        $this->telefono = $telefono;
        $this->telefono_emergencia = $telefono_emergencia;
        $this->cod_cargo = $cod_cargo;
        $this->estado = 1;

        return $this->registrarEmpleado();
    }


    private function registrarEmpleado()
    {
        try {
            $sentencia = "INSERT INTO empleado (nombre, apellido, cedula, telefono, telefono_emergencia, cod_cargo, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->apellido);
            $insert->bindValue(3, $this->cedula);
            $insert->bindValue(4, $this->telefono);
            $insert->bindValue(5, $this->telefono_emergencia);
            $insert->bindValue(6, $this->cod_cargo);
            $insert->bindValue(7, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el empleado: " . $e->getMessage() . "');</script>";
        }
    }


    public function modDatosEmpleado($cod_empleado, $nombre, $apellido, $cedula, $telefono, $telefono_emergencia, $cod_cargo)
    {
        $this->cod_empleado = $cod_empleado;
        $this->nombre = $this->formatearPalabra($nombre);
        $this->apellido = $this->formatearPalabra($apellido);
        $this->cedula = $cedula;
        $this->telefono = $telefono;
        $this->telefono_emergencia = $telefono_emergencia;
        $this->cod_cargo = $cod_cargo;

        return $this->modificarEmpleado();
    }

    private function modificarEmpleado()
    {
        try {
            $sentencia = "UPDATE `empleado` SET cedula = ?, nombre = ?, apellido = ?, telefono = ?, telefono_emergencia = ?, cod_cargo = ? WHERE cod_empleado = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->cedula);
            $update->bindValue(2, $this->nombre);
            $update->bindValue(3, $this->apellido);
            $update->bindValue(4, $this->telefono);
            $update->bindValue(5, $this->telefono_emergencia);
            $update->bindValue(6, $this->cod_cargo);
            $update->bindValue(7, $this->cod_empleado);

            $update->execute();
        } catch (\PDOException $e) {
            return "Error al modificar el empleado: " . $e->getMessage();
        }
    }

    public function elmDatosEmpleado(int $cod_empleado)
    {
        $this->cod_empleado = $cod_empleado;

        return $this->eliminarEmpleado();
    }

    private function eliminarEmpleado()
    {
        try {
            $sentencia = "UPDATE `empleado` SET estado = 0 WHERE cod_empleado = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_empleado);
            $delete->execute();

            return "Empleado eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el empleado: " . $e->getMessage();
        }
    }
}
