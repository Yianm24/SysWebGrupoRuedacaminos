<?php

namespace App\Controller;

use App\Model\Empleado;

$empleado = new Empleado();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre'])) {
                if ($empleado->verificarEmpleadoExiste($_POST['nombre'])) {
                    header("Location: ?url=empleado&status=exists");
                    exit();
                }
                $resultado = $empleado->regDatosEmpleado($_POST['nombre']);
            var_dump($empleado);
                header("Location: ?url=empleado&status=success");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
            break;
        }

    case 'eliminar':
        if (isset($_POST['cod_empleado'])) {
            $resultado = $empleado->elmDatosEmpleado($_POST['cod_empleado']);
            header("Location: ?url=empleado&status=deleted");
            exit();
        }
        break;

    case 'modificar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod-empleado'])) {
            if (!empty($_POST['nombre'])) {

                $resultado = $empleado->modDatosEmpleado($_POST['cod-empleado'], $_POST['nombre']);
                header("Location: ?url=empleado&status=updated");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
}

$registros = $empleado->obt_RegistrosEmpleado();

    include 'app/view/layout/header.php';
    include 'app/view/empleado/empleadoView.php';
    include 'app/view/layout/footer.php';
?> 
