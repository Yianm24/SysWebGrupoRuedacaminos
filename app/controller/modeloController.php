<?php
namespace App\Controller;

use App\Model\Modelo;

$modelo = new Modelo();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre']) && !empty($_POST['marca'])) {
                if ($modelo->verificarModeloExiste($_POST['nombre'], $_POST['marca'])) {
                    header("Location: ?url=modelo&status=exists");
                    exit();
                }

                $resultado = $modelo->regDatosmodelo($_POST['nombre'],$_POST['marca']);
                header("Location: ?url=modelo&status=success");
                exit();
            } else {
                echo "<script>alert('No fue ingresado el nombre de la modelo');</script>";
            }
        }
        break;
    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_modelo']) && !empty($_POST['nombre_modelo'])) {

                if ($modelo->verificarModeloExiste($_POST['nombre_modelo'], $_POST['nombre_marca'])) {
                    header("Location: ?url=modelo&status=exists");
                    exit();
                }

                $resultado = $modelo->modDatosModelo($_POST['cod_modelo'], $_POST['nombre_modelo'],$_POST['cod_marca']);
                header("Location: ?url=modelo&status=updated");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
    case 'eliminar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_modelo'])) {
                $resultado = $modelo->elmDatosModelo($_POST['cod_modelo']);
                //echo $resultado;
                header("Location: ?url=modelo&status=deleted");
                exit();
            } else {
                echo "<script>alert('Falta el código de la modelo');</script>";
            }
        }
}


$registros = $modelo->obt_RegistrosModelo();
    // app/controller/unidadesmedidaController.php
    include 'app/view/layout/header.php';
    include 'app/view/modelo/modeloView.php';
    include 'app/view/layout/footer.php';
?>