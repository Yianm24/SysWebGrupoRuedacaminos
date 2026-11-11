<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;
use App\Traits\ExpRegexTrait;


class Marca extends Conexion
{

    use ValidadorTraitAjax;
    use ExpRegexTrait;
    private $cod_marca;
    private $nombre;
    private $estado;

    function __construct()
    {
        parent::__construct();
    }

    public function verificarMarcaDuplicada($nombre, $cod_marca = null)
    {
        if ($cod_marca === null) {
            $sentencia = "SELECT COUNT(*) FROM marca WHERE nombre = ? AND estado = 1;";
        } else {
            $sentencia = "SELECT COUNT(*) FROM marca WHERE nombre = ? AND cod_marca != ? AND estado = 1;";
        }
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2, $cod_marca);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function regDatosMarca(array $campos,array $validar)
    {
        $resultadoTrait = $this->ExplorarDatos($validar);
        if(is_string($resultadoTrait)){
            return $resultadoTrait;
        }else {
            $resultadoTrait = $this->validarPost($campos); 
            if (is_array($resultadoTrait)) {
                $this->nombre = strtoupper($resultadoTrait[0]);
                $this->estado = 1;
            } else {
                return $resultadoTrait;
            }
        }
        return $this->registrarMarca();
    }

    private function registrarMarca()
    {
        try {
            $sentencia = "INSERT INTO marca (nombre,estado) VALUES (?,?)";

            $insert = $this->conexion->prepare($sentencia);
            $insert->execute([$this->nombre, $this->estado]);
            
            return json_encode(['status' => 'success', 'message' => 'Marca registrada correctamente.']);
        } catch (\PDOException $e) {
            return  json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function obt_RegistrosMarcaOld()
    {

        try {
            $sentencia = "SELECT * FROM marca WHERE estado = 1";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            return $consulta->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de unidad de medida: " . $e->getMessage();
            return [];
        }
    }

    public function obt_RegistrosMarca()
    {

        try {
            $sentencia = "SELECT * FROM marca WHERE estado = 1";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            $registros = json_encode($consulta->fetchAll(\PDO::FETCH_ASSOC));
            return $registros;
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function actMarca(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos); 
        if (is_array($resultadoTrait)) {
            $this->cod_marca = $resultadoTrait[0];
            $this->nombre = strtoupper($resultadoTrait[1]);
        } else {
            return $resultadoTrait;
        }

        return $this->actualizarMarca();
    }

    private function actualizarMarca()
    {
        try {
            $sentencia = "UPDATE `marca` SET nombre = ? WHERE cod_marca = ?";
            $update = $this->conexion->prepare($sentencia);
            $update->execute([$this->nombre, $this->cod_marca]);
            return json_encode(['status' => 'updated', 'message' =>  'La Marca ha sido actualizada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function elmDatosMarca(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            
            $this->cod_marca = $resultadoTrait[0];
        } else {
            return $resultadoTrait;
        }
        return $this->eliminarMarca();
    }

    private function eliminarMarca()
    {
        try {
            $sentencia = "UPDATE `marca` SET estado = 0 WHERE cod_marca = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->execute([$this->cod_marca]);
            return json_encode(['status' => 'deleted', 'message' => 'La Marca ha sido eliminada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}
