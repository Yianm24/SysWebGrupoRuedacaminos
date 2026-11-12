<?php

namespace App\Controller;

use App\Model\Rol;

$rol = new Rol();
$solicitud = $_POST['tipoSolicitud'] ?? '';

$registros = $rol->obt_RegistrosRol();

switch ($solicitud) {
    case 'registrar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $rol->regDatosRol([$datosAjax['nombre_rol']]);
        echo $resultado;
        exit();
        break;


    case 'eliminar':
        if (isset($_POST['cod_rol'])) {

            $resultado = $rol->elmDatosRol($_POST['cod_rol']);
            header("Location: ?url=rol&status=deleted");
            exit();
        }
        break;

    case 'actualizar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $rol->actDatosRol([$datosAjax['cod_rol'], $datosAjax['nombre_rol']]);
        echo $resultado;
        exit();
        break;


    case 'consultar':

        echo $registros;
        exit();
        break;
}

include 'app/view/layout/header.php';
include 'app/view/rol/rolView.php';
include 'app/view/layout/footer.php';
