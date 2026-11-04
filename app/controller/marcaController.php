<?php

namespace App\Controller;

use App\Model\Marca;

$marca = new Marca();
$solicitud = $_POST['tipoSolicitud'] ?? '';
$registros = $marca->obt_RegistrosMarca();
switch ($solicitud) {
    case 'registrar':

        /* if ($marca->verificarMarcaDuplicada($_POST['nombre_marca'], $_POST['cod_marca'])) {
            header("Location: ?url=marca&status=exists");
            exit();
        } */
        $datosAjax = [

            'nombre_marca' => $_POST['nombre_marca'] ?? null
        ];
        $resultado = $marca->regDatosMarca([$datosAjax['nombre_marca']]);

        echo $resultado;
        exit();
        break;
    case 'actualizar':

        /* if ($marca->verificarMarcaDuplicada($_POST['nombre_marca'], $_POST['cod_marca'])) {
            header("Location: ?url=marca&status=exists");
            exit();
        } */
       $datosAjax = [
            'cod_marca' => $_POST['cod_marca'] ?? null,
            'nombre_marca' => $_POST['nombre_marca'] ?? null
        ];

        $resultado = $marca->actMarca([$datosAjax['cod_marca'],$datosAjax['nombre_marca']]);
        echo $resultado;
        exit();
        break;
    case 'eliminar':
        $datosAjax = [
            'cod_marca' => $_POST['cod_marca'] ?? null
        ];
        $resultado = $marca->elmDatosMarca([$datosAjax['cod_marca']]);
        echo $resultado;
        exit();        
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
