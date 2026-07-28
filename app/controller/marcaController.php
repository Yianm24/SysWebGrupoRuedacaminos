<?php
namespace App\Controller;

use App\Model\Marca;

$marca = new Marca();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre_marca'])) {
                if ($marca->verificarMarcaExiste($_POST['nombre_marca'])) {
                    header("Location: ?url=marca&status=exists");
                    exit();
                }
                
                $resultado = $marca->regDatosMarca($_POST['nombre_marca']);
                header("Location: ?url=marca&status=success");
                exit();
            } else {
                echo "<script>alert('No fue ingresado el nombre de la marca');</script>";
            }
        }
        break;
    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_marca']) && !empty($_POST['nombre_marca'])) {

                if ($marca->verificarMarcaDuplicada($_POST['nombre_marca'], $_POST['cod_marca'])) {
                    header("Location: ?url=marca&status=exists");
                    exit();
                }

                $resultado = $marca->actMarca($_POST['cod_marca'], $_POST['nombre_marca']);
                header("Location: ?url=marca&status=updated");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
    case 'eliminar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_marca'])) {
                $resultado = $marca->elmDatosMarca($_POST['cod_marca']);
                //echo $resultado;
                header("Location: ?url=marca&status=deleted");
                exit();
            } else {
                echo "<script>alert('Falta el código de la Marca');</script>";
            }
        }
}


$registros = $marca->obt_RegistrosMarca();

    // app/controller/unidadesmedidaController.php
    include 'app/view/layout/header.php';
    include 'app/view/marca/marcaView.php';
    include 'app/view/layout/footer.php';
?>