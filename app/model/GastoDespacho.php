<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTrait;

class GastoDespacho extends Conexion
{
    use ValidadorTrait;

    private $cod_gasto_despacho;
    private $cod_despacho;
    private $cod_despacho_bd;
    private $descripcion;
    private $monto;
    private $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function existeDespacho($cod_despacho): bool
    {
        if (empty($cod_despacho) || (int) $cod_despacho <= 0) {
            return false;
        }
        $sentencia = "SELECT COUNT(*) FROM despacho WHERE cod_despacho = ?;";
        $stmt = $this->conexion->prepare($sentencia);
        $stmt->execute([(int) $cod_despacho]);
        return $stmt->fetchColumn() > 0;
    }

    public function verificarGastoDuplicado($cod_despacho, $descripcion, $cod_gasto_despacho = null)
    {
        $descripcionNormalizada = strtoupper(trim((string) $descripcion));
        $codDespachoValidar = $this->existeDespacho($cod_despacho) ? (int) $cod_despacho : null;

        if ($cod_gasto_despacho === null || $cod_gasto_despacho === '') {
            if ($codDespachoValidar === null) {
                $sentencia = "SELECT COUNT(*) FROM gastos_despacho WHERE cod_despacho IS NULL AND UPPER(TRIM(descripcion)) = ? AND estado = 1;";
                $stmt = $this->conexion->prepare($sentencia);
                $stmt->execute([$descripcionNormalizada]);
            } else {
                $sentencia = "SELECT COUNT(*) FROM gastos_despacho WHERE cod_despacho = ? AND UPPER(TRIM(descripcion)) = ? AND estado = 1;";
                $stmt = $this->conexion->prepare($sentencia);
                $stmt->execute([$codDespachoValidar, $descripcionNormalizada]);
            }
        } else {
            if ($codDespachoValidar === null) {
                $sentencia = "SELECT COUNT(*) FROM gastos_despacho WHERE cod_despacho IS NULL AND UPPER(TRIM(descripcion)) = ? AND cod_gasto_despacho != ? AND estado = 1;";
                $stmt = $this->conexion->prepare($sentencia);
                $stmt->execute([$descripcionNormalizada, (int) $cod_gasto_despacho]);
            } else {
                $sentencia = "SELECT COUNT(*) FROM gastos_despacho WHERE cod_despacho = ? AND UPPER(TRIM(descripcion)) = ? AND cod_gasto_despacho != ? AND estado = 1;";
                $stmt = $this->conexion->prepare($sentencia);
                $stmt->execute([$codDespachoValidar, $descripcionNormalizada, (int) $cod_gasto_despacho]);
            }
        }

        return $stmt->fetchColumn() > 0;
    }

    public function regDatosGasto(array $campos)
    {
        $datos = $this->validarPost($campos, "gastoDespacho");
        if (!is_array($datos)) {
            return 'error&msg=Registrar';
        }

        $montoLimpio = str_replace(',', '.', trim((string) $datos['monto']));
        if (!is_numeric($montoLimpio)) {
            return 'error&msg=Monto';
        }

        $this->cod_despacho    = (int) $datos['cod_despacho'];
        $this->descripcion     = strtoupper(trim((string) $datos['descripcion']));
        $this->monto           = round((float) $montoLimpio, 2);
        $this->estado          = 1;
        $this->cod_despacho_bd = $this->existeDespacho($this->cod_despacho) ? $this->cod_despacho : null;

        if ($this->cod_despacho <= 0 || $this->descripcion === '' || $this->monto <= 0 || $this->monto > 9999.99) {
            return 'error&msg=Validacion';
        }

        return $this->registrarGasto();
    }

    private function registrarGasto()
    {
        try {
            $sentencia = "INSERT INTO gastos_despacho (cod_despacho, descripcion, monto, estado) VALUES (?, ?, ?, ?)";
            $insert = $this->conexion->prepare($sentencia);
            $insert->execute([
                $this->cod_despacho_bd,
                $this->descripcion,
                $this->monto,
                $this->estado
            ]);

            return 'success';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function obt_RegistrosGasto()
    {
        try {
            $sentencia = "
                SELECT 
                    g.cod_gasto_despacho,
                    g.cod_despacho,
                    g.descripcion,
                    g.monto,
                    g.estado,
                    CASE 
                        WHEN g.cod_despacho IS NULL OR d.cod_despacho IS NULL THEN 'no se encontro despacho asociado'
                        ELSE CAST(g.cod_despacho AS CHAR)
                    END AS despacho_texto
                FROM gastos_despacho g
                LEFT JOIN despacho d ON g.cod_despacho = d.cod_despacho
                WHERE g.estado = 1
                ORDER BY g.cod_gasto_despacho DESC
            ";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            return $consulta->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de gastos de despacho: " . $e->getMessage();
            return [];
        }
    }

    public function actGasto(array $campos)
    {
        $datos = $this->validarPost($campos, "gastoDespacho");
        if (!is_array($datos)) {
            return 'error&msg=Actualizar';
        }

        $montoLimpio = str_replace(',', '.', trim((string) $datos['monto']));
        if (!is_numeric($montoLimpio)) {
            return 'error&msg=Monto';
        }

        $this->cod_gasto_despacho = (int) $datos['cod_gasto_despacho'];
        $this->cod_despacho       = (int) $datos['cod_despacho'];
        $this->descripcion        = strtoupper(trim((string) $datos['descripcion']));
        $this->monto              = round((float) $montoLimpio, 2);
        $this->cod_despacho_bd    = $this->existeDespacho($this->cod_despacho) ? $this->cod_despacho : null;

        if ($this->cod_gasto_despacho <= 0 || $this->cod_despacho <= 0 || $this->descripcion === '' || $this->monto <= 0 || $this->monto > 9999.99) {
            return 'error&msg=Validacion';
        }

        return $this->actualizarGasto();
    }

    private function actualizarGasto()
    {
        try {
            $sentencia = "UPDATE gastos_despacho SET cod_despacho = ?, descripcion = ?, monto = ? WHERE cod_gasto_despacho = ?";
            $update = $this->conexion->prepare($sentencia);
            $update->execute([
                $this->cod_despacho_bd,
                $this->descripcion,
                $this->monto,
                $this->cod_gasto_despacho
            ]);

            return 'updated';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function elmDatosGasto(array $campos)
    {
        $datos = $this->validarPost($campos, "gastoDespacho");
        if (!is_array($datos)) {
            return 'error&msg=Eliminar';
        }

        $this->cod_gasto_despacho = (int) $datos['cod_gasto_despacho'];
        if ($this->cod_gasto_despacho <= 0) {
            return 'error&msg=Eliminar';
        }

        return $this->eliminarGasto();
    }

    private function eliminarGasto()
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