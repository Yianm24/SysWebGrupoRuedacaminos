<?php

namespace App\Controller;

use App\Model\Modelo;
use App\Model\Marca;

$modelo = new Modelo();
$marca = new Marca();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        /* if ($modelo->verificarModeloDuplicado($_POST['nombre_modelo'], $_POST['marca'],$_POST['cod_modelo'])) {
            header("Location: ?url=modelo&status=exists");
            exit();
        } */

        $datosAjax = json_decode(json_encode($_POST['datos']),true);
        $expRegDatos = [
            'solo-letras' => $datosAjax['nombre_modelo'],
            'solo-numeros' => $datosAjax['cod_marca']
        ];
        $resultado = $modelo->regDatosModelo([$datosAjax['nombre_modelo'],$datosAjax['cod_marca']],$expRegDatos);
        
        echo $resultado;
        exit();
                
    break;
    case 'actualizar':
       
        /* if ($modelo->verificarModeloDuplicado($_POST['nombre_modelo'], $_POST['marca'],$_POST['cod_modelo'])) {
            header("Location: ?url=modelo&status=exists");
            exit();
        } */
        $datosAjax = json_decode(json_encode($_POST['datos']),true);
         /* $expRegDatos = [
            'solo-numeros' => $datosAjax['cod_modelo'],
            'solo-letras' => $datosAjax['nombre_modelo'],
            'solo-numeros' => $datosAjax['cod_marca']
        ];   */
        $resultado = $modelo->actDatosModelo([$datosAjax['cod_modelo'],$datosAjax['nombre_modelo'],$datosAjax['cod_marca']]);
        
        echo $resultado;
        exit();
            
    break;
    case 'eliminar':
     
        $resultado = $modelo->elmDatosModelo([$_POST['datos']['cod_modelo']]);
        
        echo $resultado;
        exit();
    break;
    case 'consultar':
        $resultado = $modelo->obt_RegistrosModelo();
        echo $resultado;
        exit();
    break;
}


//$registros = $modelo->obt_RegistrosModelo();
$marcasRegistros = $marca->obt_RegistrosMarcaOld();
// app/controller/unidadesmedidaController.php
include 'app/view/layout/header.php';
include 'app/view/modelo/modeloView.php';
include 'app/view/layout/footer.php';
