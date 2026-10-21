<?php

namespace App\Controller;

use App\Model\Vehiculo;
use App\Model\Modelo;

$vehiculo = new Vehiculo();
$modelo = new Modelo();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
       
        if ($vehiculo->verificarVehiculoDuplicado($_POST['placa'], null)) {
            header("Location: ?url=vehiculo&status=exists");
            exit();
        }

        $resultado = $vehiculo->regDatosVehiculo(['placa','color','anio','anchura','altura','peso_max','modelo']);
        header("Location: ?url=vehiculo&status={$resultado}");
                
    break;
    case 'actualizar':
   
        if ($vehiculo->verificarVehiculoDuplicado($_POST['placa'], $_POST['cod_vehiculo'])) {
            header("Location: ?url=vehiculo&status=exists");
            exit();
        }

        $resultado = $vehiculo->actDatosVehiculo(['cod_vehiculo','placa','color','anio','anchura','altura','peso_max','modelo']);
        header("Location: ?url=vehiculo&status={$resultado}");
                
    break;
    case 'eliminar':
        
            $resultado = $vehiculo->elmDatosVehiculo(['cod_vehiculo']);
            header("Location: ?url=vehiculo&status={$resultado}");
          
    break;
}
$registros = $vehiculo->obt_RegistrosVehiculos();
$modelosRegistros = $modelo->obt_RegistrosModelo();

include 'app/view/layout/header.php';
include 'app/view/vehiculo/vehiculoView.php';
include 'app/view/layout/footer.php';
