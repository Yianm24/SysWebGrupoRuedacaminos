<?php

namespace App\Controller;

use App\Model\Usuario;

$usuario = new Usuario();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $usuario->regDatosUsuario([
            $datosAjax['nombre_usuario'],
            $datosAjax['cedula'],
            $datosAjax['password'],
            $datosAjax['cod_rol']
        ]);
        echo $resultado;
        exit();

        break;

    case 'actualizar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $usuario->actDatosUsuario([
            $datosAjax['cod_usuario'],
            $datosAjax['cedula'],
            $datosAjax['nombre_usuario'],
            $datosAjax['cod_rol'],
            $datosAjax['password']
        ]);
        echo $resultado;
        exit();
        break;


    case 'eliminar':
        $resultado = $usuario->elmDatosUsuario([$_POST['datos']['cod_usuario']]);
        echo $resultado;
        exit();
        break;

    case 'consultar':
        $registros = $usuario->obt_RegistrosUsuario();
        echo $registros;
        exit();
        break;
}

include 'app/view/layout/header.php';
include 'app/view/usuario/usuarioView.php';
include 'app/view/layout/footer.php';
