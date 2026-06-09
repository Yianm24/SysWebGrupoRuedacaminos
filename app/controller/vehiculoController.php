<?php
    namespace App\Controller;
    use App\Model\Vehiculo;

    $vehiculo = new Vehiculo();
    
    $solicitud = $_GET['tipoSolicitud'] ?? 'registrar';

    switch ($solicitud) {
        /*case 'update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $id = $_POST['id'];
                
                $tipo_persona = (isset($_POST['tipo_persona_remitente']) && $_POST['tipo_persona_remitente'] === 'remitente_juridico') ? 'juridica' : 'natural';
                
                if ($tipo_persona === 'natural') {
                    $tipo_documento = $_POST['tipo_doc_natural'] ?? '';
                    $numero_documento = $_POST['cedula'] ?? '';
                    $nombre = $_POST['nombre'] ?? '';
                    $apellido = $_POST['apellido'] ?? '';
                } else {
                    $tipo_documento = $_POST['tipo_doc_juridico'] ?? '';
                    $numero_documento = $_POST['rif'] ?? '';
                    $nombre = $_POST['razon_social'] ?? '';
                    $apellido = null;
                }
                
                $telefono = $_POST['telefono'] ?? '';
                $correo = $_POST['correo'] ?? '';
                $direccion = $_POST['direccion'] ?? '';
                
                $respuesta = $object->updateCliente($id, $tipo_persona, $tipo_documento, $numero_documento, $nombre, $apellido, $correo, $telefono, $direccion);
                
               
            }
            break;

        */case 'registrar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               if (!empty($_POST['placa']) && !empty($_POST['color']) && !empty($_POST['ano']) ) {

                    $result = $vehiculo->addVehiculo($_POST['placa'], $_POST['color'], $_POST['ano']);

                    echo "<script>alert('Datos registrados correctamente');</script>";
                } else {
                    echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                }
            }
            break;

        /*case 'delete':
            if (isset($_GET['id'])) {
                $respuesta = $object->deleteCliente($_GET['id']);
              
            }
            break;

        case 'main':
            if (isset($_POST["getClientes"])) {
                echo json_encode($object->getAllClientes());
                die();
            }
            if (isset($_POST["deleteCliente"])) {
                echo json_encode($object->deleteCliente($_POST["idCliente"]));
                die();
            }
            
            break;

        default:
            echo "Error: Tipo de vista no válido.";
            
            break;
            */
    }

    $result = $vehiculo->getAllVehiculos();


    include 'app/view/layout/header.php';
    include 'app/view/vehiculo/vehiculoView.php';
    include 'app/view/layout/footer.php';
?>
