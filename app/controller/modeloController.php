<?php

namespace App\Controller;

use App\Model\Modelo;
use App\Model\Marca;

$modelo = new Modelo();
$marca = new Marca();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre_modelo']) && !empty($_POST['marca']) && $_POST['marca'] != '0') {
                if ($modelo->verificarModeloDuplicado($_POST['nombre_modelo'], $_POST['marca'],$_POST['cod_modelo'])) {
                    header("Location: ?url=modelo&status=exists");
                    exit();
                }

                $resultado = $modelo->regDatosModelo($_POST['nombre_modelo'], $_POST['marca']);
                header("Location: ?url=modelo&status=success");
                exit();
            } else {
                
            }
        }
        break;
    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_modelo']) && !empty($_POST['nombre_modelo']) && !empty($_POST['marca']) && $_POST['marca'] != '0') {
                if ($modelo->verificarModeloDuplicado($_POST['nombre_modelo'], $_POST['marca'],$_POST['cod_modelo'])) {
                    header("Location: ?url=modelo&status=exists");
                    exit();
                }


                $resultado = $modelo->actDatosModelo($_POST['cod_modelo'], $_POST['nombre_modelo'], $_POST['marca']);
                header("Location: ?url=modelo&status=updated");
                exit();
            } else {
                header("Location: ?url=modelo&status=empty");
                exit();
            }
        }
        break;
    case 'eliminar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_modelo'])) {
                $resultado = $modelo->elmDatosModelo($_POST['cod_modelo']);
                //echo $resultado;
                header("Location: ?url=modelo&status=deleted");
                exit();
            } else {
                header("Location: ?url=modelo&status=empty");
                exit();
            }
        }
}


$registros = $modelo->obt_RegistrosModelo();
$marcasRegistros = $marca->obt_RegistrosMarca();
// app/controller/unidadesmedidaController.php
include 'app/view/layout/header.php';
include 'app/view/modelo/modeloView.php';
include 'app/view/layout/footer.php';
