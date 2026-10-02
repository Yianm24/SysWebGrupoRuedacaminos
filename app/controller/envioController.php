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
        
        if($_POST['tipo_persona_remitente'] === 'remitente_natural') {
            $doc_identidad = $_POST['rem_cedula'];
            $tipo_documento = $_POST['rem_documento_natural'];
            $razon_social = $_POST['rem_nombre'];
        } else {
            $doc_identidad = $_POST['rem_rif'];
            $tipo_documento = $_POST['rem_documento_juridico'];
            $razon_social = $_POST['rem_razon_social'];
        }
        if ($datosCliente->verificarClienteExiste($doc_identidad)) {
            $keyCliente=$datosCliente->RetornarKeyCliente($doc_identidad);
            echo $keyCliente;
            //header('Location: ?url=envio&status=success');
            //exit();
        }
        else{
            

            $resultadoRemitente = $datosCliente->regDatosCliente(
                $doc_identidad,
                $razon_social,
                $_POST['rem_apellido'] ?? null,
                $_POST['rem_telefono'],
                $_POST['rem_correo'],
                $tipo_documento
            );
           /*  $resultadoDestinatario = $datosCliente->regDatosCliente(
                $_POST['dest_cedula'],
                $_POST['dest_nombre'],
                $_POST['dest_apellido'] ?? null,
                $_POST['dest_telefono'],
                $_POST['dest_correo'],
                $_POST['dest_nacionalidad']
            ); */
            if ($resultadoRemitente) {
                $keyCliente=$datosCliente->RetornarKeyCliente($doc_identidad);
                echo $keyCliente;
               /*  $keyCliente=$datosCliente->RetornarKeyCliente($_POST['dest_cedula']);
                echo $keyCliente; */
                //header('Location: ?url=envio&status=success');
                //exit();
            } else {
                echo "<script>alert('Error al registrar el cliente');</script>";
            }
        }
        $keyCliente=$datosCliente->RetornarKeyCliente($doc_identidad);
        //     header('Location: ?url=envio&status=success');
        //     exit();
        // }

        break;
}

// app/controller/envioController.php
include 'app/view/layout/header.php';
include 'app/view/envio/envioView.php';
include 'app/view/layout/footer.php';
