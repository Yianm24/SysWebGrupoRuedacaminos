<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 6) {
    header("Location: ?url=dashboard&status=unauthorized");
    exit(); 
}

use App\Model\Cargo;

$cargo = new Cargo();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($cargo->verificarCargoDuplicado($_POST['nombre'])) {
            header("Location: ?url=cargo&status=exists");
            exit();
        }

        $resultado = $cargo->regDatosCargo(['nombre']);
        header("Location: ?url=cargo&status={$resultado}");
        break;

    case 'modificar':
        if ($cargo->verificarCargoDuplicado($_POST['nombre'], $_POST['cod-cargo'])) {
            header("Location: ?url=cargo&status=exists");
            exit();
        }

        $resultado = $cargo->modDatosCargo(['cod-cargo', 'nombre']);
        header("Location: ?url=cargo&status={$resultado}");
        break;

    case 'eliminar':
        $resultado = $cargo->elmDatosCargo(['cod_cargo']);
        header("Location: ?url=cargo&status={$resultado}");
        break;
}

$registros = $cargo->obt_RegistrosCargo();

include 'app/view/layout/header.php';
include 'app/view/cargo/cargoView.php'; 
include 'app/view/layout/footer.php';
?>