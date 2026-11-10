<?php

namespace App\Controller;

use App\Model\Estado;
use App\Model\Municipio;
use App\Model\Cliente;

use App\Model\Envio;
use App\Model\Kilometraje;

$envio = new Envio();

// $datosMunicipio = new Municipio();
// $municipios = $datosMunicipio->obt_RegistrosMunicipio();

// $datosCliente = new Cliente();
// $clientes = $datosCliente->obt_RegistrosClientes();

$datosForaneos = [

    'cliente' => (new Cliente())->obt_RegistrosClientes(),
    'municipio' => (new Municipio())->obt_RegistrosMunicipioNoAjax(),
    'estado' => (new Estado())->obt_RegistrosEstado(),
    'preciokilometraje' => (new Kilometraje())->obt_RegistrosKilometraje()
];

$instanciaForaneas = [
    'cliente' => new Cliente(),
    'municipio' => new Municipio(),
    'estado' => new Estado()
];

$solicitud = $_POST['tipoSolicitud'] ?? '';
switch ($solicitud) {
    case 'crear':
        $articulosFragil = ($_POST['articulosFragil']) ? 1 : 0;

        $datosDespacho = json_decode(json_encode($_POST['despacho']), true);
        $datosDestino = json_decode(json_encode($_POST['destino']), true);


        $keyDespacho = $envio->registrarUbicacion($datosDespacho['direccion'], $datosDespacho['municipio']);
        $keyDestino = $envio->registrarUbicacion($datosDestino['direccion'], $datosDestino['municipio']);


        date_default_timezone_set('America/Caracas');
        
        $datosEnvio = json_decode(json_encode($_POST['datos']), true);
        $datosRemitente = json_decode(json_encode($_POST['remitente']), true);
        $datosDestinatario = json_decode(json_encode($_POST['destinatario']), true);
        $resultado = $envio->creDatosEnvio($datosRemitente,$datosDestinatario, [$datosEnvio['ancho'], $datosEnvio['alto'], $datosEnvio['descripcion'], $datosEnvio['peso_total'], $datosEnvio['kilometraje']], date('Y-m-d H:i:s'), $articulosFragil, $keyDespacho, $keyDestino);
        echo $resultado;
        exit();

        break;

    case 'eliminar':


        $resultado = $envio->elmDatosEnvio(['cod_envio']);

        header("Location: ?url=envio&status={$resultado}");

        echo $resultado;

        break;


    case 'modificar':
        $articulosFragil = (isset($_POST['articulos_fragil'])) ? 1 : 0;

        $keyUBicacionDespacho = $envio->registrarUbicacion($_POST['direccion_origen'], $_POST['municipio_origen']);
        $keyUBicacionDestino = $envio->registrarUbicacion($_POST['direccion_destino'], $_POST['municipio_destino']);


        date_default_timezone_set('America/Caracas');
        // $resultado = $envio->creDatosEnvio(['tipo_persona_remitente', 'tipo_persona_destinatario'], $_POST['ancho'], $_POST['alto'], $_POST['descripcion'], date('Y-m-d H:i:s'), $articulosFragil, $_POST['peso_total'], $_POST['kilometraje'], $keyUBicacionDespacho, $keyUBicacionDestino);
        $resultado = $envio->modEnvio(['tipo_persona_remitente', 'tipo_persona_destinatario'], ['cod_envio', 'ancho', 'alto', 'descripcion', 'peso_total', 'kilometraje'], date('Y-m-d H:i:s'), $articulosFragil, $keyUBicacionDespacho, $keyUBicacionDestino);
        header("Location: ?url=envio&status={$resultado}");

        break;
    case 'consultar':
        $registros = $envio->obt_RegistrosEnvio();
        /* print_r($registros); */
        echo $registros;
        exit();
        break;
}

//$registros = $envio->obt_RegistrosEnvio();

// app/controller/envioController.php
include 'app/view/layout/header.php';
include 'app/view/envio/envioView.php';
include 'app/view/layout/footer.php';
