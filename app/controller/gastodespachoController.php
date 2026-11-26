<?php

namespace App\Controller;

use App\Model\GastoDespacho;

$gastoDespacho = new GastoDespacho();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($gastoDespacho->verificarGastoDuplicado($_POST['cod_despacho'] ?? 0, $_POST['descripcion'] ?? '')) {
            header("Location: ?url=gastoDespacho&status=exists");
            exit();
        }

        $resultado = $gastoDespacho->regDatosGasto(['cod_despacho', 'descripcion', 'monto']);
        header("Location: ?url=gastoDespacho&status={$resultado}");
        exit();

    case 'actualizar':
        if ($gastoDespacho->verificarGastoDuplicado(
            $_POST['cod_despacho'] ?? 0,
            $_POST['descripcion'] ?? '',
            $_POST['cod_gasto_despacho'] ?? null
        )) {
            header("Location: ?url=gastoDespacho&status=exists");
            exit();
        }

        $resultado = $gastoDespacho->actGasto(['cod_gasto_despacho', 'cod_despacho', 'descripcion', 'monto']);
        header("Location: ?url=gastoDespacho&status={$resultado}");
        exit();

    case 'eliminar':
        $resultado = $gastoDespacho->elmDatosGasto(['cod_gasto_despacho']);
        header("Location: ?url=gastoDespacho&status={$resultado}");
        exit();
}

$registros = $gastoDespacho->obt_RegistrosGasto();

include 'app/view/layout/header.php';
include 'app/view/gastoDespacho/gastoDespachoView.php';
include 'app/view/layout/footer.php';