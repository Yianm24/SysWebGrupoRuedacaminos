<?php

namespace App\Controller;

use App\Model\Estado;
use App\Model\Municipio;
use App\Model\Cliente;

$datosEstado = new Estado();
$estados = $datosEstado->obt_RegistrosEstado();

$datosMunicipio = new Municipio();
$municipios = $datosMunicipio->obt_RegistrosMunicipio();

$datosCliente = new Cliente();
$clientes = $datosCliente->obt_RegistrosClientes();

$solicitud = $_POST['tipoSolicitud'] ?? '';
switch ($solicitud) {
    case 'crear':

        if ($datosCliente->verificarClienteExiste($_POST['rem_cedula'])) {
            $keyCliente=$datosCliente->RetornarKeyCliente($_POST['rem_cedula']);
            echo $keyCliente;
            //header('Location: ?url=envio&status=success');
            //exit();
        }
        // else{

        // $keyCliente=$datosCliente->RetornarKeyCliente($_POST['rem_cedula']);
        //     header('Location: ?url=envio&status=success');
        //     exit();
        // }

        break;
}

// app/controller/envioController.php
include 'app/view/layout/header.php';
include 'app/view/envio/envioView.php';
include 'app/view/layout/footer.php';
