<?php

namespace App\Model;

use App\Config\Conexion;

class Cuenta extends Conexion
{
    private $cod_cuenta;
    private $propietario;
    private $etiqueta;
    private $num_cuenta; 
    private $banco;
    private $estado;


    public function __construct()
    {
        parent::__construct();

    }

    public function verificarCuentaDuplicada($etiqueta, $num_cuenta, $cod_cuenta = null) {
        if ($cod_cuenta === null) {
            $sentencia = "SELECT COUNT(*) FROM cuenta_banco WHERE etiqueta=? AND numero_cuenta = ? AND estado = 1;";
        } else {
            $sentencia = "SELECT COUNT(*) FROM cuenta_banco WHERE etiqueta=? AND numero_cuenta = ? AND cod_cuenta != ? AND estado = 1;";
        }
        //$sentencia = "SELECT COUNT(*) FROM cuenta_banco WHERE etiqueta=? AND numero_cuenta = ? AND cod_cuenta = ? AND estado = 1;";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $etiqueta);
        $count->bindValue(2, $num_cuenta);
        $count->bindValue(3, $cod_cuenta);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function regDatosCuenta($propietario, $etiqueta, $num_cuenta, $banco)
    {
        $this->propietario = $propietario;
        $this->etiqueta = $etiqueta;
        $this->num_cuenta = $num_cuenta;
        $this->banco = $banco;
        $this->estado = 1;
    
        return $this->registrarCuenta();
    }

    private function registrarCuenta()
    {
        try {
            $sentencia = "INSERT INTO `cuenta_banco`(`propietario`, `etiqueta`, `numero_cuenta`, `cod_banco`, `estado`) VALUES (?,?,?,?,?)";
            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->propietario);
            $insert->bindValue(2, $this->etiqueta);
            $insert->bindValue(3, $this->num_cuenta);
            $insert->bindValue(4, $this->banco);
            $insert->bindValue(5, $this->estado);

            $resultado = $insert->execute();
            return $resultado;
            

            
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el banco: " . $e->getMessage() . "');</script>";
        }
    }

    public function obt_RegistrosCuentas()
    {
        try {
            $sentencia = "SELECT cuenta_banco.*, banco.nombre AS nombrebanco ,banco.cod_banco
              FROM cuenta_banco 
              INNER JOIN banco 
              ON cuenta_banco.cod_banco = banco.cod_banco
              WHERE cuenta_banco.estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
    
    public function obt_RegistrosBancos()
    {
        try {
            $sentencia = "SELECT * FROM banco WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
    
    public function actDatosCuenta($cod_cuenta,$propietario, $etiqueta, $num_cuenta, $banco)
    {
        $this->cod_cuenta = $cod_cuenta;
        $this->propietario = $propietario;
        $this->etiqueta = $etiqueta;
        $this->num_cuenta = $num_cuenta;
        $this->banco = $banco;

        return $this->actualizarCuenta();
    }

    private function actualizarCuenta()
    {
        try {
            $sentencia = "UPDATE `cuenta_banco` SET propietario = ?, etiqueta = ?, numero_cuenta = ?, cod_banco = ? WHERE cod_cuenta = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->propietario);
            $update->bindValue(2, $this->etiqueta);
            $update->bindValue(3, $this->num_cuenta);
            $update->bindValue(4, $this->banco);
            $update->bindValue(5, $this->cod_cuenta);

            $update->execute();
        } catch (\PDOException $e) {
            return "<script>alert('Error al actualizar la cuenta: " . $e->getMessage() . "');</script>";
        }
    }

    public function elmDatosCuenta(int $cod_cuenta)
    {
        $this->cod_cuenta = $cod_cuenta;

        return $this->eliminarCuenta();
    }

    private function eliminarCuenta()
    {
        try {
            $sentencia = "UPDATE `cuenta_banco` SET estado = 0 WHERE cod_cuenta = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_cuenta);
            $delete->execute();

            return "Cuenta eliminada exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar la cuenta: " . $e->getMessage();
        }
    }
}
