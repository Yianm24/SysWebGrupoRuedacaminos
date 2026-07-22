<?php

namespace App\Controller;

use App\Model\Rol;

$rol = new Rol();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre'])) {
                if ($rol->verificarRolExiste($_POST['nombre'])) {
                    header("Location: ?url=rol&status=exists");
                    exit();
                }
                $resultado = $rol->regDatosRol($_POST['nombre']);
            var_dump($rol);
                header("Location: ?url=rol&status=success");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
            break;
        }

    case 'eliminar':
        if (isset($_POST['cod_rol'])) {

            $resultado = $rol->elmDatosRol($_POST['cod_rol']);
            header("Location: ?url=rol&status=deleted");
            exit();
        }
        break;

    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod-rol'])) {
            if (!empty($_POST['nombre'])) {

                $resultado = $rol->actDatosRol($_POST['cod-rol'], $_POST['nombre']);
                header("Location: ?url=rol&status=updated");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
}

$registros = $rol->obt_RegistrosRol();


include 'app/view/layout/header.php';
include 'app/view/rol/rolView.php'; 
include 'app/view/layout/footer.php';
?>