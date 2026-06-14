<?php

namespace App\Controller;

use App\Model\Cliente;

$cliente = new Cliente();



$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {

    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_identidad']) && !empty($_POST['razon_social']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_documento'])) {

                $resultado = $$cliente->regDatosCliente($_POST['doc_documento'], $_POST['razon_social'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['tipo_documento']);

                echo "<script>alert('Registro de datos de cliente exitoso');</script>";
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;


        case 'eliminar':
            if (isset($_POST['cod_cliente'])) {
                $resultado = $cliente->elmDatosCliente($_POST['cod_cliente']);
                echo "<script>alert('Cliente eliminado correctamente');</script>";
            }
            break;
}

$registros = $cliente->obt_RegistrosClientes();
include 'app/view/layout/header.php';
include 'app/view/cliente/clienteView.php';
include 'app/view/layout/footer.php';
