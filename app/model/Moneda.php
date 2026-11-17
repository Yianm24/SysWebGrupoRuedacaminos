<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;

class Moneda extends Conexion
{
    use ValidadorTraitAjax;

    private $cod_moneda;
    private $estado;
    private $nombre;
    private $abreviatura;

    public function __construct()
    {
        parent::__construct();
    }

    private function verificarMonedaExiste($nombre, $abreviatura)
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
            $registros = json_encode($select->fetchAll(\PDO::FETCH_ASSOC));
            return $registros;
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de unidad de medida: " . $e->getMessage();
            return [];
        }
    }

    public function regDatosMoneda(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);

        if ($this->verificarMonedaExiste($this->formatearPalabra($resultadoTrait[0]), strtoupper($resultadoTrait[1]))) {
            return json_encode(['status' => 'exists', 'message' => 'La Moneda se encuentra registrada']);
        }

        if (is_array($resultadoTrait)) {
            $this->nombre = $this->formatearPalabra($resultadoTrait[0]);
            $this->abreviatura = strtoupper($resultadoTrait[1]);
            $this->estado = 1;
        } else {
            return $resultadoTrait;
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

            return json_encode(['status' => 'success', 'message' => 'La moneda ha sido registrado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function modDatosMoneda(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);

        if ($this->verificarMonedaExiste($this->formatearPalabra($resultadoTrait[1]), strtoupper($resultadoTrait[2]))) {
            return json_encode(['status' => 'exists', 'message' => 'La Moneda se encuentra registrada']);
        }


        if (is_array($resultadoTrait)) {

            $this->cod_moneda = $resultadoTrait[0];
            $this->nombre = $this->formatearPalabra($resultadoTrait[1]);
            $this->abreviatura = strtoupper($resultadoTrait[2]);
        } else {
            return $resultadoTrait;
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

            return json_encode(['status' => 'updated', 'message' => 'La moneda ha sido modificiada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function elmDatosMoneda(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {

            $this->cod_moneda = $resultadoTrait[0];
        } else {
            return $resultadoTrait;
        }
        return $this->eliminarMoneda();
    }


    private function eliminarMoneda()
    {
        try {
            $sentencia = "UPDATE `moneda` SET estado = 0 WHERE cod_moneda = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_moneda);
            $delete->execute();

            return json_encode(['status' => 'deleted', 'message' => 'La moneda ha sido eliminada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}
