<?php

namespace App\Controller;

use App\Model\Estado;
use App\Model\Municipio;
use App\Model\Cliente;

use App\Model\Envio;

$envio = new Envio();

$datosEstado = new Estado();
$estados = $datosEstado->obt_RegistrosEstado();

// $datosMunicipio = new Municipio();
// $municipios = $datosMunicipio->obt_RegistrosMunicipio();

// $datosCliente = new Cliente();
// $clientes = $datosCliente->obt_RegistrosClientes();

$datosForaneos = [

    'cliente' => (new Cliente())->obt_RegistrosClientes(),
    'municipio' => (new Municipio())->obt_RegistrosMunicipio(),
    'estado' => (new Estado())->obt_RegistrosEstado()
];


$solicitud = $_POST['tipoSolicitud'] ?? '';
switch ($solicitud) {
    case 'crear':

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['descripcion'])) {

                $resultado = $envio->regDatosEnvio($_POST['precio_envio'], $_POST['ancho'], $_POST['alto'], $_POST['peso_total'], $_POST['descripcion'], date('Y-m-d H:i:s'), $_POST['articulos_fragil']);
                echo $resultado;
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }


        // switch ($_POST['tipo_persona_remitente']) {
        //     case 'remitente_natural':
        //         $doc_identidad = $_POST['rem_cedula'];
        //         $tipo_documento = $_POST['rem_documento_natural'];
        //         $razon_social = $_POST['rem_nombre'];
        //         break;
        //     case 'remitente_juridico':
        //         $doc_identidad = $_POST['rem_rif'];
        //         $tipo_documento = $_POST['rem_documento_juridico'];
        //         $razon_social = $_POST['rem_razon_social'];
        //         break;
        // }

        // if ($datosCliente->verificarClienteExiste($doc_identidad)) {
        //     $keyCliente = $datosCliente->RetornarKeyCliente($doc_identidad);
        //     echo $keyCliente;

        // } else {
        //     $resultadoRemitente = $datosCliente->regDatosCliente(
        //         $doc_identidad,
        //         $razon_social,
        //         $_POST['rem_apellido'] ?? null,
        //         $_POST['rem_telefono'],
        //         $_POST['rem_correo'],
        //         $tipo_documento
        //     );
        //     $keyCliente = $datosCliente->RetornarKeyCliente($doc_identidad);
        //     echo $keyCliente;
        // }

        break;
}

// app/controller/envioController.php
include 'app/view/layout/header.php';
include 'app/view/envio/envioView.php';
include 'app/view/layout/footer.php';
