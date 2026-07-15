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
    public function regDatosEmpleado($nombre)
    {

        $this->nombre = $this->formatearPalabra($nombre);
        $this->estado = 1;

        return $this->registrarEmpleado();
    }


    private function registrarEmpleado()
    {
        try {
            $sentencia = "INSERT INTO empleado (nombre, estado) VALUES (?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el empleado: " . $e->getMessage() . "');</script>";
        }
    }


    public function modDatosEmpleado($cod_empleado, $nombre)
    {
        $this->cod_empleado = $cod_empleado;
        $this->nombre = $this->formatearPalabra($nombre);

        return $this->modificarEmpleado();
    }

    private function modificarEmpleado()
    {
        try {
            $sentencia = "UPDATE `empleado` SET nombre = ? WHERE cod_empleado = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_empleado);

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
