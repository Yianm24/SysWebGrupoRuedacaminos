<?php

namespace App\Traits;

use App\Model\Cliente;


trait EnvioTrait
{


    public function extraerDatosParticipante(string $tipo_persona, string $tipoCliente, string $abrev): int
    {

        $instanciaForaneas = [
            'cliente' => new Cliente
        ];


        $tipoPersona = $_POST["{$tipo_persona}"];

        $doc_identidad  = '';
        $tipo_documento = '';
        $razon_social   = '';

        switch ($tipoPersona) {
            case "{$tipoCliente}_natural":
                $doc_identidad  = $_POST["{$abrev}_cedula"] ?? '';
                $tipo_documento = $_POST["{$abrev}_documento_natural"] ?? '';
                $razon_social   = $_POST["{$abrev}_nombre"] ?? '';
                break;

            case "{$tipoCliente}_juridico":
                $doc_identidad  = $_POST["{$abrev}_rif"] ?? '';
                $tipo_documento = $_POST["{$abrev}_documento_juridico"] ?? '';
                $razon_social   = $_POST["{$abrev}_razon_social"] ?? '';
                break;
        }

        // Retornamos un arreglo limpio con toda la información lista
        $cliente = [
            'doc_identidad'  => trim($doc_identidad),
            'tipo_documento' => $tipo_documento,
            'razon_social'   => trim($razon_social),
            'apellido'       => $datosPost["{$abrev}_apellido"] ?? null,
            'telefono'       => $datosPost["{$abrev}_telefono"] ?? '',
            'correo'         => $datosPost["{$abrev}_correo"] ?? ''
        ];

        $keyCliente = null;

        if ($this->verificarClienteExiste($cliente['doc_identidad'])) {

            $keyCliente = $this->obtenerIdClientePorDocumento($cliente['doc_identidad']);
        } else {

            $instanciaForaneas['cliente']->regDatosCliente($cliente['doc_identidad'], $cliente['razon_social'], $cliente['apellido'], $cliente['telefono'], $cliente['email'], $cliente['tipo_documento']);
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
