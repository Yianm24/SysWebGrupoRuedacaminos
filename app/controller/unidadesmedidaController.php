<?php
namespace App\Controller;
use App\Model\UnidadMedida;

$unidadMedida = new UnidadMedida();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre_unidad']) && !empty($_POST['abreviatura']) && !empty($_POST['tipo_unidad'])) {
                $resultado = $unidadMedida->regDatosUnidadMedida($_POST['nombre_unidad'], $_POST['abreviatura'], $_POST['tipo_unidad']);
                header("Location: ?url=unidadesmedida&status=success");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
}


$registros = $unidadMedida->obt_RegistrosUnidadMedida();

    // app/controller/unidadesmedidaController.php
    include 'app/view/layout/header.php';
    include 'app/view/unidadesmedida/unidadmedidaView.php';
    include 'app/view/layout/footer.php';
?>