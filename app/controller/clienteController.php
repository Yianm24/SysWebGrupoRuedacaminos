<?php

namespace App\Controller;

use App\Model\Cliente;

$cliente = new Cliente();



$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {

    case 'registrar':


        $tipoPersona = $_POST['tipo_persona_remitente'] ?? '';
        switch ($tipoPersona) {
            case 'remitente_natural':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!empty($_POST['cedula']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_doc_natural'])) {

                        $resultado = $cliente->regDatosCliente($_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['tipo_doc_natural']);
                        echo "<script>alert('Cliente registrado exitosamente');</script>";
                    } else {
                        echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                    }
                }
                break;
            case 'remitente_juridico':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!empty($_POST['rif']) && !empty($_POST['razon_social'])  && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_doc_natural'])) {

                        $resultado = $cliente->regDatosCliente($_POST['rif'], $_POST['razon_social'], null, $_POST['telefono'], $_POST['email'], $_POST['tipo_doc_juridico']);
                        echo "<script>alert('Cliente registrado exitosamente');</script>";
                    } else {
                        echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                    }
                }
                break;
        }

        break;


    case 'eliminar':
        if (isset($_POST['cod_cliente'])) {
            $resultado = $cliente->elmDatosCliente($_POST['cod_cliente']);
            echo "<script>alert('Cliente eliminado correctamente');</script>";
        }
        break;


    case 'editarJuridico':

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_cliente']) && !empty($_POST['rif']) && !empty($_POST['razon_social'])  && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_doc_juridico'])) {

                $resultado = $cliente->editDatosCliente($_POST['cod_cliente'], $_POST['rif'], $_POST['razon_social'], null, $_POST['telefono'], $_POST['email'], $_POST['tipo_doc_juridico']);
                echo "<script>alert('Cliente actualizado exitosamente');</script>";
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;


        
    case 'editarNatural':

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_cliente']) && !empty($_POST['cedula']) && !empty($_POST['razon_social']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_doc_natural'])) {

                $resultado = $cliente->editDatosCliente($_POST['cod_cliente'], $_POST['cedula'], $_POST['razon_social'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['tipo_doc_natural']);
                echo "<script>alert('Cliente actualizado exitosamente');</script>";
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
}

$registros = $cliente->obt_RegistrosClientes();

include 'app/view/layout/header.php';
include 'app/view/cliente/clienteView.php';
include 'app/view/layout/footer.php';
