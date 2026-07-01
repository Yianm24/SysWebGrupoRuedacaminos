<?php
    namespace App\Controller;
    use App\Model\Vehiculo;

    $vehiculo = new Vehiculo();
    
    $solicitud = $_POST['tipoSolicitud'] ?? '';

    switch ($solicitud) {
        case 'registrar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               if (!empty($_POST['placa']) && !empty($_POST['color']) && !empty($_POST['tipo-vehiculo']) && !empty($_POST['modelo']) && !empty($_POST['ano']) ) {

                    $resultado = $vehiculo->regDatosVehiculo($_POST['placa'],$_POST['color'],$_POST['tipo-vehiculo'], $_POST['modelo'] ,$_POST['ano'] );

                    //echo "<script>alert('Registro de datos de vehículo exitoso');</script>";
                    header("Location: ?url=vehiculo&status=success");
                    exit();
                    
                } else {
                    echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                }
                
            }
            break;
        case 'actualizar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod-vehiculo'])) {
                if (!empty($_POST['placa']) && !empty($_POST['color']) && !empty($_POST['tipo-vehiculo']) && !empty($_POST['modelo']) && !empty($_POST['ano']) ) {
                    
                    $resultado = $vehiculo->actDatosVehiculo($_POST['cod-vehiculo'], $_POST['placa'], $_POST['color'],$_POST['tipo-vehiculo'], $_POST['modelo'], $_POST['ano']);

                    //echo "<script>alert('Actualización de datos del vehículo realizado exitosamente');</script>";
                    //echo $resultado;
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
    
    //$datosEditable = $_GET['prueba'] ?? 'no me dieron nada';
    /*foreach ($registros as $dato):
        if ($_REQUEST['obtener-codigo'] == $dato['cod_vehiculo']) {
            $datosEditable = $dato;
        }
    endforeach;*/

    include 'app/view/layout/header.php';
    include 'app/view/vehiculo/vehiculoView.php';
    include 'app/view/layout/footer.php';
    
?>