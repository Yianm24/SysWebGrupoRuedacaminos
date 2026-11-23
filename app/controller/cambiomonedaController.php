<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$esPeticionAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
$solicitud = $_POST['tipoSolicitud'] ?? '';

if (!isset($_SESSION['usuario'])) {
    if ($esPeticionAjax || !empty($solicitud)) {
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
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        $fecha_actual = date('Y-m-d');
        if ($cambio->verificarTasaDuplicada($datosObt['moneda'] ?? '', $fecha_actual)) {
            echo json_encode(['status' => 'exists', 'message' => 'Esta moneda ya posee una tasa registrada el día de hoy.']);
            exit();
        }

        $resultado = $cambio->regDatosCambio([$datosObt['tasa'] ?? '', $datosObt['moneda'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'La tasa de cambio ha sido registrada correctamente.']);
        }
        exit();

    case 'consultar':
        $registros = $cambio->obt_RegistrosCambiosServerSide();
        echo $registros;
        exit();

    case 'actualizar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        $codCambio = $datosObt['cod_cambio'] ?? '';
        $moneda = $datosObt['moneda'] ?? '';
        $tasa = $datosObt['tasa'] ?? '';
        $fechaRegistro = $cambio->obtenerFechaPorId($codCambio);

        if (!empty($fechaRegistro) && $cambio->verificarTasaDuplicada($moneda, $fechaRegistro, $codCambio)) {
            echo json_encode(['status' => 'exists', 'message' => 'Esta moneda ya posee otra tasa registrada en esa fecha.']);
            exit();
        }

        $resultado = $cambio->actDatosCambio([$codCambio, $tasa, $moneda]);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'La tasa de cambio ha sido modificada correctamente.']);
        }
        exit();

    case 'eliminar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        $resultado = $cambio->elmDatosCambio([$datosObt['cod_cambio'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'La tasa de cambio ha sido eliminada correctamente.']);
        }
        exit();
}

if (empty($solicitud)) {
    $listaMonedas = $cambio->obt_TodasLasMonedas();
    include 'app/view/layout/header.php';
    include 'app/view/cambiomoneda/cambiomonedaView.php';
    include 'app/view/layout/footer.php';
}