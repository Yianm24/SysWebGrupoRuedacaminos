<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit(); 
}

use App\Model\Pago;

$pago = new Pago();
$solicitud = $_POST['tipoSolicitud'] ?? '';
$rol_usuario = $_SESSION['usuario']['rol'];

if (in_array($solicitud, ['actualizar', 'eliminar']) && $rol_usuario != 6) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado para realizar esta acción.']);
    exit();
}

switch ($solicitud) {
    case 'registrar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        if ($pago->verificarPagoCompletado($datosObt['cod_envio'] ?? '')) {
            echo json_encode(['status' => 'completed', 'message' => 'El pago del envío ya fue completado previamente al 100%.']);
            exit();
        }

        if ($pago->verificarReferenciaDuplicada($datosObt['referencia'] ?? '')) {
            echo json_encode(['status' => 'exists_ref', 'message' => 'Ya existe un pago registrado con la referencia bancaria ingresada.']);
            exit();
        }

        date_default_timezone_set('America/Caracas');
        $fecha = $datosObt['fecha_pago'] ?? date('Y-m-d');
        $hora = date('H:i:s');
        $estatus_calculado = $pago->determinarEstatusPago($datosObt['cod_envio'] ?? '', $datosObt['monto'] ?? '');

        $resultado = $pago->regDatosPago(
            [
                $fecha, 
                $datosObt['monto'] ?? '', 
                $datosObt['monto_ingresado'] ?? '', 
                $datosObt['referencia'] ?? '', 
                $datosObt['cod_envio'] ?? '', 
                $datosObt['metodos'] ?? '', 
                $datosObt['cuentas'] ?? ''
            ],
            $hora,
            $estatus_calculado
        );

        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'El pago ha sido registrado correctamente.']);
        }
        exit();
        break;

    case 'consultar':
        $registros = $pago->obt_RegistrosPago();
        echo json_encode($registros);
        exit();
        break;

    case 'actualizar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        if ($pago->verificarReferenciaDuplicada($datosObt['referencia'] ?? '', $datosObt['cod_pago'] ?? '')) {
            echo json_encode(['status' => 'exists_ref', 'message' => 'Ya existe otro pago registrado con la referencia bancaria ingresada.']);
            exit();
        }

        date_default_timezone_set('America/Caracas');
        $hora = date('H:i:s');
        $estatus_calculado = $pago->determinarEstatusPago($datosObt['cod_envio'] ?? '', $datosObt['monto'] ?? '', $datosObt['cod_pago'] ?? '');
        
        $resultado = $pago->actDatosPago(
            [
                $datosObt['cod_pago'] ?? '', 
                $datosObt['fecha_pago'] ?? '', 
                $datosObt['monto'] ?? '', 
                $datosObt['monto_ingresado'] ?? '', 
                $datosObt['referencia'] ?? '', 
                $datosObt['cod_detallepago'] ?? '', 
                $datosObt['metodos'] ?? '', 
                $datosObt['cuentas'] ?? ''
            ], 
            $hora, 
            $estatus_calculado
        );

        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'El pago ha sido modificado correctamente.']);
        }
        exit();
        break;

    case 'eliminar':
        $dataAjax = json_encode($_POST['datos'] ?? []);
        $datosObt = json_decode($dataAjax, true);

        $resultado = $pago->elmDatosPago([$datosObt['cod_pago'] ?? '']);
        if (is_string($resultado) && is_array(json_decode($resultado, true))) {
            echo $resultado;
        } else {
            echo json_encode(['status' => $resultado, 'message' => 'El pago ha sido anulado correctamente.']);
        }
        exit();
        break;
}

if (empty($solicitud)) {
    $registros = $pago->obt_RegistrosPago();
    $tasasJSON = json_encode($pago->obt_TasasDelDia());
    $bancos = $pago->obt_BancosActivos();
    $metodosPago = $pago->obt_MetodosPagoActivos();

    include 'app/view/layout/header.php';
    include 'app/view/pago/pagoView.php';
    include 'app/view/layout/footer.php';
}
?>