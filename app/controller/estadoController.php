<?php

namespace App\Controller;

use App\Model\Estado;

$estado = new Estado();
$solicitud = $_POST['tipoSolicitud'] ?? '';

$registros = $estado->obt_RegistrosEstado();

switch ($solicitud) {
    case 'registrar':

        if ($estado->verificarEstadoDuplicada($_POST['nombre_estado'], $_POST['cod_estado'])) {
            header("Location: ?url=estado&status=exists");
            exit();
        }

        $resultado = $estado->regDatosEstado(['nombre_estado']);
        header("Location: ?url=estado&status={$resultado}");

        break;
    case 'actualizar':


        if ($estado->verificarEstadoDuplicada($_POST['nombre_estado'], $_POST['cod_estado'])) {
            header("Location: ?url=estado&status=exists");
            exit();
        }

        $resultado = $estado->actDatosEstado(['cod_estado', 'nombre_estado']);
        header("Location: ?url=estado&status={$resultado}");


        break;
    case 'eliminar':

        $resultado = $estado->elmDatosEstado(['cod_estado']);

        header("Location: ?url=estado&status={$resultado}");
        break;

    case 'consultar':

        echo $registros;
        exit();
        break;
}


// $registros = $estado->obt_RegistrosEstado();

// app/controller/unidadesmedidaController.php
include 'app/view/layout/header.php';
include 'app/view/estado/estadoView.php';
include 'app/view/layout/footer.php';
