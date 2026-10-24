<?php

namespace App\Controller;

use App\Model\Moneda;

$moneda = new Moneda();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':

        if ($moneda->verificarMonedaExiste($_POST['nombre'], $_POST['abreviatura'])) {
            header("Location: ?url=moneda&status=exists");
            exit();
        }
        $resultado = $moneda->regDatosMoneda(['nombre', 'abreviatura']);

        header("Location: ?url=moneda&status={$resultado}");

        break;


    case 'eliminar':

        $resultado = $moneda->elmDatosMoneda('cod_moneda');
        header("Location: ?url=moneda&status={$resultado}");

        break;

    case 'modificar':
        if ($moneda->verificarMonedaExiste($_POST['nombre'], $_POST['abreviatura'])) {
            header("Location: ?url=moneda&status=exists");
            exit();
        }

        $resultado = $moneda->modDatosMoneda(['cod-moneda', 'nombre', 'abreviatura']);
        header("Location: ?url=moneda&status={$resultado}");

        break;
}

$registros = $moneda->obt_RegistrosMoneda();
include 'app/view/layout/header.php';
include 'app/view/moneda/monedaView.php';
include 'app/view/layout/footer.php';
