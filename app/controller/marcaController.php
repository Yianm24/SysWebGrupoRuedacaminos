<?php

namespace App\Controller;

use App\Model\Marca;

$marca = new Marca();
$solicitud = $_POST['tipoSolicitud'] ?? '';
$registros = $marca->obt_RegistrosMarca();
switch ($solicitud) {
    case 'registrar':

        if ($marca->verificarMarcaDuplicada($_POST['nombre_marca'], $_POST['cod_marca'])) {
            header("Location: ?url=marca&status=exists");
            exit();
        }

        $resultado = $marca->regDatosMarca(['nombre_marca']);
        header("Location: ?url=marca&status={$resultado}");

        break;
    case 'actualizar':

        if ($marca->verificarMarcaDuplicada($_POST['nombre_marca'], $_POST['cod_marca'])) {
            header("Location: ?url=marca&status=exists");
            exit();
        }

        $resultado = $marca->actMarca(['cod_marca', 'nombre_marca']);
        header("Location: ?url=marca&status={$resultado}");

        break;
    case 'eliminar':
        $resultado = $marca->elmDatosMarca(['cod_marca']);
        header("Location: ?url=marca&status={$resultado}");
        break;
    case 'consultar':
        echo $registros;
        exit();
        break;
}

//$registros = $marca->obt_RegistrosMarca();
//$enJson = json_encode($registros);
//print_r($registros);
//$marca->buscarId();
// app/controller/unidadesmedidaController.php
/* if($_GET['tipoSolicitud'] == 'consultar'){
    echo $registros;
    exit;
} */
include 'app/view/layout/header.php';
include 'app/view/marca/marcaView.php';
include 'app/view/layout/footer.php';
