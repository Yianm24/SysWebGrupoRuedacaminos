<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;


class MetodoPago extends Conexion
{
    use ValidadorTraitAjax;

    private $cod_metodo;
    private $nombre;
    private $cod_moneda;
    private $estado;



    public function __construct()
    {
        parent::__construct();
    }

    private function verificarMetodoPagoExiste($nombre, $cod_moneda)
    {

        $this->formatearPalabra($nombre);
        $sentencia = "SELECT COUNT(*) FROM metodo_pago WHERE nombre = ? AND cod_moneda = ? AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2, $cod_moneda);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function obt_RegistrosMetodoPago()
    {
        try {
            $sentencia = "SELECT metodo_pago.*, moneda.nombre 
            AS nombremoneda 
            FROM metodo_pago
            INNER JOIN moneda 
            ON metodo_pago.cod_moneda= moneda.cod_moneda
            WHERE metodo_pago.estado=1";

            $select = $this->conexion->prepare($sentencia);
            $select->execute();

            $registros = json_encode($select->fetchAll(\PDO::FETCH_ASSOC));
            return $registros;
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function regDatosMetodoPago(array $campos)
    {

        $resultadoTrait = $this->validarPost($campos);

        if ($this->verificarMetodoPagoExiste($this->formatearPalabra($resultadoTrait[0]), $resultadoTrait[1])) {
            return json_encode(['status' => 'exists', 'message' => 'El Metodo de Pago se encuentra registrada']);
        }

        if (is_array($resultadoTrait)) {

            $this->nombre = $this->formatearPalabra($resultadoTrait[0]);
            $this->cod_moneda = $resultadoTrait[1];
            $this->estado = 1;
        } else {

            return $resultadoTrait;
        }


        return $this->registrarMetodoPago();
    }

    private function registrarMetodoPago()
    {
        try {
            $sentencia = "INSERT INTO metodo_pago (nombre,cod_moneda,estado) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->cod_moneda);
            $insert->bindValue(3, $this->estado);

            $insert->execute();

            return json_encode(['status' => 'success', 'message' => 'El Metodo de Pago ha sido registrado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function actDatosMetodoPago(array $campos)
    {

        $resultadoTrait = $this->validarPost($campos);
        if ($this->verificarMetodoPagoExiste($this->formatearPalabra($resultadoTrait[1]), strtoupper($resultadoTrait[2]))) {
            return json_encode(['status' => 'exists', 'message' => 'El Metodo de Pago se encuentra registrada']);
        }


        if (is_array($resultadoTrait)) {

            $this->cod_metodo = $resultadoTrait[0];
            $this->nombre = $this->formatearPalabra($resultadoTrait[1]);
            $this->cod_moneda = $resultadoTrait[2];
        } else {
            return $resultadoTrait;
        }


        return $this->actualizarMetodoPago();
    }


    private function actualizarMetodoPago()
    {
        try {
            $sentencia = "UPDATE `metodo_pago` SET nombre = ?, cod_moneda = ? WHERE cod_metodo = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_moneda);
            $update->bindValue(3, $this->cod_metodo);

            $update->execute();
            return json_encode(['status' => 'updated', 'message' => 'El Metodo de pago ha sido actualizado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }


    public function elmDatosMetodoPago(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);

        if (is_array($resultadoTrait)) {

            $this->cod_metodo = $resultadoTrait[0];
        }else{
            return $resultadoTrait;
        }

        return $this->eliminarMetodoPago();
    }

    private function eliminarMetodoPago()
    {
        try {
            $sentencia = "UPDATE `metodo_pago` SET estado = 0 WHERE cod_metodo = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_metodo);
            $delete->execute();

            return json_encode(['status' => 'deleted', 'message' => 'El Metodo de Pago ha sido eliminada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}
