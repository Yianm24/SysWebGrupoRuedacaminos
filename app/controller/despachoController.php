<?php

namespace App\Controller;

use App\Model\Envio;
use App\Model\Despacho;

$envioObj = new Envio();

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
            $datosDespacho['horaSalida'] ?? null,
            $enviosSeleccionados 
        );
        
        echo $resultado;
        exit();
    break;
    case 'modificar':
        $datosDespacho = json_decode(json_encode($_POST['datos']['datosDespacho']),true) ?? [];
        
        $enviosSeleccionados = json_decode(json_encode($_POST['datos']['enviosSeleccionados']),true) ?? [];
        
        $resultado = $despacho->modDatosDespacho(
            $datosDespacho['cod_despacho'] ?? null,
            $datosDespacho['chofer'] ?? null,
            $datosDespacho['vehiculo'] ?? null,
            $datosDespacho['fechaSalida'] ?? null,
            $datosDespacho['horaSalida'] ?? null,
            $enviosSeleccionados 
        );
        echo $resultado;
        exit();
    
    break;
    case 'eliminar':
        $resultado = $despacho->elmDatosDespacho([$_POST['datos']['cod_despacho']]);
        echo $resultado;
        exit();

    break;
    case 'consultar':
        $registros = $despacho->obt_RegistrosDespacho($_POST['datos']['codDespacho']);
        echo $registros;
        exit();
    break;
}

include 'app/view/layout/header.php';
include 'app/view/despacho/despachoView.php';
include 'app/view/layout/footer.php';

