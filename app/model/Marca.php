<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTrait;

class Marca extends Conexion
{

    use ValidadorTrait;
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

    public function regDatosMarca(array $campos)
    {
        if (is_array($this->validarPost($campos, "marca"))) {
            $datos = $this->validarPost($campos, "marca");
            $this->nombre = strtoupper($datos['nombre_marca']);
            $this->estado = 1;
        } else {
            return 'error&msg=Registrar';
        }
        return $this->registrarMarca();
    }

    private function registrarMarca()
    {
        try {
            $sentencia = "INSERT INTO marca (nombre,estado) VALUES (?,?)";

            $insert = $this->conexion->prepare($sentencia);
            $insert->execute([$this->nombre, $this->estado]);

            return 'success';
        } catch (\PDOException $e) {
            return  "exception&msg=" . urlencode($e->getMessage());
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
        if (is_array($this->validarPost($campos, "marca"))) {
            $datos = $this->validarPost($campos, "marca");
            $this->cod_marca = $datos['cod_marca'];
            $this->nombre = strtoupper($datos['nombre_marca']);
        } else {
            return 'error&msg=Actualizar';
        }

        return $this->actualizarMarca();
    }

    private function actualizarMarca()
    {
        try {
            $sentencia = "UPDATE `marca` SET nombre = ? WHERE cod_marca = ?";
            $update = $this->conexion->prepare($sentencia);
            $update->execute([$this->nombre, $this->cod_marca]);
            return 'updated';
        } catch (\PDOException $e) {
            return  "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function elmDatosMarca(array $campos)
    {
        if (is_array($this->validarPost($campos, "marca"))) {
            $datos = $this->validarPost($campos, "marca");
            $this->cod_marca = $datos['cod_marca'];
        } else {
            return 'error&msg=Eliminar';
        }
        return $this->eliminarMarca();
    }

    private function eliminarMarca()
    {
        try {
            $sentencia = "UPDATE `marca` SET estado = 0 WHERE cod_marca = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->execute([$this->cod_marca]);
            return 'deleted';
        } catch (\PDOException $e) {
            return  "exception&msg=" . urlencode($e->getMessage());
        }
    }
}
