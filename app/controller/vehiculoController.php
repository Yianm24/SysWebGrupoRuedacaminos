<?php

namespace App\Controller;

use App\Model\Vehiculo;
use App\Model\Modelo;

$vehiculo = new Vehiculo();
$modelo = new Modelo();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['placa']) && !empty($_POST['color']) && !empty($_POST['tipo_vehiculo']) && !empty($_POST['modelo']) && !empty($_POST['ano'])) {
                
               if ($vehiculo->verificarVehiculoDuplicado($_POST['placa'], $_POST['cod_vehiculo'])) {
                    header("Location: ?url=vehiculo&status=exists");
                    exit();
                }

                $resultado = $vehiculo->regDatosVehiculo($_POST['placa'], $_POST['color'], $_POST['tipo_vehiculo'], $_POST['modelo'], $_POST['ano']);

                header("Location: ?url=vehiculo&status=success");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_vehiculo'])) {
            if (!empty($_POST['cod_vehiculo']) && !empty($_POST['placa']) && !empty($_POST['color']) && !empty($_POST['tipo_vehiculo']) && !empty($_POST['modelo']) && !empty($_POST['ano'])) {

                if ($vehiculo->verificarVehiculoDuplicado($_POST['placa'], $_POST['cod_vehiculo'])) {
                    header("Location: ?url=vehiculo&status=exists");
                    exit();
                }

                $resultado = $vehiculo->actDatosVehiculo($_POST['cod_vehiculo'], $_POST['placa'], $_POST['color'], $_POST['tipo_vehiculo'], $_POST['modelo'], $_POST['ano']);

                header("Location: ?url=vehiculo&status=updated");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
    case 'eliminar':
        if (isset($_POST['cod_vehiculo'])) {
            $resultado = $vehiculo->elmDatosVehiculo($_POST['cod_vehiculo']);
            header("Location: ?url=vehiculo&status=deleted");
            exit();
        }
        break;
}
$registros = $vehiculo->obt_RegistrosVehiculos();
$modelosRegistros = $modelo->obt_RegistrosModelo();

include 'app/view/layout/header.php';
include 'app/view/vehiculo/vehiculoView.php';
include 'app/view/layout/footer.php';
