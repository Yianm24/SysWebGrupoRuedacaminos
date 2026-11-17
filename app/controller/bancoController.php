<?php

namespace App\Controller;

use App\Model\Banco;

$banco = new Banco();
$solicitud = $_POST['tipoSolicitud'] ?? '';

$registros = $banco->obt_RegistrosBanco();

switch ($solicitud) {
    case 'registrar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $banco->regDatosBanco([$datosAjax['nombre_banco']]);
        echo $resultado;

        exit();
        break;
    case 'actualizar':

        $datosAjax = json_decode(json_encode($_POST['datos']), true);

        $resultado = $banco->actDatosBanco([$datosAjax['cod_banco'], $datosAjax['nombre_banco']]);
        echo $resultado;
        exit();

        break;
    case 'eliminar':


        $resultado = $banco->elmDatosBanco([$_POST['datos']['cod_banco']]);

        echo $resultado;
        exit();
        break;

    case 'consultar':

        echo $registros;
        exit();
        break;
}
include 'app/view/layout/header.php';
include 'app/view/banco/bancoView.php';
include 'app/view/layout/footer.php';
