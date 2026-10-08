<?php

namespace App\Controller;

use App\Model\Empleado;
use App\Model\Vehiculo;
use App\Model\Envio;
use App\Model\Despacho;

$datosForaneos = [
    'empleado' => (new Empleado())->obt_EmpleadosCargo(4),
    'vehiculo' => (new Vehiculo())->obt_RegistrosVehiculos(),
    'envio' => (new Envio())->obt_DestinatariosEnvio()
];

$despacho = new Despacho();
$solicitud = $_POST['tipoSolicitud'] ?? '';
switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $resultado = $despacho->regDatosDespacho($_POST['vehiculo_asignado'],$_POST['fecha_establecida']);
                header("Location: ?url=despacho&status=success");
                echo $resultado;
                exit();
        }
        break;
}

include 'app/view/layout/header.php';
include 'app/view/despacho/despachoView.php';
include 'app/view/layout/footer.php';
