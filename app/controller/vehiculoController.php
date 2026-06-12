<?php
    namespace App\Controller;
    use App\Model\Vehiculo;

    $vehiculo = new Vehiculo();
    
    $solicitud = $_POST['tipoSolicitud'] ?? '';

    switch ($solicitud) {
        case 'modificar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $id = $_POST['id'];
                
                $respuesta = $object->updateCliente($id, $tipo_persona, $tipo_documento, $numero_documento, $nombre, $apellido, $correo, $telefono, $direccion);
                
               
            }
            break;

        case 'registrar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               if (!empty($_POST['placa']) && !empty($_POST['color']) && !empty($_POST['ano']) ) {

                    $resultado = $vehiculo->regDatosVehiculo($_POST['placa'], $_POST['color'], $_POST['ano']);

                    echo "<script>alert('Datos registrados correctamente');</script>";
                    
                } else {
                    echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                }
                
            }
            break;

        case 'eliminar':
            if (isset($_POST['cod_vehiculo'])) {
                $resultado = $vehiculo->elmDatosVehiculo($_POST['cod_vehiculo']);
                echo "<script>alert('Vehículo eliminado correctamente');</script>";
              
            }
            break;

        /*case 'consultar':
           
            break;
            
        default:
            echo "Error: Solicitud no reconocida.";
            
            break;
     */       
    }
    $registros = $vehiculo->RegistrosVehiculos();
    include 'app/view/layout/header.php';
    include 'app/view/vehiculo/vehiculoView.php';
    include 'app/view/layout/footer.php';
    
?>