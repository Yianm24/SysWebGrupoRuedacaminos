<?php
namespace App\Controller;
use App\Model\Kilometraje;

$kilometraje = new Kilometraje();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if (!empty($_POST['codigo_tipovehiculo']) && !empty($_POST['precio_kilometraje'])) {
            $kilometraje->regDatosKilometraje($_POST['codigo_tipovehiculo'], $_POST['precio_kilometraje']);

            header("Location: ?url=kilometraje&status=success");
        exit();
        }
        break;

    case 'actualizar':
        if (!empty($_POST['id_tarifa_editar']) && !empty($_POST['precio_kilometraje_editar'])) {
            $kilometraje->actDatosKilometraje($_POST['id_tarifa_editar'], $_POST['precio_kilometraje_editar']);
            echo "<script>alert('Actualización de la tarifa realizada exitosamente');</script>";

            header("Location: ?url=kilometraje&status=updated");
            exit();
        }
        break;

    case 'eliminar':
        if (isset($_POST['id_tarifa'])) {
            $kilometraje->elmDatosKilometraje($_POST['id_tarifa']);
            echo "<script>alert('Eliminación del Precio de Kilometraje realizado exitosamente');</script>";

            header("Location: ?url=kilometraje&status=deleted");
            exit();
        }
        break;
}

$registros = $kilometraje->obt_RegistrosKilometraje();

// app/controller/kilometrajeController.php
include 'app/view/layout/header.php';
include 'app/view/kilometraje/kilometraje.php';
include 'app/view/layout/footer.php';
?>