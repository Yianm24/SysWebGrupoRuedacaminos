<?php

namespace App\Controller;

use App\Model\Estado;
use App\Model\Municipio;

$datos = new Estado();
$estados = $datos->obt_RegistrosEstado();

$datos = new Municipio();
$municipios = $datos->obt_RegistrosMunicipio();



// app/controller/envioController.php
include 'app/view/layout/header.php';
include 'app/view/envio/envioView.php';
include 'app/view/layout/footer.php';
?>