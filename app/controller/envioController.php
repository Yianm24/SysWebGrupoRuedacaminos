<?php

namespace App\Controller;

use App\Model\Estado;
use App\Model\Municipio;
use App\Model\Cliente;

$datosEstado = new Estado();
$estados = $datosEstado->obt_RegistrosEstado();

// $datosMunicipio = new Municipio();
// $municipios = $datosMunicipio->obt_RegistrosMunicipio();

// $datosCliente = new Cliente();
// $clientes = $datosCliente->obt_RegistrosClientes();

$datosForaneos = [

    'cliente' => (new Cliente())->obt_RegistrosClientes(),
    'municipio' => (new Municipio())->obt_RegistrosMunicipio()
];


$solicitud = $_POST['tipoSolicitud'] ?? '';
switch ($solicitud) {
    case 'crear':



        //Remitente

        //Verifica si es remitete natural o juridico y asigna los valores correspondientes
        switch ($_POST['tipo_persona_remitente']) {
            case 'remitente_natural':
                $doc_identidad = $_POST['rem_cedula'];
                $tipo_documento = $_POST['rem_documento_natural'];
                $razon_social = $_POST['rem_nombre'];
                break;
            case 'remitente_juridico':
                $doc_identidad = $_POST['rem_rif'];
                $tipo_documento = $_POST['rem_documento_juridico'];
                $razon_social = $_POST['rem_razon_social'];
                break;
        }

        if ($datosCliente->verificarClienteExiste($doc_identidad)) {
            $keyCliente = $datosCliente->RetornarKeyCliente($doc_identidad);
            echo $keyCliente;
            //header('Location: ?url=envio&status=success');
            //exit();
        } else {
            $resultadoRemitente = $datosCliente->regDatosCliente(
                $doc_identidad,
                $razon_social,
                $_POST['rem_apellido'] ?? null,
                $_POST['rem_telefono'],
                $_POST['rem_correo'],
                $tipo_documento
            );
            $keyCliente = $datosCliente->RetornarKeyCliente($doc_identidad);
            echo $keyCliente;
        }

        break;
}

// app/controller/envioController.php
include 'app/view/layout/header.php';
include 'app/view/envio/envioView.php';
include 'app/view/layout/footer.php';
