<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$solicitud = $_POST['tipoSolicitud'] ?? '';

if (!isset($_SESSION['usuario'])) {
    if (!empty($solicitud)) {
        echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
        exit();
    }
    header('Location: index.php');
    exit();
}

use App\Model\CambioMoneda;

$cambio = new CambioMoneda();
$rol_usuario = $_SESSION['usuario']['rol'] ?? 0;

if (in_array($solicitud, ['actualizar', 'eliminar'], true) && $rol_usuario != 6) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado para realizar esta acción.']);
    exit();
}

date_default_timezone_set('America/Caracas');

switch ($solicitud) {
    case 'registrar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);
        echo $cambio->regDatosCambio([$datosObt['tasa'] ?? '', $datosObt['moneda'] ?? '']);
        exit();

    case 'consultar':
        echo $cambio->obt_RegistrosCambiosServerSide();
        exit();

    case 'actualizar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);
        echo $cambio->actDatosCambio([
            $datosObt['cod_cambio'] ?? '',
            $datosObt['tasa'] ?? '',
            $datosObt['moneda'] ?? '',
            $datosObt['estado'] ?? 1
        ]);
        exit();

    case 'eliminar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);
        echo $cambio->elmDatosCambio([$datosObt['cod_cambio'] ?? '']);
        exit();
}

$listaMonedas = $cambio->obt_TodasLasMonedas();
include 'app/view/layout/header.php';
include 'app/view/cambiomoneda/cambiomonedaView.php';
include 'app/view/layout/footer.php';