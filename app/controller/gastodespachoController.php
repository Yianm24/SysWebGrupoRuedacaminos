<?php
namespace App\Controller;

use App\Model\GastosDespacho;

$gastoDespacho = new GastosDespacho();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar_gasto':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_despacho']) && !empty($_POST['descripcion']) && !empty($_POST['monto'])) {
                
                $gastoDespacho->setCodDespacho($_POST['cod_despacho']);
                $gastoDespacho->setDescripcion($_POST['descripcion']);
                $gastoDespacho->setMonto($_POST['monto']);

                $resultado = $gastoDespacho->registrarGastoTransaccional();

                if ($resultado) {
                    header("Location: ?url=despacho&status=gasto_success");
                } else {
                    header("Location: ?url=despacho&status=gasto_error");
                }
                exit();
            } else {
                echo "<script>alert('Faltan datos obligatorios para registrar el gasto');</script>";
            }
        }
        break;
}

// Estructura de vistas basada en tus componentes
include 'app/view/layout/header.php';
include 'app/view/gastodespacho/gastodespachoView.php'; 
include 'app/view/layout/footer.php';
?>