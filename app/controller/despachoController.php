<?php

namespace App\Controller;

use App\Model\Empleado;
use App\Model\Vehiculo;
use App\Model\Envio;
use App\Model\Despacho;

$envioObj = new Envio();

$datosForaneos = [
    'empleados' => json_decode((new Empleado())->obt_EmpleadosCargoAjax(4),true),
    'vehiculos' => (new Vehiculo())->obt_RegistrosVehiculos(),
    'envios' => $envioObj->obt_EnviosPendientes()
];

$despacho = new Despacho();

$registros = json_encode($despacho->obt_RegistrosDespacho());

$solicitud = $_POST['tipoSolicitud'] ?? '';
switch ($solicitud) {
    case 'registrar':
        
      /*   $datosDespacho = json_decode(json_encode($_POST['datosDespacho']), true);
        $enviosSeleccionados = json_decode(json_encode($_POST['envSeleccionados']), true); 
        $resultado = $despacho->regDatosDespacho($datosDespacho['chofer'],$datosDespacho['vehiculo'],$datosDespacho['fechaSalida'],[$enviosSeleccionados['envSeleccionados']]);
        echo $resultado;
        exit(); */

        $datosDespacho = $_POST['datosDespacho'] ?? [];
        
        $enviosSeleccionados = $_POST['envSeleccionados'] ?? [];
        
        $resultado = $despacho->regDatosDespacho(
            $datosDespacho['chofer'] ?? null,
            $datosDespacho['vehiculo'] ?? null,
            $datosDespacho['fechaSalida'] ?? null,
            $enviosSeleccionados 
        );
        
        echo $resultado;
        exit();
        break;
    case 'consultar-envios-pendientes':

        $registros = json_encode(['envios' => $datosForaneos['envios'], 'choferes' => $datosForaneos['empleados'], 'vehiculos' => $datosForaneos['vehiculos']]);
        echo $registros;
        exit();
    break;
    case 'consultar':
        echo $registros;
        exit();
    break;
}

//header('Content-Type: application/json; charset=utf-8');

//$choferJson = json_encode($datosForaneos['empleado'], JSON_UNESCAPED_UNICODE); 


include 'app/view/layout/header.php';
include 'app/view/despacho/despachoView.php';
include 'app/view/layout/footer.php';

