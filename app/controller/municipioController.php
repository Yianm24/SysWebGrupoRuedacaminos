<?php

namespace App\Controller;

use App\Model\Municipio;
use App\Model\Estado;

$municipio = new Municipio();
$estado = new Estado();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'registrar':

        if ($municipio->verificarMunicipioDuplicado($_POST['nombre_municipio'], $_POST['cod_estado'], $_POST['cod_municipio'])) {
            header("Location: ?url=municipio&status=exists");
            exit();
        }

        $resultado = $municipio->regDatosMunicipio(['nombre_municipio', 'cod_estado']);
        header("Location: ?url=municipio&status={$resultado}");

        break;
    case 'actualizar':

        if ($municipio->verificarMunicipioDuplicado($_POST['nombre_municipio'], $_POST['cod_estado'], $_POST['cod_municipio'])) {
            header("Location: ?url=municipio&status=exists");
            exit();
        }


        $resultado = $municipio->modDatosMunicipio(['cod_municipio', 'nombre_municipio', 'cod_estado']);
        header("Location: ?url=municipio&status=updated");


        break;
    case 'eliminar':

        $resultado = $municipio->elmDatosMunicipio(['cod_municipio']);
        header("Location: ?url=municipio&status={$resultado}");
        break;
}


$registros = $municipio->obt_RegistrosMunicipio();
$estadosRegistros = $estado->obt_RegistrosEstado();
include 'app/view/layout/header.php';
include 'app/view/municipio/municipioView.php';
include 'app/view/layout/footer.php';
