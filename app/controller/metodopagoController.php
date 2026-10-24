<?php

namespace App\Controller;

use App\Model\MetodoPago;
use App\Model\Moneda;

$metodo = new MetodoPago();
$moneda = new Moneda();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':


        if ($metodo->verificarMetodoPagoExiste($_POST['nombre'], $_POST['moneda'])) {
            header("Location: ?url=metodopago&status=exists");
            exit();
        }

        $resultado = $metodo->regDatosMetodoPago(['nombre', 'moneda']);
        header("Location: ?url=metodopago&status={$resultado}");


        break;

    case 'actualizar':


        if ($metodo->verificarMetodoPagoExiste($_POST['nombre'], $_POST['moneda'])) {
            header("Location: ?url=metodopago&status=exists");
            exit();
        }

        $resultado = $metodo->actDatosMetodoPago(['cod_metodo','nombre','moneda']);
        header("Location: ?url=metodopago&status={$resultado}");

        break;


    case 'eliminar':
        
            $resultado = $metodo->elmDatosMetodoPago(['cod_metodo']);
            header("Location: ?url=metodopago&status={$resultado}");
        break;
}

$regMoneda = $moneda->obt_RegistrosMoneda();
$registros = $metodo->obt_RegistrosMetodoPago();

include 'app/view/layout/header.php';
include 'app/view/metodopago/metodopagoView.php';
include 'app/view/layout/footer.php';
