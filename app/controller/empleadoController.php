<?php
namespace App\Controller;
use App\Model\Empleado;

$empleado = new Empleado();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if (!empty($_POST['cedula']) && !empty($_POST['nombre'])) {
            if ($empleado->verificarEmpleadoExiste($_POST['cedula'])) {
                header("Location: ?url=empleado&status=exists");
                exit();
            }
            $empleado->regDatosEmpleado($_POST['nombre'], $_POST['apellido'], $_POST['cedula'], $_POST['telefono'], $_POST['telefono_emergencia'], $_POST['cod_cargo']);
            header("Location: ?url=empleado&status=success");
            exit();
        }
        break;

    case 'actualizar':
        if (!empty($_POST['id_empleado_editar']) && !empty($_POST['cedula_editar'])) {
            if ($empleado->verificarEmpleadoDuplicado($_POST['cedula_editar'], $_POST['id_empleado_editar'])) {
                header("Location: ?url=empleado&status=exists");
                exit();
            }
            $empleado->modDatosEmpleado($_POST['id_empleado_editar'], $_POST['nombre_editar'], $_POST['apellido_editar'], $_POST['cedula_editar'], $_POST['telefono_editar'], $_POST['telefono_emergencia_editar'], $_POST['cod_cargo_editar']);
            header("Location: ?url=empleado&status=updated");
            exit();
        }
        break;

    case 'eliminar':
        if (isset($_POST['id_empleado'])) {
            $empleado->elmDatosEmpleado($_POST['id_empleado']);
            header("Location: ?url=empleado&status=deleted");
            exit();
        }
        break;
}

$registros = $empleado->obt_RegistrosEmpleado();
$listaCargos = $empleado->obt_TodosLosCargos();

include 'app/view/layout/header.php';
include 'app/view/empleado/empleadoView.php';
include 'app/view/layout/footer.php';
?>
