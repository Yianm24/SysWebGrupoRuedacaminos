<?php

namespace App\Controller;

use App\Model\MetodoPago;

$metodo = new MetodoPago();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['moneda']) && !empty($_POST['nombre'])) {
                if ($metodo->verificarMetodoPagoExiste($_POST['nombre'], $_POST['moneda'])) {
                    header("Location: ?url=metodopago&status=exists");
                    exit();
                }

                $resultado = $metodo->regDatosMetodoPago($_POST['nombre'], $_POST['moneda']);
                header("Location: ?url=metodopago&status=success");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;

    case 'actualizar':

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_metodo'])) {
            if (!empty($_POST['nombre']) && !empty($_POST['moneda'])) {

                $resultado = $metodo->actDatosMetodoPago($_POST['cod_metodo'], $_POST['nombre'], $_POST['moneda']);
                echo $resultado;
                header("Location: ?url=metodopago&status=updated");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</>";
            }
        }
        break;


    case 'eliminar':
        if (isset($_POST['cod_metodo'])) {
            $resultado = $metodo->elmDatosMetodoPago($_POST['cod_metodo']);
            header("Location: ?url=metodopago&status=deleted");
            exit();
        }
        break;
}


$regMoneda = $metodo->obt_RegistrosMoneda();
$registros = $metodo->obt_RegistrosMetodoPago();
// app/controller/metodopagoController.php
include 'app/view/layout/header.php';
include 'app/view/metodopago/metodopagoView.php';
include 'app/view/layout/footer.php';
