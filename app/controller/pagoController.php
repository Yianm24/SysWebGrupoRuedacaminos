<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'])) {
    header("Location: ?url=login");
    exit(); 
}

use App\Model\Pago;

$pago = new Pago();
$solicitud = $_POST['tipoSolicitud'] ?? '';
$rol_usuario = $_SESSION['usuario']['rol'];

if (in_array($solicitud, ['actualizar', 'eliminar']) && $rol_usuario != 6) {
    header("Location: ?url=pago&status=unauthorized");
    exit();
}

switch ($solicitud) {
    case 'registrar':
        if ($pago->verificarPagoCompletado($_POST['cod_envio'])) {
            header("Location: ?url=pago&status=completed");
            exit();
        }

        if ($pago->verificarReferenciaDuplicada($_POST['referencia'])) {
        header("Location: ?url=pago&status=exists_ref");
        exit();
        }

        date_default_timezone_set('America/Caracas');
        $fecha = $_POST['fecha_pago'] ?? date('Y-m-d');
        if (empty($_POST['fecha_pago'])) {
            $_POST['fecha_pago'] = date('Y-m-d');
        }
        $hora = date('H:i:s');
        $estatus_calculado = $pago->determinarEstatusPago($_POST['cod_envio'], $_POST['monto']);

            $resultado = $pago->regDatosPago(
                ['fecha_pago', 'monto', 'monto_ingresado', 'referencia', 'cod_envio', 'metodos', 'cuentas'],
                $hora,
                $estatus_calculado
            );

            header("Location: ?url=pago&status={$resultado}");
            exit();

    case 'actualizar':
        if ($pago->verificarReferenciaDuplicada($_POST['referencia'], $_POST['cod_pago'])) {
            header("Location: ?url=pago&status=exists_ref");
            exit();
        }

        date_default_timezone_set('America/Caracas');
        $hora = $_POST['hora'] ?? date('H:i:s');
        $estatus_calculado = $pago->determinarEstatusPago($_POST['cod_envio'], $_POST['monto'], $_POST['cod_pago']);
        
        $resultado = $pago->actDatosPago(
            ['cod_pago', 'fecha_pago', 'monto', 'monto_ingresado', 'referencia', 'cod_detallepago', 'metodos', 'cuentas'], 
            $hora, 
            $estatus_calculado
        );
        header("Location: ?url=pago&status={$resultado}");
        exit();

    case 'eliminar':
        if ($pago->verificarPagoPendiente($_POST['cod_pago'])) {
            header("Location: ?url=pago&status=pending_error");
            exit();
            }

            $resultado = $pago->elmDatosPago(['cod_pago']);
            header("Location: ?url=pago&status={$resultado}");
            exit();
    }

$registros = $pago->obt_RegistrosPago();
$tasasJSON = json_encode($pago->obt_TasasDelDia());
$bancos = $pago->obt_BancosActivos();
$metodosPago = $pago->obt_MetodosPagoActivos();

include 'app/view/layout/header.php';
include 'app/view/pago/pagoView.php';
include 'app/view/layout/footer.php';
?>
