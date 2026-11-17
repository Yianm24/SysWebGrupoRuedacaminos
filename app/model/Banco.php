<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;

class Banco extends Conexion
{
    use ValidadorTraitAjax;

    private $cod_banco;
    private $nombre;
    private $estado;

    function __construct()
    {
        parent::__construct();
    }

    private function verificarBancoDuplicado($nombre)
    {
        $sentencia = "SELECT COUNT(*) FROM banco WHERE nombre = ? AND estado = 1;";

        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function obt_RegistrosBanco()
    {
        try {
            $sentencia = "SELECT * FROM banco WHERE estado = 1";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            $registros = json_encode($consulta->fetchAll(\PDO::FETCH_ASSOC));

            return $registros;
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de banco: " . $e->getMessage();
            return [];
        }
    }


    public function regDatosBanco(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);

        if ($this->verificarBancoDuplicado($this->formatearPalabra($resultadoTrait[0]))) {

            return json_encode(['status' => 'exists', 'message' => 'El Banco se encuentra registrado']);
        }

        if (is_array($resultadoTrait)) {
            $this->nombre = $this->formatearPalabra($resultadoTrait[0]);
            $this->estado = 1;
        } else {
            return $resultadoTrait;
        }
        return $this->registrarBanco();
    }

    private function registrarBanco()
    {
        try {
            $sentencia = "INSERT INTO banco (nombre,estado) VALUES (?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado);
            $insert->execute();

            return json_encode(['status' => 'success', 'message' => 'El Banco ha sido registrado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function actDatosBanco(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);

        if ($this->verificarBancoDuplicado($this->formatearPalabra($resultadoTrait[1]))) {

            return json_encode(['status' => 'exists', 'message' => 'El Banco se encuentra registrado']);
        }
        
        if (is_array($resultadoTrait)) {

            $this->cod_banco = $resultadoTrait[0];
            $this->nombre =  $this->formatearPalabra($resultadoTrait[1]);
        } else {
            return $resultadoTrait;
        }
        return $this->actualizarBanco();
    }

    private function actualizarBanco()
    {
        try {
            $sentencia = "UPDATE `banco` SET nombre = ? WHERE cod_banco = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_banco);

            $update->execute();
            return json_encode(['status' => 'updated', 'message' => 'El Banco ha sido actualizado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function elmDatosBanco(array $campos)
    {

        $resultadoTrait = $this->validarPost($campos);

        if (is_array($resultadoTrait)) {
            $this->cod_banco = $resultadoTrait[0];
        } else {
            return $resultadoTrait;
        }
        return $this->eliminarBanco();
    }

    private function eliminarBanco()
    {
        try {
            $sentencia = "UPDATE `banco` SET estado = 0 WHERE cod_banco = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_banco);
            $delete->execute();

            return json_encode(['status' => 'deleted', 'message' => 'El Banco ha sido eliminado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}
