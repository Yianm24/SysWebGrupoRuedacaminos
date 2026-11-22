<?php

namespace App\Controller;

use App\Model\MetodoPago;

$metodo = new MetodoPago();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $metodo->regDatosMetodoPago([$datosAjax['nombre_metodopago'], $datosAjax['cod_moneda']]);
        echo $resultado;
        exit();
        break;

    case 'actualizar':
        $datosAjax = json_decode(json_encode($_POST['datos']), true);
        $resultado = $metodo->actDatosMetodoPago([$datosAjax['cod_metodopago'], $datosAjax['nombre_metodopago'], $datosAjax['cod_moneda']]);
        echo $resultado;
        exit();
        break;

    case 'eliminar':

        $resultado = $metodo->elmDatosMetodoPago([$_POST['datos']['cod_metodopago']]);
        echo $resultado;
        exit();
        break;

    case 'consultar':
        $registros = $metodo->obt_RegistrosMetodoPago();
        echo $registros;
        exit();
        break;
}

include 'app/view/layout/header.php';
include 'app/view/metodopago/metodopagoView.php';
include 'app/view/layout/footer.php';
