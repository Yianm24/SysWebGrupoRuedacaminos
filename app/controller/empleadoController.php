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

use App\Model\Empleado;

$empleado = new Empleado();

switch ($solicitud) {
    case 'registrar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);

        if ($empleado->verificarEmpleadoDuplicado($datosObt['cedula'] ?? '')) {
            echo json_encode(['status' => 'exists', 'message' => 'La cédula ingresada ya está registrada.']);
            exit();
        }

        echo $empleado->regDatosEmpleado(
            [
                $datosObt['cedula'] ?? '',
                $datosObt['nombre'] ?? '',
                $datosObt['apellido'] ?? '',
                $datosObt['telefono'] ?? '',
                $datosObt['cod_cargo'] ?? ''
            ],
            $datosObt['telefono_emergencia'] ?? ''
        );
        exit();

    case 'consultar':
        echo json_encode($empleado->obt_RegistrosEmpleado());
        exit();

    case 'actualizar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);

        if ($empleado->verificarEmpleadoDuplicado($datosObt['cedula'] ?? '', $datosObt['cod_empleado'] ?? '')) {
            echo json_encode(['status' => 'exists', 'message' => 'La cédula ya pertenece a otro empleado.']);
            exit();
        }

        echo $empleado->modDatosEmpleado(
            [
                $datosObt['cod_empleado'] ?? '',
                $datosObt['cedula'] ?? '',
                $datosObt['nombre'] ?? '',
                $datosObt['apellido'] ?? '',
                $datosObt['telefono'] ?? '',
                $datosObt['cod_cargo'] ?? ''
            ],
            $datosObt['telefono_emergencia'] ?? ''
        );
        exit();

    case 'eliminar':
        $datosObt = json_decode(json_encode($_POST['datos'] ?? []), true);

        echo $empleado->elmDatosEmpleado([$datosObt['cod_empleado'] ?? '']);
        exit();
}

$listaCargos = $empleado->obt_TodosLosCargos();
include 'app/view/layout/header.php';
include 'app/view/empleado/empleadoView.php';
include 'app/view/layout/footer.php';
