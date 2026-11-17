<?php

namespace App\Controller;

use App\Model\Moneda;

$moneda = new Moneda();
$registros = $moneda->obt_RegistrosMoneda();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);
        $resultado = $moneda->regDatosMoneda([$datosAjax['nombre_moneda'], $datosAjax['abreviatura']]);

        echo $resultado;
        exit();

        break;

    case 'modificar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);
        $resultado = $moneda->modDatosMoneda([$datosAjax['cod_moneda'], $datosAjax['nombre_moneda'], $datosAjax['abreviatura']]);
        echo $resultado;
        exit();

        break;

    case 'eliminar':

        $resultado = $moneda->elmDatosMoneda([$_POST['datos']['cod_moneda']]); 
        echo $resultado;
        exit();

        break;

    case 'consultar':

        echo $registros;
        exit();
        break;
}
include 'app/view/layout/header.php';
include 'app/view/moneda/monedaView.php';
include 'app/view/layout/footer.php';
