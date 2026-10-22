<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 6) {
    header("Location: ?url=dashboard&status=unauthorized");
    exit(); 
}

use App\Model\Empleado;

$empleado = new Empleado();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($empleado->verificarEmpleadoDuplicado($_POST['cedula'])) {
            header("Location: ?url=empleado&status=exists");
            exit();
        }

        $resultado = $empleado->regDatosEmpleado(['cedula', 'nombre', 'apellido', 'telefono', 'cod_cargo']);
        header("Location: ?url=empleado&status={$resultado}");
        break;

    case 'actualizar':
        if ($empleado->verificarEmpleadoDuplicado($_POST['cedula_editar'], $_POST['id_empleado_editar'])) {
            header("Location: ?url=empleado&status=exists");
            exit();
        }

        $resultado = $empleado->modDatosEmpleado(['id_empleado_editar', 'cedula_editar', 'nombre_editar', 'apellido_editar', 'telefono_editar', 'cod_cargo_editar']);
        header("Location: ?url=empleado&status={$resultado}");
        break;

    case 'eliminar':
        $resultado = $empleado->elmDatosEmpleado(['id_empleado']);
        header("Location: ?url=empleado&status={$resultado}");
        break;
    }

$registros = $empleado->obt_RegistrosEmpleado();
$listaCargos = $empleado->obt_TodosLosCargos();

include 'app/view/layout/header.php';
include 'app/view/empleado/empleadoView.php';
include 'app/view/layout/footer.php';
?>
