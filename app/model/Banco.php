<?php

namespace App\Model;
use App\Config\Conexion;

class Banco extends Conexion 
{
    private $cod_banco;
    private $banco;
    private $num_cuenta;
    private $titular;
    private $estado;


    public function __construct($banco = null, $num_cuenta = null, $titular = null, $estado = null)
    {
        parent::__construct();

        if ($banco !== null) {
            $this->banco = $banco;
        }
        $this->num_cuenta = $num_cuenta;
        $this->titular = $titular;
        $this->estado = $estado;
    }

    public function regDatosBanco($banco, $num_cuenta, $titular)
    {
        $this->banco = $banco;
        $this->num_cuenta = $num_cuenta;
        $this->titular = $titular;
        $this->estado = 1;

        return $this->registrarBanco();
    }

    private function registrarBanco()
    {
        try {
            $sentencia = "INSERT INTO banco (banco, num_cuenta, titular, estado) VALUES (?, ?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->banco);
            $insert->bindValue(2, $this->num_cuenta);
            $insert->bindValue(3, $this->titular);
            $insert->bindValue(4, $this->estado);

            $resultado = $insert->execute();

            return $resultado;

        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el banco: " . $e->getMessage() . "');</script>";
        }
    }
    
    public function obt_RegistrosBancos()
    {
        try {
            $sentencia = "SELECT cuenta_banco.*, banco.nombre AS nombrebanco 
              FROM cuenta_banco 
              INNER JOIN banco ON cuenta_banco.cod_banco = banco.cod_banco
              WHERE cuenta_banco.estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function actDatosBanco($cod_banco, $banco, $num_cuenta, $titular)
    {
        $this->cod_banco = $cod_banco;
        $this->banco = $banco;
        $this->num_cuenta = $num_cuenta;
        $this->titular = $titular;

        return $this->actualizarBanco();
    }

    private function actualizarBanco()
    {
        try {
            $sentencia = "UPDATE `banco` SET banco = ?, num_cuenta = ?, titular = ? WHERE cod_banco = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->banco);
            $update->bindValue(2, $this->num_cuenta);
            $update->bindValue(3, $this->titular);
            $update->bindValue(4, $this->cod_banco);

            $update->execute();

        } catch (\PDOException $e) {
            return "Error al actualizar el banco: " . $e->getMessage();
        }
    }

    public function elmDatosBanco(int $cod_banco)
    {
        $this->cod_banco = $cod_banco;

        return $this->eliminarBanco();
    }

    private function eliminarBanco()
    {
        try {
            $sentencia = "UPDATE `banco` SET estado = 0 WHERE cod_banco = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_banco);
            $delete->execute();

            return "Banco eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el banco: " . $e->getMessage();
        }
    }
}