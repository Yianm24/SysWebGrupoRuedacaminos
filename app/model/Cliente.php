<?php

namespace App\Model;

use App\Config\Conexion;

class Cliente extends Conexion
{

    private $cod_cliente;
    private $doc_identidad;
    private $razon_social;
    private $apellido;
    private $telefono;
    private $email;
    private $tipo_documento;
    private $estado;


    public function __construct($doc_identidad = null, $razon_social = null, $apellido = null, $telefono = null, $email = null, $tipo_documento = null, $estado = null)
    {
        parent::__construct();

        if ($doc_identidad !== null) {
            $this->doc_identidad = $doc_identidad;
        }
        $this->razon_social = $razon_social;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->tipo_documento = $tipo_documento;
        $this->estado = $estado;
    }

    public function regDatosCliente($doc_identidad, $razon_social, $apellido, $telefono, $email, $tipo_documento)
    {

        $this->doc_identidad = $doc_identidad;
        $this->razon_social = $razon_social;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->tipo_documento = $tipo_documento;
        $this->estado = 1;

        return $this->registrarCliente();
    }

    public function registrarCliente()
    {
        try {

            $sentencia = "INSERT INTO cliente (doc_identidad, razon_social, apellido, telefono,email,tipo_documento,estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert = $this->conexion->prepare($sentencia);
            $insert->bindValue(1, $this->doc_identidad);
            $insert->bindValue(2, $this->razon_social);
            $insert->bindValue(3, $this->apellido);
            $insert->bindValue(4, $this->telefono);
            $insert->bindValue(5, $this->email);
            $insert->bindValue(6, $this->tipo_documento);
            $insert->bindValue(7, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar al cliente: " . $e->getMessage() . "');</script>";
        }
    }


    public function editDatosCliente($cod_cliente, $doc_identidad, $razon_social, $apellido, $telefono, $email, $tipo_documento)
    {
        $this->cod_cliente = $cod_cliente;
        $this->doc_identidad = $doc_identidad;
        $this->razon_social = $razon_social;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->tipo_documento = $tipo_documento;

        return $this->editarCliente();
    }

    private function editarCliente()
    {
        try {
            $sentencia = "UPDATE `cliente` SET doc_identidad = ?, razon_social = ?, apellido = ?, telefono = ?, email = ?, tipo_documento = ? WHERE cod_cliente = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->doc_identidad);
            $update->bindValue(2, $this->razon_social);
            $update->bindValue(3, $this->apellido);
            $update->bindValue(4, $this->telefono);
            $update->bindValue(5, $this->email);
            $update->bindValue(6, $this->tipo_documento);
            $update->bindValue(7, $this->cod_cliente);

            $update->execute();
        } catch (\PDOException $e) {
            return "Error al editar el cliente: " . $e->getMessage();
        }
    }


    public function obt_RegistrosClientes()
    {

        try {
            $sentencia = "SELECT * FROM cliente WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function elmDatosCliente(int $cod_cliente)
    {
        $this->cod_cliente = $cod_cliente;

        return $this->eliminarCliente();
    }

    public function eliminarCliente()
    {
        try {
            $sentencia = "UPDATE `cliente` SET estado = 0 WHERE cod_cliente = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->bindValue(1, $this->cod_cliente);
            $delete->execute();
            return "Cliente eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el cliente: " . $e->getMessage();
        }
    }
}
