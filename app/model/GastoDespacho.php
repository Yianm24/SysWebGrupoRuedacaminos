<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTrait;

class GastoDespacho extends Conexion
{
    use ValidadorTrait;

    private $cod_gasto_despacho;
    private $descripcion;
    private $monto;
    private $cod_despacho;
    private $estado;

    function __construct()
    {
        parent::__construct();
    }

    public function regDatosGastoDespacho(array $campos)
    {
        if (is_array($this->validarPost($campos, "gasto_despacho"))) {
            $datos = $this->validarPost($campos, "gasto_despacho");
            $this->descripcion = trim($datos['descripcion']);
            $this->monto = floatval($datos['monto']);
            $this->estado = 1;
        } else {
            return 'error&msg=Registrar';
        }
        return $this->registrarGastoDespacho();
    }

    private function registrarGastoDespacho()
    {
        try {
            $sentencia = "INSERT INTO gastos_despacho (descripcion, monto,  estado) VALUES (?, ?, ?)";
            $insert = $this->conexion->prepare($sentencia);
            $insert->execute([$this->descripcion, $this->monto,  $this->estado]);

            return 'success';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function obt_RegistrosGastoDespacho()
    {
        try {
            $sentencia = "SELECT * FROM gastos_despacho WHERE estado = 1";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            return $consulta->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de gasto despacho: " . $e->getMessage();
            return [];
        }
    }

    public function actGastoDespacho(array $campos)
    {
        if (is_array($this->validarPost($campos, "gasto_despacho"))) {
            $datos = $this->validarPost($campos, "gasto_despacho");
            $this->cod_gasto_despacho = $datos['cod_gasto_despacho'];
            $this->descripcion = trim($datos['descripcion']);
            $this->monto = floatval($datos['monto']);
            //$this->cod_despacho = intval($datos['cod_despacho']);
        } else {
            return 'error&msg=Actualizar';
        }

        return $this->actualizarGastoDespacho();
    }

    private function actualizarGastoDespacho()
    {
        try {
            $sentencia = "UPDATE gastos_despacho SET descripcion = ?, monto = ? WHERE cod_gasto_despacho = ?";
            $update = $this->conexion->prepare($sentencia);
            $update->execute([$this->descripcion, $this->monto, $this->cod_gasto_despacho]);
            return 'updated';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function elmDatosGastoDespacho(array $campos)
    {
        if (is_array($this->validarPost($campos, "gasto_despacho"))) {
            $datos = $this->validarPost($campos, "gasto_despacho");
            $this->cod_gasto_despacho = $datos['cod_gasto_despacho'];
        } else {
            return 'error&msg=Eliminar';
        }
        return $this->eliminarGastosDespacho();
    }

    private function eliminarGastosDespacho()
    {
        try {
            $sentencia = "UPDATE gastos_despacho SET estado = 0 WHERE cod_gasto_despacho = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->execute([$this->cod_gasto_despacho]);
            return 'deleted';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }
}