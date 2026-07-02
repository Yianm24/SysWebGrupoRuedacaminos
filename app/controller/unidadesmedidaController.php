<?php
namespace App\Controller;
use App\Model\UnidadMedida;

$unidadMedida = new UnidadMedida();

$registros = $unidadMedida->obt_RegistrosUnidadMedida();


    // app/controller/unidadesmedidaController.php
    include 'app/view/layout/header.php';
    include 'app/view/unidadesmedida/unidadmedidaView.php';
    include 'app/view/layout/footer.php';
?>