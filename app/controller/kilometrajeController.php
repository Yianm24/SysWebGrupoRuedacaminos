<?php
namespace App\Controller;
use App\Model\Kilometraje;

$kilometraje = new Kilometraje();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if (!empty($_POST['kilometraje']) && !empty($_POST['precio_kilometraje'])) {
            
            // Verificar si ya existe una tarifa para el mismo kilometraje
            if ($kilometraje->verificarTarifaExiste($_POST['kilometraje'])) {
                header("Location: ?url=kilometraje&status=exists");
                exit();
            }

            $kilometraje->regDatosKilometraje($_POST['kilometraje'], $_POST['precio_kilometraje']);
            header("Location: ?url=kilometraje&status=success");
            exit();
        }
        break;

    case 'actualizar':
        if (!empty($_POST['id_tarifa_editar']) && !empty($_POST['kilometraje_editar']) && !empty($_POST['precio_kilometraje_editar'])) {
            $kilometraje->actDatosKilometraje($_POST['id_tarifa_editar'], $_POST['kilometraje_editar'], $_POST['precio_kilometraje_editar']);
            header("Location: ?url=kilometraje&status=updated");
            exit();
        }
        break;

    case 'eliminar':
        if (isset($_POST['id_tarifa'])) {
            $kilometraje->elmDatosKilometraje($_POST['id_tarifa']);
            header("Location: ?url=kilometraje&status=deleted");
            exit();
        }
        break;
}

$registros = $kilometraje->obt_RegistrosKilometraje();

include 'app/view/layout/header.php';
include 'app/view/kilometraje/kilometraje.php';
include 'app/view/layout/footer.php';
?>