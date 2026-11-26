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

use App\Model\Pago;

$pago = new Pago();
$rol_usuario = (int)($_SESSION['usuario']['rol'] ?? 0);

if (in_array($solicitud, ['actualizar', 'eliminar', 'reembolsar'], true) && $rol_usuario !== 6) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado para realizar esta acción.']);
    exit();
}

date_default_timezone_set('America/Caracas');

$datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);
if (!is_array($datosObt)) {
    $datosObt = [];
}

switch ($solicitud) {
    case 'registrar':
        echo $pago->regDatosPago($datosObt, date('H:i:s'));
        exit();

    case 'reembolsar':
        echo $pago->regReembolsoPago($datosObt, date('H:i:s'));
        exit();

    case 'consultar':
        echo $pago->obt_RegistrosPagos();
        exit();

    case 'consultar_historial':
        $codEnvio = $datosObt['cod_envio'] ?? ($_POST['cod_envio'] ?? 0);
        echo json_encode($pago->obt_HistorialEnvio($codEnvio));
        exit();

    case 'actualizar':
        echo $pago->actDatosPago($datosObt, $datosObt['hora_original'] ?? null);
        exit();

    case 'eliminar':
        echo $pago->elmDatosPago([$datosObt['cod_pago'] ?? '']);
        exit();
}

$tasasJSON = json_encode($pago->obt_TasasDelDia());
$bancos = $pago->obt_BancosActivos();
$metodosPago = $pago->obt_MetodosPagoActivos();

include 'app/view/layout/header.php';
include 'app/view/pago/pagoView.php';
include 'app/view/layout/footer.php';
