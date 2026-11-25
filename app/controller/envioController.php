<?php

namespace App\Controller;

use App\Model\Envio;

$envio = new Envio();

$solicitud = $_POST['tipoSolicitud'] ?? '';
switch ($solicitud) {
    case 'crear':
        $datosEnvio = $_POST['datos'];

        $articulosFragil   = (int) ($datosEnvio['articuloFragil'] ?? 0);
        $datosDespacho     = $datosEnvio['despacho'];
        $datosDestino      = $datosEnvio['destino'];
        $datosRemitente    = $datosEnvio['remitente'];
        $datosDestinatario = $datosEnvio['destinatario'];

        $keyDespacho = $envio->registrarUbicacion($datosDespacho['direccion'], $datosDespacho['municipio']);
        $keyDestino  = $envio->registrarUbicacion($datosDestino['direccion'], $datosDestino['municipio']);

        date_default_timezone_set('America/Caracas');

        $resultado = $envio->creDatosEnvio(
            $datosRemitente,
            $datosDestinatario,
            [
                $datosEnvio['ancho'],
                $datosEnvio['alto'],
                $datosEnvio['descripcion'],
                $datosEnvio['peso_total'],
                $datosEnvio['kilometraje']
            ],
            date('Y-m-d H:i:s'),
            $articulosFragil,
            $keyDespacho,
            $keyDestino
        );
        echo $resultado;
        exit();
        break;

    case 'eliminar':

        $datosEnvio = json_decode(json_encode($_POST['datos']), true);
        $resultado = $envio->elmDatosEnvio([$datosEnvio['cod_envio']]);

        echo $resultado;
        exit();
        break;


    case 'modificar':
        $datosEnvio = $_POST['datos'];

        $datosDespacho = $datosEnvio['despacho'];

        $datosDestino = $datosEnvio['destino'];

        $resultado = $envio->modDatosEnvio(
            [
                $datosEnvio['cod_envio'],
                $datosEnvio['ancho'],
                $datosEnvio['alto'],
                $datosEnvio['descripcion'],
                $datosEnvio['peso_total'],
                $datosEnvio['kilometraje']
            ],
            $datosEnvio['articuloFragil'] ?? 0,
            [
                $datosDespacho['cod_ubi'],
                $datosDespacho['direccion'],
                $datosDespacho['municipio']
            ],
            [
                $datosDestino['cod_ubi'],
                $datosDestino['direccion'],
                $datosDestino['municipio']
            ]
        );

        echo  $resultado;
        exit();
        break;
    case 'consultar':
        $registros = $envio->obt_RegistrosEnvio();
        echo $registros;
        exit();
        break;
}

include 'app/view/layout/header.php';
include 'app/view/envio/envioView.php';
include 'app/view/layout/footer.php';
