<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTrait;


class MetodoPago extends Conexion
{
    use ValidadorTrait;

    private $cod_metodo;
    private $nombre;
    private $moneda;
    private $estado;



    public function __construct()
    {
        parent::__construct();
    }

    public function verificarMetodoPagoExiste($nombre, $moneda)
    {
        $sentencia = "SELECT COUNT(*) FROM metodo_pago WHERE nombre = ? AND cod_moneda = ? AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2, $moneda);
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
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function regDatosMetodoPago(array $campos)
    {
        if (is_array($this->validarPost($campos))) {

            $array = $this->validarPost($campos);

            $this->nombre = $this->formatearPalabra($array['nombre']);
            $this->moneda = $array['moneda'];
            $this->estado = 1;
        } else {

            return 'error&msg=Registrar';
        }


        return $this->registrarMetodoPago();
    }

    private function registrarMetodoPago()
    {
        try {
            $sentencia = "INSERT INTO metodo_pago (nombre,cod_moneda,estado) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->moneda);
            $insert->bindValue(3, $this->estado);

            $insert->execute();

            return 'success';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function actDatosMetodoPago(array $campos)
    {
        if (is_array($this->validarPost($campos))) {

            $array = $this->validarPost($campos);
            $this->cod_metodo = $array['cod_metodo'];
            $this->nombre = $this->formatearPalabra($array['nombre']);
            $this->moneda = $array['moneda'];
        } else {
            return 'error&msg=Actualizar';
        }


        return $this->actualizarMetodoPago();
    }


    private function actualizarMetodoPago()
    {
        try {
            $sentencia = "UPDATE `metodo_pago` SET nombre = ?, cod_moneda = ? WHERE cod_metodo = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->moneda);
            $update->bindValue(3, $this->cod_metodo);

            $update->execute();
            return 'updated';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }


    public function elmDatosMetodoPago(int $cod_metodo)
    {
        $this->cod_metodo = $cod_metodo;

        return $this->eliminarMetodoPago();
    }

    private function eliminarMetodoPago()
    {
        try {
            $sentencia = "UPDATE `metodo_pago` SET estado = 0 WHERE cod_metodo = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_metodo);
            $delete->execute();

            return "Método de pago eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el método de pago: " . $e->getMessage();
        }
    }
}
