<?php

namespace App\Controller;

use App\Model\Reporte;
use App\Model\Envio;
use App\Config\Conexion;
use PDO;

if (!class_exists(__NAMESPACE__ . '\\ConexionReporte')) {
    class ConexionReporte extends Conexion
    {
        public function getDb(): PDO
        {
            return $this->getConnection();
        }
    }
}

$solicitud = $_POST['tipoSolicitud'] ?? '';
$objEnvio = new Envio();
$objReporte = new Reporte();

switch ($solicitud) {
    case 'envios':
        $registros = json_decode($objEnvio->obt_RegistrosEnvio(), true);
        $objReporte->ConstruirHtml('envio', is_array($registros) ? $registros : []);
        exit();

    case 'ingresos':
        $periodo = $_POST['periodo'] ?? 'mes';
        $hoy = date('Y-m-d');

        if ($periodo === 'semana') {
            $fechaInicio = date('Y-m-d', strtotime('monday this week', strtotime($hoy)));
            $fechaFin = date('Y-m-d', strtotime('sunday this week', strtotime($hoy)));
            $etiquetaPeriodo = "Semanal ({$fechaInicio} al {$fechaFin})";
        } elseif ($periodo === 'personalizado' && !empty($_POST['fecha_inicio']) && !empty($_POST['fecha_fin'])) {
            $fechaInicio = $_POST['fecha_inicio'];
            $fechaFin = $_POST['fecha_fin'];
            if ($fechaInicio > $fechaFin) {
                [$fechaInicio, $fechaFin] = [$fechaFin, $fechaInicio];
            }
            $etiquetaPeriodo = "Personalizado ({$fechaInicio} al {$fechaFin})";
        } else {
            $fechaInicio = date('Y-m-01', strtotime($hoy));
            $fechaFin = date('Y-m-t', strtotime($hoy));
            $etiquetaPeriodo = "Mensual ({$fechaInicio} al {$fechaFin})";
        }

        $conexionReporte = new ConexionReporte();
        $db = $conexionReporte->getDb();

        // Última tasa activa por moneda en cambio_moneda
        $sqlTasas = "SELECT cm.cod_moneda, cm.tasa, cm.fecha
                     FROM cambio_moneda cm
                     INNER JOIN (
                         SELECT cod_moneda, MAX(cod_cambio) AS max_id
                         FROM cambio_moneda
                         WHERE estado = 1
                         GROUP BY cod_moneda
                     ) ult ON cm.cod_cambio = ult.max_id";
        $stmtTasas = $db->query($sqlTasas);
        $tasasPorMoneda = [];
        foreach ($stmtTasas->fetchAll(PDO::FETCH_ASSOC) as $rowTasa) {
            $tasasPorMoneda[(int) $rowTasa['cod_moneda']] = [
                'tasa' => (float) $rowTasa['tasa'],
                'fecha' => $rowTasa['fecha'],
            ];
        }

        $tasaUsd = $tasasPorMoneda[1]['tasa'] ?? 0.0;

        $sql = "SELECT
                    p.cod_pago,
                    p.fecha,
                    p.hora,
                    p.monto,
                    dp.monto AS monto_detalle,
                    p.referencia,
                    p.estado_pago,
                    p.cod_envio,
                    mp.nombre AS metodo_pago,
                    mp.cod_moneda,
                    m.abreviatura AS moneda
                FROM pago p
                LEFT JOIN detalle_pago dp ON p.cod_detallepago = dp.cod_detallepago
                LEFT JOIN metodo_pago mp ON dp.cod_metodopago = mp.cod_metodo
                LEFT JOIN moneda m ON mp.cod_moneda = m.cod_moneda
                WHERE p.estado = 1
                AND p.estado_pago = 1
                AND p.fecha BETWEEN :fecha_inicio AND :fecha_fin
                ORDER BY p.fecha DESC, p.cod_pago DESC";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':fecha_inicio', $fechaInicio);
        $stmt->bindValue(':fecha_fin', $fechaFin);
        $stmt->execute();
        $registrosIngresos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $objReporte->ConstruirHtml('pago', [
            'registros' => $registrosIngresos,
            'periodo_texto' => $etiquetaPeriodo,
            'tasa_usd' => $tasaUsd,
            'tasas_por_moneda' => $tasasPorMoneda,
        ]);
        exit();
}

include 'app/view/layout/header.php';
include 'app/view/reporte/reporteView.php';
include 'app/view/layout/footer.php';