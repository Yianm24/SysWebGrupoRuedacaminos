<?php

namespace App\Model;

use App\Config\Conexion;

class Usuario extends Conexion
{

    private $cod_usuario;
    private $cedula;
    private $nombre;
    private $password;
    private $rol;
    private $estado;



    public function __construct()
    {
        parent::__construct();
    }

    public function verificarUsuarioExiste($cedula)
    {
        $sentencia = "SELECT COUNT(*) FROM usuario WHERE cedula = ? AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $cedula);
        $count->execute();
        return $count->fetchColumn() > 0;
    }
    public function regDatosUsuario($cedula, $nombre, $rol, $password)
    {

        $this->cedula = $cedula;
        $this->nombre = $this->formatearPalabra($nombre);
        $this->rol = $rol;
        $this->password = $password;
        $this->estado = 1;

        return $this->registrarUsuario();
    }

    private function registrarUsuario()
    {
        try {
            $sentencia = "INSERT INTO usuario (cedula,nombre,cod_rol,password,estado) VALUES (?, ?, ?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->cedula);
            $insert->bindValue(2, $this->nombre);
            $insert->bindValue(3, $this->rol);
            $insert->bindValue(4, $this->password);
            $insert->bindValue(5, $this->estado);

            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar el usuario: " . $e->getMessage() . "');</script>";
        }
    }

    public function obt_RegistrosUsuario()
    {
        try {
            $sentencia = "SELECT usuario.*, rol.nombre 
            AS nombre_rol
            FROM usuario
            INNER JOIN rol 
            ON usuario.cod_rol= rol.cod_rol
            WHERE usuario.estado=1";

            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function obt_RegistrosRol()
    {
        try {
            $sentencia = "SELECT nombre, cod_rol FROM rol WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }


    public function actDatosUsuario($cod_usuario, $cedula, $nombre, $rol, $password)
    {
        $this->cod_usuario = $cod_usuario;
        $this->nombre = $this->formatearPalabra($nombre);
        $this->cedula = $cedula;
        $this->password = $password;
        $this->rol = $rol;

        return $this->actualizarUsuario();
    }


    private function actualizarUsuario()
    {
        try {
            $sentencia = "UPDATE `usuario` SET cedula= ?, nombre = ?, cod_rol = ?, password = ? WHERE cod_usuario = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->cedula);
            $update->bindValue(2, $this->nombre);
            $update->bindValue(3, $this->rol);
            $update->bindValue(4, $this->password);
            $update->bindValue(5, $this->cod_usuario);


            $update->execute();
        } catch (\PDOException $e) {
            return "Error al actualizar el método de pago: " . $e->getMessage();
        }
    }


    public function elmDatoUsuario(int $cod_usuario)
    {
        $this->cod_usuario = $cod_usuario;

        return $this->eliminarUsuario();
    }

    private function eliminarUsuario()
    {
        try {
            $sentencia = "UPDATE `usuario` SET estado = 0 WHERE cod_usuario = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_usuario);
            $delete->execute();

            return "Usuario eliminado exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar el usuario: " . $e->getMessage();
        }
    }
}
