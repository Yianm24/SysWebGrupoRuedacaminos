<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTrait;

class Moneda extends Conexion
{
    use ValidadorTrait;

    private $cod_moneda;
    private $estado;
    private $nombre;
    private $abreviatura;

    public function __construct()
    {
        parent::__construct();
    }

    public function verificarMonedaExiste($nombre, $abreviatura)
    {
        $sentencia = "SELECT COUNT(*) FROM moneda WHERE nombre = ? and abreviatura = ? AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2, $abreviatura);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function obt_RegistrosMoneda()
    {
        try {
            $sentencia = "SELECT * FROM moneda WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function regDatosMoneda(array $campos)
    {
        if (is_array($this->validarPost($campos, "moneda"))) {

            $array = $this->validarPost($campos, "moneda");
            $this->nombre = $this->formatearPalabra($array['nombre']);
            $this->abreviatura = strtoupper($array['abreviatura']);
            $this->estado = 1;
        } else {
            return 'error&msg=Registrar';
        }
        return $this->registrarMoneda();
    }


    private function registrarMoneda()
    {
        try {
            $sentencia = "INSERT INTO moneda (nombre,abreviatura, estado) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->abreviatura);
            $insert->bindValue(3, $this->estado);

            $insert->execute();

            return 'success';
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el vehiculo: " . $e->getMessage() . "');</script>";
        }
    }

    public function modDatosMoneda(array $campos)
    {
        if (is_array($this->validarPost($campos, "moneda"))) {

            $array = $this->validarPost($campos, "moneda");
            $this->cod_moneda = $array['cod_moneda'];
            $this->nombre = $this->formatearPalabra($array['nombre']);
            $this->abreviatura = strtoupper($array['abreviatura']);
        }
        return $this->modificarMoneda();
    }

    private function modificarMoneda()
    {
        try {
            $sentencia = "UPDATE `moneda` SET nombre = ?, abreviatura = ? WHERE cod_moneda = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->abreviatura);
            $update->bindValue(3, $this->cod_moneda);

            $update->execute();
            return 'updated';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function elmDatosMoneda(int $cod_moneda)
    {
        $this->cod_moneda = $cod_moneda;

        return $this->eliminarMoneda();
    }


    private function eliminarMoneda()
    {
        try {
            $sentencia = "UPDATE `moneda` SET estado = 0 WHERE cod_moneda = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_moneda);
            $delete->execute();

            return "Moneda eliminada exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar la moneda: " . $e->getMessage();
        }
    }
}
