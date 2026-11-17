<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;

class Estado extends Conexion
{
    use ValidadorTraitAjax;

    private $cod_estado;
    private $nombre;
    private $estado;

    function __construct()
    {
        parent::__construct();
    }

    private function verificarEstadoDuplicado($nombre)
    {
        $sentencia = "SELECT COUNT(*) FROM Estado WHERE nombre = ? AND estado = 1;";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);

        $count->execute();
        return $count->fetchColumn() > 0;
    }


    public function obt_RegistrosEstado()
    {
        try {
            $sentencia = "SELECT * FROM Estado WHERE estado = 1";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            $registros = json_encode($consulta->fetchAll(\PDO::FETCH_ASSOC));
            return $registros;
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de unidad de medida: " . $e->getMessage();
            return [];
        }
    }

    public function regDatosEstado(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);

        // verifica si el estado se encuentra registrado anteriormente en la BD
        if ($this->verificarEstadoDuplicado($this->formatearPalabra($resultadoTrait[0]))) {
            return json_encode(['status' => 'exists', 'message' => 'El Estado se encuentra registrado']);
        }

        //verifica si lo retornado por el trait validador es un array con los datos del registro
        if (is_array($resultadoTrait)) {

            $this->nombre = $this->formatearPalabra($resultadoTrait[0]);
            $this->estado = 1;
        } else {
            return $resultadoTrait;
        }
        return $this->registrarEstado();
    }

    private function registrarEstado()
    {
        try {
            $sentencia = "INSERT INTO Estado (nombre,estado) VALUES (?,?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado);
            $insert->execute();

            return json_encode(['status' => 'success', 'message' => 'El Estado ha sido registrado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function actDatosEstado(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);

        if ($this->verificarEstadoDuplicado($this->formatearPalabra($resultadoTrait[1]))) {
            return json_encode(['status' => 'exists', 'message' => 'El Estado se encuentra registrado']);
        }


        if (is_array($resultadoTrait)) {

            $this->cod_estado = $resultadoTrait[0];
            $this->nombre = $this->formatearPalabra($resultadoTrait[1]);
        } else {
            return $resultadoTrait;
        }
        return $this->actualizarEstado();
    }

    private function actualizarEstado()
    {
        try {
            $sentencia = "UPDATE `Estado` SET nombre = ? WHERE cod_estado = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_estado);

            $update->execute();

            return json_encode(['status' => 'updated', 'message' => 'El Estado ha sido actualizado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function elmDatosEstado(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {

            $this->cod_estado = $resultadoTrait[0];
        } else {
            return $resultadoTrait;
        }

        return $this->eliminarEstado();
    }

    private function eliminarEstado()
    {
        try {
            $sentencia = "UPDATE `Estado` SET estado = 0 WHERE cod_estado = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_estado);
            $delete->execute();

            return json_encode(['status' => 'deleted', 'message' => 'El Estado ha sido eliminado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}
