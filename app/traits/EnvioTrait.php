<?php

namespace App\Traits;

use App\Model\Cliente;


trait EnvioTrait
{


    public function extraerDatosParticipante(array $datosCliente): int
    {

        $instanciaForaneas = [
            'cliente' => new Cliente
        ];


        // $tipoPersona = $_POST["{$tipo_persona}"];

        // $doc_identidad  = '';
        // $tipo_documento = '';
        // $razon_social   = '';

        // switch ($tipoPersona) {
        //     case "{$tipoCliente}_natural":
        //         $doc_identidad  = $_POST["{$abrev}_cedula"] ?? '';
        //         $tipo_documento = $_POST["{$abrev}_documento_natural"] ?? '';
        //         $razon_social   = $_POST["{$abrev}_nombre"] ?? '';
        //         break;

        //     case "{$tipoCliente}_juridico":
        //         $doc_identidad  = $_POST["{$abrev}_rif"] ?? '';
        //         $tipo_documento = $_POST["{$abrev}_documento_juridico"] ?? '';
        //         $razon_social   = $_POST["{$abrev}_razon_social"] ?? '';
        //         break;
        // }

        // Retornamos un arreglo limpio con toda la información lista
        $cliente = [];
        $tipoCliente = '';
        if($datosCliente['tipo_document'] == 'V'|| $datosCliente['tipo_document'] == 'E' ){
            $cliente = [
                'doc_identidad'  => trim($datosCliente['cedula']),
                'tipo_documento' => $datosCliente['tipo_document'] ?? 'Error' ,
                'razon_social'   => trim($datosCliente['nombre']),
                'apellido'       => $datosCliente['apellido'] ?? 'Error',
                'telefono'       => $datosCliente['telefono'] ?? 'Error',
                'correo'         => $datosCliente["correo"] ?? 'Error'

            ];

            $tipoCliente = 'natural';

        }else if($datosCliente['tipo_document'] == 'J'|| $datosCliente['tipo_document'] == 'G' ){
            $cliente = [
                'doc_identidad'  => trim($datosCliente['rif']),
                'tipo_documento' => $datosCliente['tipo_document'] ?? 'Error' ,
                'razon_social'   => trim($datosCliente['razon_social']),
                'telefono'       => $datosCliente['telefono'] ?? 'Error',
                'correo'         => $datosC["correo"] ?? 'Error'

            ];

         $tipoCliente = 'juridico';
        }
        
        
        
       /*  $cliente = [
            'doc_identidad'  => trim($datosCliente),
            'tipo_documento' => $tipo_documento,
            'razon_social'   => trim($razon_social),
            'apellido'       => $datosCliente["{$abrev}_apellido"] ?? null,
            'telefono'       => $datosPost["{$abrev}_telefono"] ?? '',
            'correo'         => $datosPost["{$abrev}_correo"] ?? ''
        ]; */

        $keyCliente = null;

        if ($this->verificarClienteExiste($cliente['doc_identidad'])) {

            $keyCliente = $this->obtenerIdClientePorDocumento($cliente['doc_identidad']);
        } else {


                if ($tipoCliente === 'natural') {
                    $instanciaForaneas['cliente']->regDatosCliente($cliente['doc_identidad'], $cliente['razon_social'], $cliente['apellido'], $cliente['telefono'], $cliente['correo'], $cliente['tipo_documento']);
                } else if ($tipoCliente === 'juridico') {
                    $instanciaForaneas['cliente']->regDatosCliente($cliente['doc_identidad'], $cliente['razon_social'], " ", $cliente['telefono'], $cliente['correo'], $cliente['tipo_documento']);
                }
           // $instanciaForaneas['cliente']->regDatosCliente($cliente['doc_identidad'], $cliente['razon_social'], $cliente['apellido'], $cliente['telefono'], $cliente['correo'], $cliente['tipo_documento']);
            $keyCliente = $this->obtenerIdClientePorDocumento($cliente['doc_identidad']);
        }

        return $keyCliente;
    }

    public function verificarClienteExiste(string $doc_identidad): bool
    {
        $sentencia = "SELECT COUNT(*) FROM cliente WHERE doc_identidad = ? AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $doc_identidad);
        $count->execute();

        return $count->fetchColumn() > 0;
    }


    public function obtenerIdClientePorDocumento(string $doc_identidad): ?int
    {
        $sentencia = "SELECT cod_cliente FROM cliente WHERE doc_identidad = ? AND estado = 1 LIMIT 1";
        $stmt = $this->conexion->prepare($sentencia);
        $stmt->execute([$doc_identidad]);
        $resultado = $stmt->fetchColumn();

        return $resultado ? (int) $resultado : null;
    }
}