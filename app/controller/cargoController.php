<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 6) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit(); 
}

use App\Model\Cargo;

$cargo = new Cargo();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        if ($cargo->verificarCargoDuplicado($datosObt['nombre']?? '')) {
            echo json_encode(['status' => 'exists', 'message' => 'El cargo ya existe.']);
            exit();
        }

        $resultado = $cargo->regDatosCargo([$datosObt['nombre'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
        echo json_encode(['status' => $resultado, 'message' => 'El cargo ha sido registrado correctamente.']);
        }
        exit();
        break;

    case 'consultar':
        $registros = $cargo->obt_RegistrosCargo();
        echo json_encode($registros);
        exit();
        break;

    case 'modificar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        if ($cargo->verificarCargoDuplicado($datosObt['nombre'] ?? '', $datosObt['cod_cargo'] ?? '')) {
            echo json_encode(['status' => 'exists', 'message' => 'El cargo ya existe.']);
            exit();
        }

        $resultado = $cargo->modDatosCargo([$datosObt['cod_cargo'] ?? '', $datosObt['nombre'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
        echo json_encode(['status' => $resultado, 'message' => 'El cargo ha sido modificado correctamente.']);
        }
        exit();
        break;

    case 'eliminar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        $resultado = $cargo->elmDatosCargo([$datosObt['cod_cargo'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
        echo json_encode(['status' => $resultado, 'message' => 'El cargo ha sido eliminado correctamente.']);
        }
        exit();
        break;
}

if (empty($solicitud)) {
    $registros = $cargo->obt_RegistrosCargo();
    include 'app/view/layout/header.php';
    include 'app/view/cargo/cargoView.php'; 
    include 'app/view/layout/footer.php';
}
?>