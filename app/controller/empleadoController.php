<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 6) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit(); 
}

use App\Model\Empleado;

$empleado = new Empleado();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        if ($empleado->verificarEmpleadoDuplicado($datosObt['cedula'] ?? '')) {
            echo json_encode(['status' => 'exists', 'message' => 'La cédula ingresada ya está registrada.']);
            exit();
        }

        $resultado = $empleado->regDatosEmpleado([$datosObt['cedula'] ?? '', $datosObt['nombre'] ?? '', $datosObt['apellido'] ?? '', $datosObt['telefono'] ?? '', $datosObt['cod_cargo'] ?? ''], $datosObt['telefono_emergencia'] ?? '');
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'El empleado ha sido registrado correctamente.']);
        }
        exit();
        break;

    case 'consultar':
        $registros = $empleado->obt_RegistrosEmpleado();
        echo json_encode($registros);
        exit();
        break;

    case 'actualizar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        if ($empleado->verificarEmpleadoDuplicado($datosObt['cedula'] ?? '', $datosObt['cod_empleado'] ?? '')) {
            echo json_encode(['status' => 'exists', 'message' => 'La cédula ya pertenece a otro empleado.']);
            exit();
        }

        $resultado = $empleado->modDatosEmpleado([$datosObt['cod_empleado'] ?? '', $datosObt['cedula'] ?? '', $datosObt['nombre'] ?? '', $datosObt['apellido'] ?? '', $datosObt['telefono'] ?? '', $datosObt['cod_cargo'] ?? ''], $datosObt['telefono_emergencia'] ?? '');
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'El empleado ha sido modificado correctamente.']);
        }
        exit();
        break;

    case 'eliminar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        $resultado = $empleado->elmDatosEmpleado([$datosObt['cod_empleado'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'El empleado ha sido eliminado correctamente.']);
        }
        exit();
        break;
    }

if (empty($solicitud)) {
    $listaCargos = $empleado->obt_TodosLosCargos();
    include 'app/view/layout/header.php';
    include 'app/view/empleado/empleadoView.php';
    include 'app/view/layout/footer.php';
}
?>
