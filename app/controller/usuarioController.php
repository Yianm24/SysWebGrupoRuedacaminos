<?php

namespace App\Controller;

use App\Model\Usuario;

$usuario = new Usuario();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['rol']) && !empty($_POST['nombre']) && !empty($_POST['cedula'])&& !empty($_POST['password'])) {
                if ($usuario->verificarUsuarioExiste($_POST['cedula'])) {
                    header("Location: ?url=usuario&status=exists");
                    exit();
                }

                $resultado = $usuario->regDatosUsuario($_POST['cedula'], $_POST['nombre'], $_POST['rol'], $_POST['password']);
                echo $resultado;
                header("Location: ?url=usuario&status=success");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;

    case 'actualizar':

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_metodo'])) {
            if (!empty($_POST['nombre']) && !empty($_POST['moneda'])) {

                $resultado = $metodo->actDatosMetodoPago($_POST['cod_metodo'], $_POST['nombre'], $_POST['moneda']);
                echo $resultado;
                header("Location: ?url=metodopago&status=updated");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</>";
            }
        }
        break;


    case 'eliminar':
        if (isset($_POST['cod_usuario'])) {
            echo "<script>confirm('¿Está seguro de que deseas eliminar este usuario?');</script>";
            $resultado = $usuario->elmDatosUsuario($_POST['cod_usuario']);
            header("Location: ?url=usuario&status=deleted");
            exit();
        }
        break;
}


$regRol = $usuario->obt_RegistrosRol();
$registros = $usuario->obt_RegistrosUsuario();

include 'app/view/layout/header.php';
include 'app/view/usuario/usuarioView.php';
include 'app/view/layout/footer.php';
