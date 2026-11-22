<?php

namespace App\Controller;

use App\Model\Vehiculo;
use App\Model\Modelo;

$vehiculo = new Vehiculo();
$modelo = new Modelo();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
       
        /* if ($vehiculo->verificarVehiculoDuplicado($_POST['placa'], null)) {
            header("Location: ?url=vehiculo&status=exists");
            exit();
        } */
        $datosAjax = json_decode(json_encode($_POST['datos']),true);
        $resultado = $vehiculo->regDatosVehiculo([$datosAjax['placa'],$datosAjax['color'],$datosAjax['anio'],$datosAjax['anchura'],$datosAjax['altura'],$datosAjax['peso_max'],$datosAjax['modelo']]);
        echo $resultado;
        exit();
                
    break;
    case 'actualizar':
        /* 
        if ($vehiculo->verificarVehiculoDuplicado($_POST['placa'], $_POST['cod_vehiculo'])) {
            header("Location: ?url=vehiculo&status=exists");
            exit();
        } */
        $datosAjax = json_decode(json_encode($_POST['datos']),true);
        $resultado = $vehiculo->regDatosVehiculo([$datosAjax['cod_vehiculo'],$datosAjax['placa'],$datosAjax['color'],$datosAjax['anio'],$datosAjax['anchura'],$datosAjax['altura'],$datosAjax['peso_max'],$datosAjax['modelo']]);
        echo $resultado;
        exit();
                
    break;
    case 'eliminar':
        
            $resultado = $vehiculo->elmDatosVehiculo([$_POST['datos']['cod_vehiculo']]);
            echo $resultado;
            exit();
          
    break;
    case 'consultar':
        
            $resultado = $vehiculo->obt_RegistrosVehiculos();
            echo $resultado;
            exit();
          
    break;
}

include 'app/view/layout/header.php';
include 'app/view/vehiculo/vehiculoView.php';
include 'app/view/layout/footer.php';
