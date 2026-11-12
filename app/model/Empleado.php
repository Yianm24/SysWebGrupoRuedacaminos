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

    public function obt_EmpleadosCargoAjax(int $rol){
        try {
            $sentencia = "SELECT cod_empleado, nombre, apellido FROM empleado WHERE cod_cargo = ? AND estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute([$rol]);
            if ($select->rowCount() > 0) {
                return json_encode($select->fetchAll(\PDO::FETCH_ASSOC));
            } else {
                return [];
            }
        } catch (\PDOException $e) {
            return "<script>alert('Error al obtener los registros de empleados del cargo especificado: " . $e->getMessage() . "');</script>";
        }
    }

    public function obt_TodosLosCargos() {
        try {
            $sentencia = "SELECT cod_cargo, nombre FROM cargo WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
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
            return [];
        }
    }

    public function obt_RegistrosEmpleado()
    {
        try {
            $sentencia = "SELECT e.*, c.nombre as nombre_cargo FROM empleado e INNER JOIN cargo c ON e.cod_cargo = c.cod_cargo WHERE e.estado = 1";
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

    public function regDatosEmpleado(array $campos, $telEmergencia = '')
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $cedulaLimpia = $resultadoTrait[0];
            $nombreLimpio = $this->formatearPalabra($resultadoTrait[1]);
            $apellidoLimpio = $this->formatearPalabra($resultadoTrait[2]);
            $telefonoLimpio = $resultadoTrait[3];
            $cargoLimpio = $resultadoTrait[4];

            if(strlen($cedulaLimpia) < 7 || strlen($cedulaLimpia) > 9) 
                return json_encode(['status' => 'error', 'message' => 'Longitud de cédula inválida.']);

            $valCedula = $this->ExplorarDatos(['solo-numeros' => $cedulaLimpia]);
            if ($valCedula !== true) 
                return $valCedula;

            if(strlen($nombreLimpio) < 3 || strlen($nombreLimpio) > 25) 
                return json_encode(['status' => 'error', 'message' => 'Longitud de nombre inválida.']);

            $valNombre = $this->ExplorarDatos(['solo-letras' => $nombreLimpio]);
            if ($valNombre !== true) 
                return $valNombre;

            if(strlen($apellidoLimpio) < 3 || strlen($apellidoLimpio) > 25) 
                return json_encode(['status' => 'error', 'message' => 'Longitud de apellido inválida.']);

            $valApellido = $this->ExplorarDatos(['solo-letras' => $apellidoLimpio]);
            if ($valApellido !== true) 
                return $valApellido;

            if(strlen($telefonoLimpio) != 11) 
                return json_encode(['status' => 'error', 'message' => 'El teléfono debe tener 11 dígitos.']);
            $valTelefono = $this->ExplorarDatos(['solo-numeros' => $telefonoLimpio]);
            if ($valTelefono !== true) 
                return $valTelefono;

            $emergenciaLimpio = $this->input($telEmergencia, '');
            if($emergenciaLimpio !== '') {
                if(strlen($emergenciaLimpio) != 11) 
                    return json_encode(['status' => 'error', 'message' => 'El teléfono de emergencia debe tener 11 dígitos.']);

                $valEmergencia = $this->ExplorarDatos(['solo-numeros' => $emergenciaLimpio]);
                if ($valEmergencia !== true) 
                    return $valEmergencia;
            }

            $this->cedula = $cedulaLimpia;
            $this->nombre = $nombreLimpio;
            $this->apellido = $apellidoLimpio;
            $this->telefono = $telefonoLimpio;
            $this->telefono_emergencia = $emergenciaLimpio;
            $this->cod_cargo = $cargoLimpio;
            $this->estado = 1;
        } else {
            return $resultadoTrait;
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
            return "exception";
        }
    }


    public function modDatosEmpleado(array $campos, $telEmergencia = '')
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $codLimpio = $resultadoTrait[0];
            $cedulaLimpia = $resultadoTrait[1];
            $nombreLimpio = $this->formatearPalabra($resultadoTrait[2]);
            $apellidoLimpio = $this->formatearPalabra($resultadoTrait[3]);
            $telefonoLimpio = $resultadoTrait[4];
            $cargoLimpio = $resultadoTrait[5];
        
            if(strlen($cedulaLimpia) < 7 || strlen($cedulaLimpia) > 9) 
                return json_encode(['status' => 'error', 'message' => 'Longitud de cédula inválida.']);
            
            $valCedula = $this->ExplorarDatos(['solo-numeros' => $cedulaLimpia]);
            if ($valCedula !== true) 
                return $valCedula;

            if(strlen($nombreLimpio) < 3 || strlen($nombreLimpio) > 25) 
                return json_encode(['status' => 'error', 'message' => 'Longitud de nombre inválida.']);
            
            $valNombre = $this->ExplorarDatos(['solo-letras' => $nombreLimpio]);
            if ($valNombre !== true) 
                return $valNombre;

            if(strlen($apellidoLimpio) < 3 || strlen($apellidoLimpio) > 25) 
                return json_encode(['status' => 'error', 'message' => 'Longitud de apellido inválida.']);
            
            $valApellido = $this->ExplorarDatos(['solo-letras' => $apellidoLimpio]);
            if ($valApellido !== true) 
                return $valApellido;

            if(strlen($telefonoLimpio) != 11) 
                return json_encode(['status' => 'error', 'message' => 'El teléfono debe tener 11 dígitos.']);
            
            $valTelefono = $this->ExplorarDatos(['solo-numeros' => $telefonoLimpio]);
            if ($valTelefono !== true) 
                return $valTelefono;

            $emergenciaLimpio = $this->input($telEmergencia, '');
            if($emergenciaLimpio !== '') {

                if(strlen($emergenciaLimpio) != 11) 
                    return json_encode(['status' => 'error', 'message' => 'El teléfono de emergencia debe tener 11 dígitos.']);
                
                $valEmergencia = $this->ExplorarDatos(['solo-numeros' => $emergenciaLimpio]);
                if ($valEmergencia !== true) 
                    return $valEmergencia;
            }

            $this->cod_empleado = $codLimpio;
            $this->cedula = $cedulaLimpia;
            $this->nombre = $nombreLimpio;
            $this->apellido = $apellidoLimpio;
            $this->telefono = $telefonoLimpio;
            $this->telefono_emergencia = $emergenciaLimpio;
            $this->cod_cargo = $cargoLimpio;
        } else {
            return $resultadoTrait;
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
            return "exception";
        }
    }

    public function elmDatosEmpleado(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $this->cod_empleado = $resultadoTrait[0];
        } else {
            return $resultadoTrait;
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
            return "exception";
        }
    }
}
