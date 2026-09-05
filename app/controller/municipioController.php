<?php

namespace App\Controller;

use App\Model\Municipio;
use App\Model\Estado;

$municipio = new Municipio();
$estado = new Estado();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre_municipio']) && !empty($_POST['cod_estado'])) {
                if ($municipio->verificarMunicipioDuplicado($_POST['nombre_municipio'], $_POST['cod_estado'], $_POST['cod_municipio'])) {
                    header("Location: ?url=municipio&status=exists");
                    exit();
                }

                $resultado = $municipio->regDatosMunicipio($_POST['nombre_municipio'], $_POST['cod_estado']);
                header("Location: ?url=municipio&status=success");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_municipio']) && !empty($_POST['nombre_municipio']) && !empty($_POST['cod_estado'])) {
                if ($municipio->verificarMunicipioDuplicado($_POST['nombre_municipio'], $_POST['cod_estado'], $_POST['cod_municipio'])) {
                    header("Location: ?url=municipio&status=exists");
                    exit();
                }


                $resultado = $municipio->modDatosMunicipio($_POST['cod_municipio'], $_POST['nombre_municipio'], $_POST['cod_estado']);
                header("Location: ?url=municipio&status=updated");
                exit();
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
    case 'eliminar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_municipio'])) {
                $resultado = $municipio->elmDatosMunicipio($_POST['cod_municipio']);
                //echo $resultado;
                header("Location: ?url=municipio&status=deleted");
                exit();
            } else {
                echo "<script>alert('Falta el código del municipio');</script>";
            }
        }
}


$registros = $municipio->obt_RegistrosMunicipio();
$estadosRegistros = $estado->obt_RegistrosEstado();
include 'app/view/layout/header.php';
include 'app/view/municipio/municipioView.php';
include 'app/view/layout/footer.php';
