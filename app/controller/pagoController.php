<?php
namespace App\Controller;
use App\Model\Pago;

$pago = new Pago();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if (!empty($_POST['cod_envio']) && !empty($_POST['monto'])) {
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
            $hora = date('H:i:s');

            $pago->regDatosPago(
                $fecha,
                $hora,
                $_POST['monto'],
                $_POST['referencia'],
                $_POST['estatus_pago'],
                $_POST['cod_envio'],
                $_POST['metodos'],
                $_POST['Chofer']
            );

            header("Location: ?url=pago&status=success");
            exit();
        }
        break;

    case 'actualizar':
        if (!empty($_POST['cod_pago'])) {

            if ($pago->verificarReferenciaDuplicada($_POST['referencia'], $_POST['cod_pago'])) {
                header("Location: ?url=pago&status=exists_ref");
                exit();
            }

            $pago->actDatosPago(
                $_POST['cod_pago'],
                $_POST['fecha_pago'],
                $_POST['hora'] ?? date('H:i:s'),
                $_POST['monto'],
                $_POST['referencia'],
                $_POST['estatus_pago'],
                $_POST['cod_detallepago'],
                $_POST['metodos'],
                $_POST['Chofer']
            );

            header("Location: ?url=pago&status=updated");
            exit();
        }
        break;

    case 'eliminar':
        if (isset($_POST['cod_pago'])) {
            if ($pago->verificarPagoPendiente($_POST['cod_pago'])) {
                header("Location: ?url=pago&status=pending_error");
                exit();
            }

            $pago->elmDatosPago($_POST['cod_pago']);
            header("Location: ?url=pago&status=deleted");
            exit();
        }
        break;
}

$registros = $pago->obt_RegistrosPago();
$tasasJSON = json_encode($pago->obt_TasasDelDia());

include 'app/view/layout/header.php';
include 'app/view/pago/pagoView.php';
include 'app/view/layout/footer.php';
?>
