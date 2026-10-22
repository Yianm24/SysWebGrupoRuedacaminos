<?php
namespace App\Controller;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ?url=login");
    exit(); 
}

use App\Model\CambioMoneda;

$cambio = new CambioMoneda();
$solicitud = $_POST['tipoSolicitud'] ?? '';
$rol_usuario = $_SESSION['usuario']['rol'];

//Permiso para actualizar y eliminar exclusivo para Administradores
if (in_array($solicitud, ['actualizar', 'eliminar']) && $rol_usuario != 6) {
    header("Location: ?url=cambiomoneda&status=unauthorized");
    exit();
}

switch ($solicitud) {
    case 'registrar':
        $fecha_actual = date('Y-m-d');
        if ($cambio->verificarTasaDuplicada($_POST['moneda'], $fecha_actual)) {
            header("Location: ?url=cambiomoneda&status=exists");
            exit();
        }

        $resultado = $cambio->regDatosCambio(['tasa', 'moneda']);
        header("Location: ?url=cambiomoneda&status={$resultado}");
        exit();

    case 'actualizar':
        $fecha_actual = date('Y-m-d');
        if ($cambio->verificarTasaDuplicada($_POST['moneda_editar'], $fecha_actual, $_POST['id_cambio_editar'])) {
            header("Location: ?url=cambiomoneda&status=exists");
            exit();
            }
            
        $resultado = $cambio->actDatosCambio(['id_cambio_editar', 'tasa_editar', 'moneda_editar']);
        header("Location: ?url=cambiomoneda&status={$resultado}");
        exit();
        
    case 'eliminar':
        $resultado = $cambio->elmDatosCambio(['id_cambio']);
        header("Location: ?url=cambiomoneda&status={$resultado}");
        exit();
}

$listaMonedas = $cambio->obt_TodasLasMonedas();
$registros = $cambio->obt_RegistrosCambios();

include 'app/view/layout/header.php';
include 'app/view/cambiomoneda/cambiomonedaView.php';
include 'app/view/layout/footer.php';
?>