<?php
    namespace App\Controller;

    // Carga manual del modelo para asegurar que PHP lo encuentre sin problemas
    //require_once 'app/Model/Banco.php'; 

    use App\Model\Cuenta;

    $cuenta = new Cuenta ();
    
    $solicitud = $_POST['tipoSolicitud'] ?? '';

    switch ($solicitud) {
        case 'registrar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               if (!empty($_POST['nombre_propietario']) && !empty($_POST['etiqueta_cuenta']) && !empty($_POST['numero_cuenta']) && !empty($_POST['nombre_banco'])) {

                    $resultado = $cuenta->regDatosCuenta($_POST['nombre_propietario'], $_POST['etiqueta_cuenta'], $_POST['numero_cuenta'], $_POST['nombre_banco']);
                    header("Location: ?url=cuenta&status=success");
                    exit();
                    
                } else {
                    echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                }
                
            }
            break;
            
        case 'actualizar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_cuenta'])) {
                if (!empty($_POST['cod_cuenta']) && !empty($_POST['nombre_propietario']) && !empty($_POST['etiqueta_cuenta']) && !empty($_POST['numero_cuenta']) && !empty($_POST['nombre_banco'])) {
                    
                    $resultado = $cuenta->actDatosCuenta($_POST['cod_cuenta'],$_POST['nombre_propietario'], $_POST['etiqueta_cuenta'], $_POST['numero_cuenta'], $_POST['nombre_banco']);
                    //echo $resultado;
                    header("Location: ?url=cuenta&status=updated");
                    exit();
                   
                    
                } else {
                    echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                }
               
            }
            break;
            
       case 'eliminar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_cuenta'])) {
                $resultado = $cuenta->elmDatosCuenta($_POST['cod_cuenta']);
                //echo "<script>alert('Eliminación de cuenta realizada exitosamente');</script>";
                header("Location: ?url=cuenta&status=deleted");
                exit();
            } else {
                echo "<script>alert('Falta el código de la unidad de medida');</script>";
            }
        }

    }
    // Llama al método correspondiente para listar los registros en la tabla
   $bancos = $cuenta->obt_RegistrosBancos();
    $registros = $cuenta->obt_RegistrosCuentas();
    
    include 'app/view/layout/header.php';
    include 'app/view/cuenta/cuentaView.php';
    include 'app/view/layout/footer.php';
    
?>