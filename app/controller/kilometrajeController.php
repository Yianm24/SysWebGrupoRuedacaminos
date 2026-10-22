<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 6) {
    header("Location: ?url=dashboard&status=unauthorized");
    exit(); 
}

use App\Model\Kilometraje;

$kilometraje = new Kilometraje();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($kilometraje->verificarTarifaDuplicada($_POST['kilometraje'])) {
            header("Location: ?url=kilometraje&status=exists");
            exit();
        }
        $resultado = $kilometraje->regDatosKilometraje(['kilometraje', 'precio_kilometraje']);
        header("Location: ?url=kilometraje&status={$resultado}");
        break;

    case 'actualizar':
        if ($kilometraje->verificarTarifaDuplicada($_POST['kilometraje_editar'], $_POST['id_tarifa_editar'])) {
            header("Location: ?url=kilometraje&status=exists");
            exit();
            }
            
        $resultado = $kilometraje->actDatosKilometraje(['id_tarifa_editar', 'kilometraje_editar', 'precio_kilometraje_editar']);
        header("Location: ?url=kilometraje&status={$resultado}");
        break;

    case 'eliminar':
            $resultado = $kilometraje->elmDatosKilometraje(['id_tarifa']);
            header("Location: ?url=kilometraje&status={$resultado}");
            break;
    }

$registros = $kilometraje->obt_RegistrosKilometraje();

include 'app/view/layout/header.php';
include 'app/view/kilometraje/kilometraje.php';
include 'app/view/layout/footer.php';
?>