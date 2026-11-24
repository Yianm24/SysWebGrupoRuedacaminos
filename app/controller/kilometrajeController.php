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

use App\Model\Kilometraje;

$kilometraje = new Kilometraje();

switch ($solicitud) {
    case 'registrar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);
        echo $kilometraje->regDatosKilometraje([
            $datosObt['kilometraje'] ?? '',
            $datosObt['precio_kilometraje'] ?? ''
        ]);
        exit();

    case 'consultar':
        echo json_encode($kilometraje->obt_RegistrosKilometraje());
        exit();

    case 'actualizar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);
        echo $kilometraje->actDatosKilometraje([
            $datosObt['cod_preciokilometraje'] ?? '',
            $datosObt['kilometraje'] ?? '',
            $datosObt['precio_kilometraje'] ?? ''
        ]);
        exit();

    case 'eliminar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);
        echo $kilometraje->elmDatosKilometraje([$datosObt['cod_preciokilometraje'] ?? '']);
        exit();
}

$registros = $kilometraje->obt_RegistrosKilometraje();
include 'app/view/layout/header.php';
include 'app/view/kilometraje/kilometraje.php';
include 'app/view/layout/footer.php';