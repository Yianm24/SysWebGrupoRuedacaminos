<?php

namespace App\Controller;

use App\Model\Moneda;

$moneda = new Moneda();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre']) && !empty($_POST['abreviatura'])) {

                $resultado = $moneda->regDatosMoneda($_POST['nombre'], $_POST['abreviatura']);

                header("Location: ?url=moneda&status=success");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
            break;
        }

    case 'eliminar':
        if (isset($_POST['cod_moneda'])) {
            $resultado = $moneda->elmDatosMoneda($_POST['cod_moneda']);
            header("Location: ?url=moneda&status=deleted");
            exit();
        }
        break;
}

$registros = $moneda->obt_RegistrosMoneda();
include 'app/view/layout/header.php';
include 'app/view/moneda/monedaView.php';
include 'app/view/layout/footer.php';
