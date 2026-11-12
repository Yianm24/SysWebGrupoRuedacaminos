<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit(); 
}

use App\Model\CambioMoneda;

$cambio = new CambioMoneda();
$solicitud = $_POST['tipoSolicitud'] ?? '';
$rol_usuario = $_SESSION['usuario']['rol'];

//Permiso para actualizar y eliminar exclusivo para Administradores
if (in_array($solicitud, ['actualizar', 'eliminar']) && $rol_usuario != 6) {
    echo json_encode(['status' => 'error', 'message' => 'No tiene permisos para realizar esta acción.']);
    exit();
}

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
            echo json_encode(['status' => $resultado, 'message' => 'Registro de tasa de cambio exitoso.']);
        }
        exit();
        break;

    case 'consultar':
        $registros = $cambio->obt_RegistrosCambios();
        echo json_encode($registros);
        exit();
        break;

    case 'actualizar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);
        
        $fecha_actual = date('Y-m-d');
        if ($cambio->verificarTasaDuplicada($datosObt['moneda'] ?? '', $fecha_actual, $datosObt['cod_cambio'] ?? '')) {
            echo json_encode(['status' => 'exists', 'message' => 'Esta moneda ya posee otra tasa registrada el día de hoy.']);
            exit();
        } 
        $resultado = $cambio->actDatosCambio([$datosObt['cod_cambio'] ?? '', $datosObt['tasa'] ?? '', $datosObt['moneda'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'Modificación realizada exitosamente.']);
        }
        exit();
        break;
        
    case 'eliminar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        $resultado = $cambio->elmDatosCambio([$datosObt['cod_cambio'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'Eliminación realizada exitosamente.']);
        }
        exit();
        break;
}

if (empty($solicitud)) {
    $listaMonedas = $cambio->obt_TodasLasMonedas();
    include 'app/view/layout/header.php';
    include 'app/view/cambiomoneda/cambiomonedaView.php';
    include 'app/view/layout/footer.php';
}
?>