<?php

namespace App\Controller;

use App\Model\Estado;

$estado = new Estado();
$solicitud = $_POST['tipoSolicitud'] ?? '';

$registros = $estado->obt_RegistrosEstado();

switch ($solicitud) {
    case 'registrar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $estado->regDatosEstado([$datosAjax['nombre_estado']]);
        echo $resultado;
        exit();

        break;
    case 'actualizar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $estado->actDatosEstado([$datosAjax['cod_estado'], $datosAjax['nombre_estado']]);
        echo $resultado;
        exit();   
        break;
    case 'eliminar':

        $resultado = $estado->elmDatosEstado([$_POST['datos']['cod_estado']]);

        echo $resultado;
        exit();
        break;

    case 'consultar':

        echo $registros;
        exit();
        break;
}

include 'app/view/layout/header.php';
include 'app/view/estado/estadoView.php';
include 'app/view/layout/footer.php';
