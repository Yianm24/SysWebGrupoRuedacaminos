<?php

namespace App\Controller;

use App\Model\GastoDespacho;

$gastoDespacho = new GastoDespacho();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        $resultado = $gastoDespacho->regDatosGastoDespacho(['descripcion', 'monto', 'cod_despacho']);
        header("Location: ?url=gastoDespacho&status={$resultado}");
        exit();
        break;

    case 'actualizar':
        $resultado = $gastoDespacho->actGastoDespacho(['cod_gasto_despacho', 'descripcion', 'monto', 'cod_despacho']);
        header("Location: ?url=gastoDespacho&status={$resultado}");
        exit();
        break;

    case 'eliminar':
        $resultado = $gastoDespacho->elmDatosGastoDespacho(['cod_gasto_despacho']);
        header("Location: ?url=gastoDespacho&status={$resultado}");
        exit();
        break;
}

$registros = $gastoDespacho->obt_RegistrosGastoDespacho();

include 'app/view/layout/header.php';
include 'app/view/gasto_despacho/gastoDespachoView.php';
include 'app/view/layout/footer.php';