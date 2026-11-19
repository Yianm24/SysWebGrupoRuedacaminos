<?php
    namespace App\Controller;
    
    use App\Model\Reporte;
    use App\Model\Envio;
    use App\Model\Pago;

    $solicitud = $_POST['tipoSolicitud'] ?? '';
    $objEnvio = new Envio();
    $objPago = new Pago();
    $objReporte = new Reporte();


    switch ($solicitud) {
        case 'envios':

            $registros = json_decode($objEnvio->obt_RegistrosEnvio(),true);

            $objReporte->ConstruirHtml('envio',$registros);
            exit();
        break;


        /* case 'pagos':
            $registros = $objPago->obt_RegistrosPago();
            $resultado = $rol->elmDatosRol($_POST['cod_rol']);
            header("Location: ?url=rol&status=deleted");
            exit();
        break; */
    }

    include 'app/view/layout/header.php';
    include 'app/view/reporte/reporteView.php';
    include 'app/view/layout/footer.php';
?>