<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$solicitud = $_POST['tipoSolicitud'] ?? '';

if (!isset($_SESSION['usuario']) || ($_SESSION['usuario']['rol'] ?? 0) != 6) {
    if (!empty($solicitud)) {
        echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
        exit();
    }
    header('Location: index.php');
    exit();
}

use App\Model\Cargo;

$cargo = new Cargo();

switch ($solicitud) {
    case 'registrar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);
        echo $cargo->regDatosCargo([$datosObt['nombre'] ?? '']);
        exit();

    case 'consultar':
        echo json_encode($cargo->obt_RegistrosCargo());
        exit();

    case 'modificar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);
        echo $cargo->modDatosCargo([$datosObt['cod_cargo'] ?? '', $datosObt['nombre'] ?? '']);
        exit();

    case 'eliminar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);
        echo $cargo->elmDatosCargo([$datosObt['cod_cargo'] ?? '']);
        exit();
}

$registros = $cargo->obt_RegistrosCargo();
include 'app/view/layout/header.php';
include 'app/view/cargo/cargoView.php';
include 'app/view/layout/footer.php';