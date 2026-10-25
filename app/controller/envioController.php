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

                $keyUBicacionDespacho = $envio->registrarUbicacion($_POST['direccion_origen'], $_POST['municipio_origen']);
                $keyUBicacionDestino = $envio->registrarUbicacion($_POST['direccion_destino'], $_POST['municipio_destino']);


                date_default_timezone_set('America/Caracas');
                $resultado = $envio->creDatosEnvio(['tipo_persona_remitente', 'tipo_persona_destinatario'], $_POST['ancho'], $_POST['alto'], $_POST['descripcion'], date('Y-m-d H:i:s'), $articulosFragil, $_POST['peso_total'], $_POST['kilometraje'], $keyUBicacionDespacho, $keyUBicacionDestino);
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
