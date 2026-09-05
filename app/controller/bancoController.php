<?php
namespace App\Controller;

use App\Model\Banco;

$banco = new Banco();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre_banco'])) {
                
                if ($banco->verificarBancoDuplicado($_POST['nombre_banco'], $_POST['cod_banco'])) {
                    header("Location: ?url=banco&status=exists");
                    exit();
                }

                $resultado = $banco->regDatosBanco($_POST['nombre_banco']);
                header("Location: ?url=banco&status=success");
                exit();
            } else {
                echo "<script>alert('No fue ingresado el nombre del banco');</script>";
            }
        }
        break;
    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_banco']) && !empty($_POST['nombre_banco'])) {

                if ($banco->verificarBancoDuplicado($_POST['nombre_banco'], $_POST['cod_banco'])) {
                    header("Location: ?url=banco&status=exists");
                    exit();
                }

                $resultado = $banco->actBanco($_POST['cod_banco'], $_POST['nombre_banco']);
                header("Location: ?url=banco&status=updated");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
    case 'eliminar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_banco'])) {
                $resultado = $banco->elmDatosBanco($_POST['cod_banco']);
                //echo $resultado;
                header("Location: ?url=banco&status=deleted");
                exit();
            } else {
                echo "<script>alert('Falta el código del Banco');</script>";
            }
        }
}


$registros = $banco->obt_RegistrosBanco();

    // app/controller/unidadesmedidaController.php
    include 'app/view/layout/header.php';
    include 'app/view/banco/bancoView.php';
    include 'app/view/layout/footer.php';
?>