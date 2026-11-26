<?php

namespace App\Controller;

use App\Config\Conexion;
use PDO;
use PDOException;

class ConexionDashboard extends Conexion
{
    public function db(): PDO
    {
        return $this->getConnection();
    }
}

$datosDashboard = [
    'envios_agendados' => 0,
    'ingresos_mes' => 0.00,
    'vehiculos_en_ruta' => 0,
    'clientes_activos' => 0,
    'ultimos_envios' => [],
    'total_vehiculos' => 0,
    'despachos_pendientes' => 0,
];

try {
    $conexionDash = new ConexionDashboard();
    $db = $conexionDash->db();

    $sqlEnvios = "SELECT COUNT(*) FROM envio WHERE estado = 1 AND estatus = 'PENDIENTE'";
    $datosDashboard['envios_agendados'] = (int) $db->query($sqlEnvios)->fetchColumn();

    $sqlIngresos = "SELECT COALESCE(SUM(monto), 0)
                    FROM pago
                    WHERE estado = 1
                    AND estado_pago = 1
                    AND MONTH(fecha) = MONTH(CURDATE())
                    AND YEAR(fecha) = YEAR(CURDATE())";
    $datosDashboard['ingresos_mes'] = (float) $db->query($sqlIngresos)->fetchColumn();

    $sqlVehiculosRuta = "SELECT COUNT(DISTINCT cod_vehiculo)
                        FROM despacho
                        WHERE estado = 1 AND estatus = 'EN DESPACHO'";
    $datosDashboard['vehiculos_en_ruta'] = (int) $db->query($sqlVehiculosRuta)->fetchColumn();

    $sqlClientes = "SELECT COUNT(*) FROM cliente WHERE estado = 1";
    $datosDashboard['clientes_activos'] = (int) $db->query($sqlClientes)->fetchColumn();

    $sqlTotalVehiculos = "SELECT COUNT(*) FROM vehiculo WHERE estado = 1";
    $datosDashboard['total_vehiculos'] = (int) $db->query($sqlTotalVehiculos)->fetchColumn();

    $sqlDespachosPendientes = "SELECT COUNT(*) FROM despacho WHERE estado = 1 AND estatus = 'PENDIENTE'";
    $datosDashboard['despachos_pendientes'] = (int) $db->query($sqlDespachosPendientes)->fetchColumn();

    $sqlUltimos = "SELECT
                        e.cod_envio,
                        e.monto_total,
                        e.estatus,
                        e.fecha,
                        c.razon_social,
                        c.apellido,
                        COALESCE(m.nombre, u.descripcion, 'No especificado') AS destino
                    FROM envio e
                    LEFT JOIN participante_envio pe
                        ON e.cod_envio = pe.cod_envio AND pe.rol_cliente = 'Destinatario'
                    LEFT JOIN cliente c
                        ON pe.cod_cliente = c.cod_cliente
                    LEFT JOIN ubicaciones_envio ue
                        ON e.cod_envio = ue.cod_envio AND ue.tipo_ubicacion = 'Destino'
                    LEFT JOIN ubicacion u
                        ON ue.cod_ubicacion = u.cod_ubicacion
                    LEFT JOIN municipio m
                        ON u.cod_municipio = m.cod_municipio
                    WHERE e.estado = 1
                    ORDER BY e.cod_envio DESC
                    LIMIT 5";
    $datosDashboard['ultimos_envios'] = $db->query($sqlUltimos)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
}

include 'app/view/layout/header.php';
include 'app/view/dashboard/indexView.php';
include 'app/view/layout/footer.php';