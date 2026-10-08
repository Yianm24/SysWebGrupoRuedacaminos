<?php

namespace App\Controller;

use App\Model\Estado;
use App\Model\Municipio;
use App\Model\Cliente;

use App\Model\Envio;

$envio = new Envio();

// $datosMunicipio = new Municipio();
// $municipios = $datosMunicipio->obt_RegistrosMunicipio();

// $datosCliente = new Cliente();
// $clientes = $datosCliente->obt_RegistrosClientes();

$datosForaneos = [

    'cliente' => (new Cliente())->obt_RegistrosClientes(),
    'municipio' => (new Municipio())->obt_RegistrosMunicipio(),
    'estado' => (new Estado())->obt_RegistrosEstado()
];

$instanciaForaneas = [
    'cliente' => new Cliente(),
    'municipio' => new Municipio(),
    'estado' => new Estado()
];

$solicitud = $_POST['tipoSolicitud'] ?? '';
switch ($solicitud) {
    case 'crear':

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['ancho']) && !empty($_POST['alto']) && !empty($_POST['descripcion'])) {

                $articulosFragil = (isset($_POST['articulos_fragil'])) ? 1 : 0;


                //remitente
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

                if ($instanciaForaneas['cliente']->verificarClienteExiste($doc_identidad)) {
                    $keyRemitente = $instanciaForaneas['cliente']->RetornarKeyCliente($doc_identidad);
                } else {
                    $resultadoRemitente = $instanciaForaneas['cliente']->regDatosCliente(
                        $doc_identidad,
                        $razon_social,
                        $_POST['rem_apellido'] ?? null,
                        $_POST['rem_telefono'],
                        $_POST['rem_correo'],
                        $tipo_documento
                    );
                    $keyRemitente = $instanciaForaneas['cliente']->RetornarKeyCliente($doc_identidad);
                }

                //destinatario
                switch ($_POST['tipo_persona_destinatario']) {
                    case 'destinatario_natural':
                        $doc_identidad2 = $_POST['dest_cedula'];
                        $tipo_documento2 = $_POST['dest_documento_natural'];
                        $razon_social2 = $_POST['dest_nombre'];
                        break;
                    case 'destinatario_juridico':
                        $doc_identidad2 = $_POST['dest_rif'];
                        $tipo_documento2 = $_POST['dest_documento_juridico'];
                        $razon_social2 = $_POST['dest_razon_social'];
                        break;
                }

                if ($instanciaForaneas['cliente']->verificarClienteExiste($doc_identidad2)) {
                    $keyDestinatario = $instanciaForaneas['cliente']->RetornarKeyCliente($doc_identidad2);
                } else {
                    $resultadoRemitente = $instanciaForaneas['cliente']->regDatosCliente(
                        $doc_identidad2,
                        $razon_social2,
                        $_POST['dest_apellido'] ?? null,
                        $_POST['dest_telefono'],
                        $_POST['dest_correo'],
                        $tipo_documento2
                    );

                    $keyDestinatario = $instanciaForaneas['cliente']->RetornarKeyCliente($doc_identidad2);
                }

                        $keyUBicacionDespacho = $envio->registrarUbicacion($_POST['direccion_origen'], $_POST['municipio_origen']);
                        $keyUBicacionDestino = $envio->registrarUbicacion($_POST['direccion_destino'], $_POST['municipio_destino']);

                        // echo $keyUBicacionDespacho;
                        // echo $keyUBicacionDestino;

                date_default_timezone_set('America/Caracas');
                $resultado = $envio->creDatosEnvio($keyRemitente, $keyDestinatario, $_POST['ancho'], $_POST['alto'], $_POST['descripcion'], date('Y-m-d H:i:s'), $articulosFragil, $_POST['peso_total'],$_POST['kilometraje'],$keyUBicacionDespacho, $keyUBicacionDestino);
                echo $resultado;
                header('Location: ?url=envio&status=success');
                exit();
            } else {
                header('Location: ?url=envio&status=empty');
                exit();
            }
        }



        break;
}

$registros = $envio->obt_RegistrosEnvio();

// app/controller/envioController.php
include 'app/view/layout/header.php';
include 'app/view/envio/envioView.php';
include 'app/view/layout/footer.php';
