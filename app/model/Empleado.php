<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;
use App\Traits\ExpRegexTrait;

class Empleado extends Conexion
{
    use ValidadorTraitAjax, ExpRegexTrait;

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

    public function obt_TodosLosCargos()
    {
        try {
            $sentencia = "SELECT cod_cargo, nombre FROM cargo WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function obt_EmpleadosCargo(int $rol)
    {
        try {
            $sentencia = "SELECT cod_empleado, nombre, apellido FROM empleado WHERE cod_cargo = ? AND estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute([$rol]);
            if ($select->rowCount() > 0) {
                return $select->fetchAll(\PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function obt_RegistrosEmpleado()
    {
        try {
            $sentencia = "SELECT e.*, c.nombre AS nombre_cargo FROM empleado e INNER JOIN cargo c ON e.cod_cargo = c.cod_cargo WHERE e.estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function verificarEmpleadoDuplicado($cedula, $id_actual = null)
    {
        if ($id_actual === null || $id_actual === '') {
            $sentencia = "SELECT COUNT(*) FROM empleado WHERE cedula = ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1, $cedula);
        } else {
            $sentencia = "SELECT COUNT(*) FROM empleado WHERE cedula = ? AND cod_empleado != ? AND estado = 1";
            $count = $this->conexion->prepare($sentencia);
            $count->bindValue(1, $cedula);
            $count->bindValue(2, $id_actual);
        }
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    private function validarCamposEmpleado(string $cedula, string $nombre, string $apellido, string $telefono, string $telEmergencia)
    {
        if (strlen($cedula) < 7 || strlen($cedula) > 9) {
            return json_encode(['status' => 'error', 'message' => 'Longitud de cédula inválida.']);
        }
        $valCedula = $this->ExplorarDatos(['solo-numeros' => $cedula]);
        if ($valCedula !== true) return $valCedula;

        if (strlen($nombre) < 3 || strlen($nombre) > 25) {
            return json_encode(['status' => 'error', 'message' => 'Longitud de nombre inválida.']);
        }
        $valNombre = $this->ExplorarDatos(['solo-letras' => $nombre]);
        if ($valNombre !== true) return $valNombre;

        if (strlen($apellido) < 3 || strlen($apellido) > 25) {
            return json_encode(['status' => 'error', 'message' => 'Longitud de apellido inválida.']);
        }
        $valApellido = $this->ExplorarDatos(['solo-letras' => $apellido]);
        if ($valApellido !== true) return $valApellido;

        if (strlen($telefono) != 11) {
            return json_encode(['status' => 'error', 'message' => 'El teléfono debe tener 11 dígitos.']);
        }
        $valTelefono = $this->ExplorarDatos(['solo-numeros' => $telefono]);
        if ($valTelefono !== true) return $valTelefono;

        if ($telEmergencia !== '') {
            if (strlen($telEmergencia) != 11) {
                return json_encode(['status' => 'error', 'message' => 'El teléfono de emergencia debe tener 11 dígitos.']);
            }
            $valEmergencia = $this->ExplorarDatos(['solo-numeros' => $telEmergencia]);
            if ($valEmergencia !== true) return $valEmergencia;
        }

        return true;
    }

    public function regDatosEmpleado(array $campos, $telEmergencia = '')
    {
        $resultadoTrait = $this->validarPost($campos);
        if (!is_array($resultadoTrait)) {
            return $resultadoTrait;
        }

        $cedulaLimpia = $resultadoTrait[0];
        $nombreLimpio = $this->formatearPalabra($resultadoTrait[1]);
        $apellidoLimpio = $this->formatearPalabra($resultadoTrait[2]);
        $telefonoLimpio = $resultadoTrait[3];
        $cargoLimpio = $resultadoTrait[4];
        $emergenciaLimpio = $this->input($telEmergencia, '');

        $validacion = $this->validarCamposEmpleado($cedulaLimpia, $nombreLimpio, $apellidoLimpio, $telefonoLimpio, $emergenciaLimpio);
        if ($validacion !== true) {
            return $validacion;
        }

        $this->cedula = $cedulaLimpia;
        $this->nombre = $nombreLimpio;
        $this->apellido = $apellidoLimpio;
        $this->telefono = $telefonoLimpio;
        $this->telefono_emergencia = $emergenciaLimpio;
        $this->cod_cargo = $cargoLimpio;
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
            $insert->execute();
            return json_encode(['status' => 'success', 'message' => 'El empleado ha sido registrado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function modDatosEmpleado(array $campos, $telEmergencia = '')
    {
        $resultadoTrait = $this->validarPost($campos);
        if (!is_array($resultadoTrait)) {
            return $resultadoTrait;
        }

        $codLimpio = $resultadoTrait[0];
        $cedulaLimpia = $resultadoTrait[1];
        $nombreLimpio = $this->formatearPalabra($resultadoTrait[2]);
        $apellidoLimpio = $this->formatearPalabra($resultadoTrait[3]);
        $telefonoLimpio = $resultadoTrait[4];
        $cargoLimpio = $resultadoTrait[5];
        $emergenciaLimpio = $this->input($telEmergencia, '');

        $validacion = $this->validarCamposEmpleado($cedulaLimpia, $nombreLimpio, $apellidoLimpio, $telefonoLimpio, $emergenciaLimpio);
        if ($validacion !== true) {
            return $validacion;
        }

        $this->cod_empleado = $codLimpio;
        $this->cedula = $cedulaLimpia;
        $this->nombre = $nombreLimpio;
        $this->apellido = $apellidoLimpio;
        $this->telefono = $telefonoLimpio;
        $this->telefono_emergencia = $emergenciaLimpio;
        $this->cod_cargo = $cargoLimpio;

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
            return json_encode(['status' => 'updated', 'message' => 'El empleado ha sido modificado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function elmDatosEmpleado(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (!is_array($resultadoTrait)) {
            return $resultadoTrait;
        }

        $this->cod_empleado = $resultadoTrait[0];
        return $this->eliminarEmpleado();
    }

    private function eliminarEmpleado()
    {
        try {
            $sentencia = "UPDATE `empleado` SET estado = 0 WHERE cod_empleado = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->bindValue(1, $this->cod_empleado);
            $delete->execute();
            return json_encode(['status' => 'deleted', 'message' => 'El empleado ha sido eliminado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}
