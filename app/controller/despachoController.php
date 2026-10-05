<?php

namespace App\Controller;

use App\Model\Empleado;
use App\Model\Vehiculo;

$datosForaneos = [
    'empleado' => (new Empleado())->obt_EmpleadosCargo(4),
    'vehiculo' => (new Vehiculo())->obt_RegistrosVehiculos()
];

include 'app/view/layout/header.php';
include 'app/view/despacho/despachoView.php';
include 'app/view/layout/footer.php';
