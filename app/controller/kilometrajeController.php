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
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        if ($kilometraje->verificarTarifaDuplicada($datosObt['kilometraje'] ?? '')) {
            echo json_encode(['status' => 'exists', 'message' => 'Ya existe una tarifa registrada para este kilometraje.']);
            exit();
        }
        $resultado = $kilometraje->regDatosKilometraje([$datosObt['kilometraje'] ?? '', $datosObt['precio_kilometraje'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'La tarifa ha sido registrada correctamente.']);
        }
        exit();
        break;
    
    case 'consultar':
        $registros = $kilometraje->obt_RegistrosKilometraje();
        echo json_encode($registros);
        exit();
        break;

    case 'actualizar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);
        
        if ($kilometraje->verificarTarifaDuplicada($datosObt['kilometraje'] ?? '', $datosObt['cod_preciokilometraje'] ?? '')) {
            echo json_encode(['status' => 'exists', 'message' => 'Ya existe una tarifa registrada para este kilometraje.']);
            exit();
        } 
        $resultado = $kilometraje->actDatosKilometraje([$datosObt['cod_preciokilometraje'] ?? '', $datosObt['kilometraje'] ?? '', $datosObt['precio_kilometraje'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'La tarifa ha sido modificada correctamente.']);
        }
        exit();
        break;

    case 'eliminar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        $resultado = $kilometraje->elmDatosKilometraje([$datosObt['cod_preciokilometraje'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'La tarifa ha sido eliminada correctamente.']);
        }
        exit();
        break;
}

if (empty($solicitud)) {
    $registros = $kilometraje->obt_RegistrosKilometraje();
    include 'app/view/layout/header.php';
    include 'app/view/kilometraje/kilometraje.php';
    include 'app/view/layout/footer.php';
}
?>