<?php

namespace App\Controller;

use App\Model\Cliente;

$cliente = new Cliente();



$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {

    case 'registrar':

<<<<<<< HEAD
        
        $tipoPersona = $_POST['tipo_persona_remitente'] ?? '';
        switch ($tipoPersona) {
            case 'remitente_natural':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!empty($_POST['cedula']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_doc_natural'])) {

                        $resultado = $cliente->regDatosCliente($_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['tipo_doc_natural']);
                        
=======

        $tipoPersona = $_POST['tipo_persona_remitente'] ?? '';
        switch ($tipoPersona) {
            case 'remitente_natural':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!empty($_POST['cedula']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_doc_natural'])) {

                        $resultado = $cliente->regDatosCliente($_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['tipo_doc_natural']);
                        echo "<script>alert('ta tod chido');</script>";
>>>>>>> dfe0de8ef2e593da69e581107a1e0c8bd60499e0
                    } else {
                        echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                    }
                }
                break;
            case 'remitente_juridico':
<<<<<<< HEAD
                // Lógica para cliente jurídico

                //$resultado = $cliente->regDatosCliente($_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['tipo_doc_natural']);

                echo "<script>alert('Cliente jurídico registrado correctamente');</script>";
                break;
            
        }
    
    break;

        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     if (!empty($_POST['doc_documento']) && !empty($_POST['razon_social']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_documento'])) {

        //         $resultado = $$cliente->regDatosCliente($_POST['doc_documento'], $_POST['razon_social'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['tipo_documento']);

        //         echo "<script>alert('Registro de datos de cliente exitoso');</script>";
        //     } else {
        //         echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
        //     }
        // }

=======
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!empty($_POST['rif']) && !empty($_POST['razon_social'])  && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_doc_natural'])) {

                        $resultado = $cliente->regDatosCliente($_POST['rif'], $_POST['razon_social'], null, $_POST['telefono'], $_POST['email'], $_POST['tipo_doc_juridico']);
                        echo "<script>alert('ta mediocre');</script>";
                    } else {
                        echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                    }
                }
                break;
        }

        break;

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     if (!empty($_POST['doc_documento']) && !empty($_POST['razon_social']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_documento'])) {

    //         $resultado = $$cliente->regDatosCliente($_POST['doc_documento'], $_POST['razon_social'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['tipo_documento']);

    //         echo "<script>alert('Registro de datos de cliente exitoso');</script>";
    //     } else {
    //         echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
    //     }
    // }
>>>>>>> dfe0de8ef2e593da69e581107a1e0c8bd60499e0


    case 'eliminar':
        if (isset($_POST['cod_cliente'])) {
            $resultado = $cliente->elmDatosCliente($_POST['cod_cliente']);
            echo "<script>alert('Cliente eliminado correctamente');</script>";
        }
        break;
<<<<<<< HEAD
=======


    case 'editar':
        $tipoPersona = $_POST['tipo_persona_remitente'] ?? '';
        switch ($tipoPersona) {
            case 'remitente_natural':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!empty($_POST['cod_cliente']) && !empty($_POST['cedula']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_doc_natural'])) {

                        $resultado = $cliente->editDatosCliente($_POST['cod_cliente'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['tipo_doc_natural']);
                        echo "<script>alert('ta tod chido');</script>";
                    } else {
                        echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                    }
                }
                break;
            case 'remitente_juridico':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (!empty($_POST['cod_cliente']) && !empty($_POST['rif']) && !empty($_POST['razon_social'])  && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['tipo_doc_natural'])) {

                        $resultado = $cliente->editDatosCliente($_POST['cod_cliente'], $_POST['rif'], $_POST['razon_social'], null, $_POST['telefono'], $_POST['email'], $_POST['tipo_doc_juridico']);
                        echo "<script>alert('ta mediocre');</script>";
                    } else {
                        echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
                    }
                }
                break;
        }
        break;
>>>>>>> dfe0de8ef2e593da69e581107a1e0c8bd60499e0
}

$registros = $cliente->obt_RegistrosClientes();

include 'app/view/layout/header.php';
include 'app/view/cliente/clienteView.php';
include 'app/view/layout/footer.php';
