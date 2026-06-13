<?php

namespace App\Controller;

use App\Model\Cliente;

$cliente = new Cliente();



$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {

    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cod_identidad']) && !empty($_POST['razon_social']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty('tipo_documento')) {

                $resultado = $vehiculo->regDatosCliente($_POST['doc_documento'], $_POST['razon_social'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['tipo_documento']);

                echo "<script>alert('Datos registrados correctamente');</script>";
            } else {
                echo "<script>alert('Falta uno o varios datos por ingresar');</script>";
            }
        }
        break;
}

//   $insert->bindValue(1, $this->doc_identidad);
//             $insert->bindValue(2, $this->razon_social);
//             $insert->bindValue(3, $this->apellido);
//             $insert->bindValue(4, $this->telefono);
//             $insert->bindValue(5, $this->email);
//             $insert->bindValue(6, $this->tipo_documento);

$registros = $cliente->obt_RegistrosClientes();
include 'app/view/layout/header.php';
include 'app/view/cliente/clienteView.php';
include 'app/view/layout/footer.php';
