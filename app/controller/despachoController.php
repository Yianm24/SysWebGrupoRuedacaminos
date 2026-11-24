<?php

namespace App\Controller;

use App\Model\Empleado;
use App\Model\Vehiculo;
use App\Model\Envio;
use App\Model\Despacho;

$envioObj = new Envio();

/* $datosForaneos = [
    'empleados' => json_decode((new Empleado())->obt_EmpleadosCargoAjax(4),true),
    'vehiculos' => (new Vehiculo())->obt_RegistrosVehiculos()
    //'envios' => $envioObj->obt_EnviosPendientes()
]; */

$despacho = new Despacho();

$solicitud = $_POST['tipoSolicitud'] ?? '';
switch ($solicitud) {
    case 'registrar':
        $datosDespacho = json_decode(json_encode($_POST['datos']['datosDespacho']),true) ?? [];
        
        $enviosSeleccionados = json_decode(json_encode($_POST['datos']['enviosSeleccionados']),true) ?? [];
        
        $resultado = $despacho->regDatosDespacho(
            $datosDespacho['chofer'] ?? null,
            $datosDespacho['vehiculo'] ?? null,
            $datosDespacho['fechaSalida'] ?? null,
            $enviosSeleccionados 
        );
        
        echo $resultado;
        exit();
        break;
    case 'consultar':
        $registros = $despacho->obt_RegistrosDespacho();
        echo $registros;
        exit();
    break;
}

include 'app/view/layout/header.php';
include 'app/view/despacho/despachoView.php';
include 'app/view/layout/footer.php';

