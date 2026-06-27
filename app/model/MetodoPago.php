<?php

namespace App\Model;

use App\Config\Conexion;

class MetodoPago extends Conexion
{

    private $cod_metodo;
    private $nombre;
    private $moneda;
    private $estado;



    public function __construct()
    {
        parent::__construct();
    }


    public function regDatosMetodoPago($nombre, $moneda)
    {

        $this->nombre = $nombre;
        $this->moneda = $moneda;
        $this->estado = 1;
    }

    private function registrarMetodoPago()
    {
        try {
            $sentencia = "INSERT INTO metodo_pago (nombre,cod_moneda,estado) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->moneda);
            $insert->bindValue(3, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el vehiculo: " . $e->getMessage() . "');</script>";
        }
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

    public function obt_RegistrosMoneda()
    {
        try {
            $sentencia = "SELECT nombre FROM moneda WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }


    public function actDatosMetodoPago($cod_metodo, $nombre, $moneda)
    {
        $this->cod_metodo = $cod_metodo;
        $this->nombre = $nombre;
        $this->moneda = $moneda;



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
        } catch (\PDOException $e) {
            return "Error al actualizar el método de pago: " . $e->getMessage();
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
