<?php

namespace App\Controller;

use App\Model\Municipio;

$municipio = new Municipio();

$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $municipio->regDatosMunicipio([$datosAjax['nombre_municipio'], $datosAjax['cod_estado']]);

        echo $resultado;
        exit();
        break;
    case 'modificar':
        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $municipio->modDatosMunicipio([$datosAjax['cod_municipio'], $datosAjax['nombre_municipio'], $datosAjax['cod_estado']]);
        echo $resultado;
        exit();
        break;
    case 'eliminar':

        $resultado = $municipio->elmDatosMunicipio([$_POST['datos']['cod_municipio']]);
        echo $resultado;
        exit();
        break;

    case 'consultar':
        $registros = $municipio->obt_RegistrosMunicipio();
        echo $registros;
        exit();
        break;
}



// $estadosRegistros = $estado->obt_RegistrosEstado();
include 'app/view/layout/header.php';
include 'app/view/municipio/municipioView.php';
include 'app/view/layout/footer.php';
