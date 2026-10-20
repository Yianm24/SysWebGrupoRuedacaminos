<?php

namespace App\Controller;

use App\Model\Modelo;
use App\Model\Marca;

$modelo = new Modelo();
$marca = new Marca();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($modelo->verificarModeloDuplicado($_POST['nombre_modelo'], $_POST['marca'],$_POST['cod_modelo'])) {
            header("Location: ?url=modelo&status=exists");
            exit();
        }

        $resultado = $modelo->regDatosModelo(['nombre_modelo','marca']);
        header("Location: ?url=modelo&status={$resultado}");
                
    break;
    case 'actualizar':
       
        if ($modelo->verificarModeloDuplicado($_POST['nombre_modelo'], $_POST['marca'],$_POST['cod_modelo'])) {
            header("Location: ?url=modelo&status=exists");
            exit();
        }

        $resultado = $modelo->actDatosModelo(['cod_modelo','nombre_modelo','marca']);
        header("Location: ?url=modelo&status={$resultado}");
            
    break;
    case 'eliminar':
     
        $resultado = $modelo->elmDatosModelo(['cod_modelo']);
        header("Location: ?url=modelo&status={$resultado}");
    break;

}


$registros = $modelo->obt_RegistrosModelo();
$marcasRegistros = $marca->obt_RegistrosMarca();
// app/controller/unidadesmedidaController.php
include 'app/view/layout/header.php';
include 'app/view/modelo/modeloView.php';
include 'app/view/layout/footer.php';
