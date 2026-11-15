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
        $datosAjax = json_decode(json_encode($_POST['datos']),true);
        $expRegDatos = [
            'solo-letras' => $datosAjax['nombre_marca']
        ];
        $resultado = $marca->regDatosMarca([$datosAjax['nombre_marca']],$expRegDatos);

        echo $resultado;
        exit();
        break;
    case 'actualizar':

        /* if ($marca->verificarMarcaDuplicada($_POST['nombre_marca'], $_POST['cod_marca'])) {
            header("Location: ?url=marca&status=exists");
            exit();
        } */
        $datosAjax = json_decode(json_encode($_POST['datos']),true);
        $expRegDatos = [
            'solo-numeros' => $datosAjax['cod_marca'],
            'solo-letras' => $datosAjax['nombre_marca']
        ];
        $resultado = $marca->actMarca([$datosAjax['cod_marca'],$datosAjax['nombre_marca']],$expRegDatos);

        echo $resultado;
        exit();
        break;
    case 'eliminar':
        $expRegDatos = [
            'solo-numeros' => $_POST['datos']['cod_marca']
        ];
        $resultado = $marca->elmDatosMarca([$_POST['datos']['cod_marca']],$expRegDatos);
        
        echo $resultado;
        exit();        
        break;
    case 'consultar':
        echo $registros;
        exit();
        break;
}

include 'app/view/layout/header.php';
include 'app/view/marca/marcaView.php';
include 'app/view/layout/footer.php';