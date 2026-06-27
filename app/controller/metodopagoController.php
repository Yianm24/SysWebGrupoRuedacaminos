<?php

namespace App\Controller;
use App\Model\MetodoPago;

$metodo= new MetodoPago();

$registros=$metodo->obt_RegistrosMetodoPago();
// app/controller/metodopagoController.php
include 'app/view/layout/header.php';
include 'app/view/metodopago/metodopagoView.php';
include 'app/view/layout/footer.php';
