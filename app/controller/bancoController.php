<?php
    namespace App\Controller;

    // Carga manual del modelo para asegurar que PHP lo encuentre sin problemas
    //require_once 'app/Model/Banco.php'; 

    use App\Model\Banco;

    $bancoModel = new Banco ();
    
    $solicitud = $_POST['tipoSolicitud'] ?? '';

    switch ($solicitud) {
        case 'registrar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               if (!empty($_POST['banco']) && !empty($_POST['num_cuenta']) && !empty($_POST['titular'])) {

                    $resultado = $bancoModel->regDatosBanco($_POST['banco'], $_POST['num_cuenta'], $_POST['titular']);

                    echo "<script>alert('Registro de datos de banco exitoso');</script>";
                    echo $resultado;
                    
                } else {
                    echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                }
                
            }
            break;
            
        case 'actualizar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod-banco'])) {
                if (!empty($_POST['banco']) && !empty($_POST['num_cuenta']) && !empty($_POST['titular'])) {
                    
                    $resultado = $bancoModel->actDatosBanco($_POST['cod-banco'], $_POST['banco'], $_POST['num_cuenta'], $_POST['titular']);

                    echo "<script>alert('Actualización de datos del banco realizado exitosamente');</script>";
                    
                } else {
                    echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                }
               
            }
            break;
            
        case 'eliminar':
            if (isset($_POST['cod_banco'])) {
                $resultado = $bancoModel->elmDatosBanco($_POST['cod_banco']);
                echo "<script>alert('Eliminacion de Banco realizado exitosamente');</script>";
              
            }
            break;

    }
    // Llama al método correspondiente para listar los registros en la tabla
   $registros = $bancoModel->obt_RegistrosBancos();
    
    include 'app/view/layout/header.php';
    include 'app/view/banco/bancoView.php';
    include 'app/view/layout/footer.php';
    
?>