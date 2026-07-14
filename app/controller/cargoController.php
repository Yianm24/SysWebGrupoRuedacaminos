<?php

namespace App\Controller;

use App\Model\Cargo;

$cargo = new Cargo();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre'])) {
                if ($cargo->verificarCargoExiste($_POST['nombre'])) {
                    header("Location: ?url=cargo&status=exists");
                    exit();
                }
                $resultado = $cargo->regDatosCargo($_POST['nombre']);
            var_dump($cargo);
                header("Location: ?url=cargo&status=success");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
            break;
        }

    case 'eliminar':
        if (isset($_POST['cod_cargo'])) {
            $resultado = $cargo->elmDatosCargo($_POST['cod_cargo']);
            header("Location: ?url=cargo&status=deleted");
            exit();
        }
        break;

    case 'modificar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod-moneda'])) {
            if (!empty($_POST['nombre']) && !empty($_POST['abreviatura'])) {

                $resultado = $moneda->modDatosMoneda($_POST['cod-moneda'], $_POST['nombre'], $_POST['abreviatura']);

                //echo "<script>alert('Actualización de datos de la moneda realizada exitosamente');</script>";
                //echo $resultado;
                header("Location: ?url=moneda&status=updated");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
}

$registros = $cargo->obt_RegistrosCargo();


include 'app/view/layout/header.php';
include 'app/view/cargo/cargoView.php'; 
include 'app/view/layout/footer.php';
?>