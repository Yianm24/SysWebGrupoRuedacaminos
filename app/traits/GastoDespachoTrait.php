<?php

namespace App\Traits;

trait GastoDespachoTrait
{
    public function normalizarGasto(array $datos): array
    {
        $codDespacho = isset($datos['cod_despacho']) ? (int) $datos['cod_despacho'] : 0;
        $descripcion = isset($datos['descripcion']) ? strtoupper(trim((string) $datos['descripcion'])) : '';
        $montoRaw = isset($datos['monto']) ? str_replace(',', '.', trim((string) $datos['monto'])) : '0';
        $monto = is_numeric($montoRaw) ? round((float) $montoRaw, 2) : -1;

        return [
            'cod_despacho' => $codDespacho,
            'descripcion'  => $descripcion,
            'monto'        => $monto,
        ];
    }

    public function gastoValido(array $gasto): bool
    {
        if (($gasto['cod_despacho'] ?? 0) <= 0) {
            return false;
        }

        if (($gasto['descripcion'] ?? '') === '' || mb_strlen($gasto['descripcion']) > 70) {
            return false;
        }

        if (!isset($gasto['monto']) || $gasto['monto'] <= 0 || $gasto['monto'] > 9999.99) {
            return false;
        }

        return true;
    }
}