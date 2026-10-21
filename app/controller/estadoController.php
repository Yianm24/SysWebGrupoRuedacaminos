<?php

namespace App\Controller;

use App\Model\Estado;

$estado = new Estado();
$solicitud = $_POST['tipoSolicitud'] ?? '';

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_estado'])) {
                $resultado = $estado->elmDatosEstado($_POST['cod_estado']);
                //echo $resultado;
                header("Location: ?url=estado&status=deleted");
                exit();
            } else {
                echo "<script>alert('Falta el código de la estado');</script>";
            }
        }
}


$registros = $estado->obt_RegistrosEstado();

// app/controller/unidadesmedidaController.php
include 'app/view/layout/header.php';
include 'app/view/estado/estadoView.php';
include 'app/view/layout/footer.php';
