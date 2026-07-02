<?php
namespace App\Controller;
use App\Model\CambioMoneda;

$cambio = new CambioMoneda();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if (!empty($_POST['tasa']) && !empty($_POST['moneda'])) {
            $fecha_actual = date('Y-m-d');
            
            if ($cambio->verificarTasaDiaExiste($_POST['moneda'], $fecha_actual)) {
                header("Location: ?url=cambiomoneda&status=exists");
                exit();
            }

            $cambio->regDatosCambio($_POST['tasa'], $_POST['moneda']);
            header("Location: ?url=cambiomoneda&status=success");
            exit();
        }
        break;

    case 'actualizar':
        if (!empty($_POST['id_cambio_editar']) && !empty($_POST['tasa_editar'])) {
            $cambio->actDatosCambio($_POST['id_cambio_editar'], $_POST['tasa_editar']);
            header("Location: ?url=cambiomoneda&status=updated");
            exit();
        }
        break;

    case 'eliminar':
        if (isset($_POST['id_cambio'])) {
            $cambio->elmDatosCambio($_POST['id_cambio']);
            header("Location: ?url=cambiomoneda&status=deleted");
            exit();
        }
        break;
}

$registros = $cambio->obt_RegistrosCambios();

include 'app/view/layout/header.php';
include 'app/view/cambiomoneda/cambiomonedaView.php';
include 'app/view/layout/footer.php';
?>