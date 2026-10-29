<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTrait;

class Empleado extends Conexion
{
    use ValidadorTrait;

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
    public function obt_EmpleadosCargo(int $rol){
        try {
            $sentencia = "SELECT cod_empleado, nombre, apellido FROM empleado WHERE cod_cargo = ? AND estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute([$rol]);
            if ($select->rowCount() > 0) {
                return $select->fetchAll(\PDO::FETCH_ASSOC);;
            } else {
                return [];
            }
        } catch (\PDOException $e) {
            return "<script>alert('Error al obtener los registros de empleados del cargo especificado: " . $e->getMessage() . "');</script>";
        }
    }

    public function obt_RegistrosEmpleado()
    {
        try {
            $sentencia = "SELECT e.*, c.nombre as nombre_cargo 
                        FROM empleado e 
                        INNER JOIN cargo c ON e.cod_cargo = c.cod_cargo 
                        WHERE e.estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function verificarEmpleadoDuplicado($cedula, $id_actual = null)
    {
        if ($id_actual === null) {$sentencia = "SELECT COUNT(*) FROM empleado WHERE cedula = ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1,$cedula);
        } else {
            $sentencia = "SELECT COUNT(*) FROM empleado WHERE cedula = ? AND cod_empleado != ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1,$cedula);
            $count->bindValue(2,$id_actual);
        }
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function regDatosEmpleado(array $campos)
    {
        if (is_array($this->validarPost($campos, 'empleado'))) {
            $datos = $this->validarPost($campos, 'empleado');
            $this->nombre = $this->formatearPalabra($datos['nombre']);
            $this->apellido = $this->formatearPalabra($datos['apellido']);
            $this->cedula = $datos['cedula'];
            $this->telefono = $datos['telefono'];
            $this->telefono_emergencia = $_POST['telefono_emergencia'] ?? '';
            $this->cod_cargo = $datos['cod_cargo'];
            $this->estado = 1;
            } else {
            return 'error&msg=Registrar';
        }
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
            $insert->execute();
            return 'success';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }


    public function modDatosEmpleado(array $campos)
    {
        if (is_array($this->validarPost($campos, 'empleado'))) {
            $datos = $this->validarPost($campos, 'empleado');
            $this->cod_empleado = $datos['id_empleado_editar'];
            $this->nombre = $this->formatearPalabra($datos['nombre_editar']);
            $this->apellido = $this->formatearPalabra($datos['apellido_editar']);
            $this->cedula = $datos['cedula_editar'];
            $this->telefono = $datos['telefono_editar'];
            $this->telefono_emergencia = $_POST['telefono_emergencia_editar'] ?? '';
            $this->cod_cargo = $datos['cod_cargo_editar'];
        } else {
            return 'error&msg=Actualizar';
        }
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
            return 'updated';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function elmDatosEmpleado(array $campos)
    {
        if (is_array($this->validarPost($campos, 'empleado'))) {
            $datos = $this->validarPost($campos, 'empleado');
            $this->cod_empleado = $datos['id_empleado'];
        } else {
            return 'error&msg=Eliminar';
        }
        return $this->eliminarEmpleado();
    }

    private function eliminarEmpleado()
    {
        try {
            $sentencia = "UPDATE `empleado` SET estado = 0 WHERE cod_empleado = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->bindValue(1, $this->cod_empleado);
            $delete->execute();
            return 'deleted';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }
}
