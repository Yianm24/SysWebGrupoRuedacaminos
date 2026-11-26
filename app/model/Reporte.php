<?php

namespace App\Model;

use Dompdf\Dompdf;
use Dompdf\Options;

class Reporte
{
    private $objDompdf;

    public function __construct()
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $this->objDompdf = new Dompdf($options);
    }

    public function ConstruirHtml($modulo, array $datos)
    {
        $html = '';
        $nombreDoc = 'Reporte';
        $fecha = date('d/m/Y H:i');

        switch ($modulo) {
            case 'envio':
                $html = "
                <!DOCTYPE html>
                <html lang='es'>
                <head>
                    <meta charset='UTF-8'>
                    <style>
                        body { font-family: Helvetica, Arial, sans-serif; color: #1e293b; margin: 30px; }
                        header { border-bottom: 2px solid #4f46e5; padding-bottom: 12px; margin-bottom: 20px; }
                        h1 { color: #4f46e5; font-size: 20px; margin: 0; }
                        .fecha { font-size: 11px; color: #64748b; margin-top: 4px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
                        th, td { border: 1px solid #cbd5e1; padding: 10px; text-align: left; }
                        th { background-color: #f1f5f9; color: #0f172a; font-weight: bold; }
                        tr:nth-child(even) { background-color: #f8fafc; }
                    </style>
                </head>
                <body>
                    <header>
                        <h1>Envios</h1>
                        <div class='fecha'>Reporte generado el: {$fecha}</div>
                    </header>
                    <main>
                        <table>
                            <thead>
                                <tr>
                                    <th>CODIGO</th>
                                    <th>REMITENTE</th>
                                    <th>DESTINATARIO</th>
                                    <th>DESTINO</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>PESO TOTAL</th>
                                    <th>STATUS</th>
                                    <th>FECHA</th>
                                </tr>
                            </thead>
                            <tbody>";

                foreach ($datos as $item) {
                    $html .= "<tr>
                        <td>" . htmlspecialchars((string) ($item['cod_envio'] ?? ''), ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars((string) ($item['rem_nombre'] ?? ''), ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars((string) ($item['rem_apellido'] ?? ''), ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars((string) ($item['dest_nombre'] ?? ''), ENT_QUOTES, 'UTF-8') . " - " . htmlspecialchars((string) ($item['dest_apellido'] ?? ''), ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars((string) ($item['direccion_destino'] ?? ''), ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars((string) ($item['descrip_contenido'] ?? ''), ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars((string) ($item['peso_total'] ?? ''), ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars((string) ($item['estatus'] ?? ''), ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars((string) ($item['fecha'] ?? ''), ENT_QUOTES, 'UTF-8') . "</td>
                    </tr>";
                }

                $html .= "</tbody>
                        </table>
                    </main>
                </body>
                </html>";
                $nombreDoc = "EnvioReporte";
                break;

            case 'pago':
                $registros = isset($datos['registros']) && is_array($datos['registros']) ? $datos['registros'] : $datos;
                $periodoTexto = htmlspecialchars((string) ($datos['periodo_texto'] ?? 'General'), ENT_QUOTES, 'UTF-8');
                $tasaUsd = (float) ($datos['tasa_usd'] ?? 0.0);

                $totalUsd = 0.0;
                $totalBs = 0.0;
                $subtotalUsdOriginal = 0.0;
                $subtotalBsOriginal = 0.0;

                $filasHtml = '';
                foreach ($registros as $fila) {
                    if (!is_array($fila)) {
                        continue;
                    }

                    $montoPago = (float) ($fila['monto'] ?? 0);
                    $montoDetalle = isset($fila['monto_detalle']) && $fila['monto_detalle'] !== null
                        ? (float) $fila['monto_detalle']
                        : $montoPago;
                    $codMoneda = (int) ($fila['cod_moneda'] ?? 0);
                    $abreviatura = strtoupper(trim((string) ($fila['moneda'] ?? '')));

                    if ($codMoneda === 1 || $abreviatura === 'USD') {
                        // Pago en dólares
                        $montoMostrar = $montoPago;
                        $monedaMostrar = 'USD';
                        $subtotalUsdOriginal += $montoMostrar;
                        $totalUsd += $montoMostrar;
                        if ($tasaUsd > 0) {
                            $totalBs += ($montoMostrar * $tasaUsd);
                        }
                    } elseif ($codMoneda === 2 || $abreviatura === 'VES' || $abreviatura === 'BS') {
                        // Pago en bolívares: si monto_detalle es mayor que monto_pago, usamos monto_detalle como Bs.
                        $montoBsFila = ($montoDetalle > $montoPago && $montoDetalle > 0)
                            ? $montoDetalle
                            : ($tasaUsd > 0 ? ($montoPago * $tasaUsd) : $montoPago);

                        $montoMostrar = $montoBsFila;
                        $monedaMostrar = 'VES';
                        $subtotalBsOriginal += $montoMostrar;
                        $totalBs += $montoMostrar;
                        if ($tasaUsd > 0) {
                            $totalUsd += ($montoMostrar / $tasaUsd);
                        }
                    } else {
                        // Otras monedas: se toma p.monto como equivalente base
                        $montoMostrar = $montoPago;
                        $monedaMostrar = $abreviatura !== '' ? $abreviatura : 'OTRA';
                        $totalUsd += $montoMostrar;
                        if ($tasaUsd > 0) {
                            $totalBs += ($montoMostrar * $tasaUsd);
                        }
                    }

                    $codPago = htmlspecialchars((string) ($fila['cod_pago'] ?? ''), ENT_QUOTES, 'UTF-8');
                    $codEnvio = htmlspecialchars((string) ($fila['cod_envio'] ?? ''), ENT_QUOTES, 'UTF-8');
                    $fechaPago = htmlspecialchars((string) ($fila['fecha'] ?? ''), ENT_QUOTES, 'UTF-8');
                    $referencia = htmlspecialchars((string) ($fila['referencia'] ?? 'N/A'), ENT_QUOTES, 'UTF-8');
                    $metodo = htmlspecialchars((string) ($fila['metodo_pago'] ?? 'No especificado'), ENT_QUOTES, 'UTF-8');
                    $monedaEsc = htmlspecialchars($monedaMostrar, ENT_QUOTES, 'UTF-8');
                    $montoFormateado = number_format($montoMostrar, 2, '.', ',');

                    $filasHtml .= "<tr>
                        <td>{$codPago}</td>
                        <td>{$codEnvio}</td>
                        <td>{$fechaPago}</td>
                        <td>{$metodo}</td>
                        <td>{$referencia}</td>
                        <td style='text-align: right;'>{$monedaEsc} {$montoFormateado}</td>
                    </tr>";
                }

                if ($filasHtml === '') {
                    $filasHtml = "<tr><td colspan='6' style='text-align: center;'>No se registraron ingresos en el período seleccionado.</td></tr>";
                }

                $totalUsdFormateado = number_format($totalUsd, 2, '.', ',');
                $totalBsFormateado = number_format($totalBs, 2, '.', ',');
                $subUsdFormateado = number_format($subtotalUsdOriginal, 2, '.', ',');
                $subBsFormateado = number_format($subtotalBsOriginal, 2, '.', ',');
                $tasaUsdFormateada = $tasaUsd > 0 ? number_format($tasaUsd, 2, '.', ',') : 'No registrada';

                $html = "
                <!DOCTYPE html>
                <html lang='es'>
                <head>
                    <meta charset='UTF-8'>
                    <style>
                        body { font-family: Helvetica, Arial, sans-serif; color: #1e293b; margin: 30px; }
                        header { border-bottom: 2px solid #16a34a; padding-bottom: 12px; margin-bottom: 20px; }
                        h1 { color: #15803d; font-size: 20px; margin: 0; }
                        .meta { font-size: 11px; color: #64748b; margin-top: 4px; }
                        .resumen { background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 12px; margin-bottom: 16px; font-size: 12px; line-height: 1.5; }
                        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
                        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
                        th { background-color: #f1f5f9; color: #0f172a; font-weight: bold; }
                        tr:nth-child(even) { background-color: #f8fafc; }
                        tfoot td { font-weight: bold; background-color: #f1f5f9; }
                    </style>
                </head>
                <body>
                    <header>
                        <h1>Reporte de Ingresos Obtenidos</h1>
                        <div class='meta'>Filtro: {$periodoTexto} | Tasa USD: {$tasaUsdFormateada} Bs. | Generado el: {$fecha}</div>
                    </header>
                    <main>
                        <div class='resumen'>
                            <div><strong>Cobrado en su moneda:</strong> USD \${$subUsdFormateado} &nbsp;|&nbsp; Bs. {$subBsFormateado}</div>
                            <div><strong>Total General Equivalente:</strong> USD \${$totalUsdFormateado} &nbsp;|&nbsp; <strong>Bs. {$totalBsFormateado}</strong></div>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>COD. PAGO</th>
                                    <th>COD. ENVÍO</th>
                                    <th>FECHA</th>
                                    <th>MÉTODO PAGO</th>
                                    <th>REFERENCIA</th>
                                    <th style='text-align: right;'>MONTO</th>
                                </tr>
                            </thead>
                            <tbody>
                                {$filasHtml}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan='5' style='text-align: right;'>TOTAL GENERAL (USD / BS.):</td>
                                    <td style='text-align: right;'>\${$totalUsdFormateado} / Bs. {$totalBsFormateado}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </main>
                </body>
                </html>";
                $nombreDoc = "IngresosReporte";
                break;
        }

        return $this->GenerarReporte($html, $nombreDoc);
    }

    private function GenerarReporte($html, string $nombreDoc)
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $nombreArchivo = preg_replace('/\.pdf$/i', '', $nombreDoc) . '.pdf';

        $this->objDompdf->loadHtml($html);
        $this->objDompdf->setPaper('A4', 'landscape');
        $this->objDompdf->render();
        $this->objDompdf->stream($nombreArchivo, ['Attachment' => false]);
        exit();
    }
}