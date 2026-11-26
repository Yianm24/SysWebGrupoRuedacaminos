<?php
$enviosAgendados = $datosDashboard['envios_agendados'] ?? 0;
$ingresosMes = $datosDashboard['ingresos_mes'] ?? 0.00;
$vehiculosEnRuta = $datosDashboard['vehiculos_en_ruta'] ?? 0;
$clientesActivos = $datosDashboard['clientes_activos'] ?? 0;
$ultimosEnvios = $datosDashboard['ultimos_envios'] ?? [];
$totalVehiculos = $datosDashboard['total_vehiculos'] ?? 0;
$despachosPendientes = $datosDashboard['despachos_pendientes'] ?? 0;
?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold text-primary">Dashboard Resumen</h2>
        <p class="text-muted">Bienvenido al sistema Grupo RuedaCaminos C.A. Aquí tienes un vistazo general de las operaciones.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold mb-2">Envíos Agendados</h6>
                        <h2 class="mb-0"><?= (int) $enviosAgendados ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-box-seam fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-white border-opacity-25 text-end">
                <a href="?url=envio" class="text-white text-decoration-none small">Ver detalles <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold mb-2">Ingresos Mes</h6>
                        <h2 class="mb-0">$<?= number_format((float) $ingresosMes, 2, '.', ',') ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-wallet2 fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-white border-opacity-25 text-end">
                <a href="?url=pago" class="text-white text-decoration-none small">Ver detalles <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-dark h-100 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold mb-2">Vehículos en Ruta</h6>
                        <h2 class="mb-0"><?= (int) $vehiculosEnRuta ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-truck fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-dark border-opacity-25 text-end">
                <a href="?url=despacho" class="text-dark text-decoration-none small">Ver detalles <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white h-100 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold mb-2">Clientes Activos</h6>
                        <h2 class="mb-0"><?= (int) $clientesActivos ?></h2>
                    </div>
                    <div>
                        <i class="bi bi-people-fill fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-white border-opacity-25 text-end">
                <a href="?url=cliente" class="text-white text-decoration-none small">Ver detalles <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-activity text-primary me-2"></i>Últimos Envíos Registrados</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th># Tracking</th>
                                <th>Cliente</th>
                                <th>Destino</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ultimosEnvios)): ?>
                                <?php foreach ($ultimosEnvios as $envio): ?>
                                    <?php
                                    $nombreCliente = trim(($envio['razon_social'] ?? '') . ' ' . ($envio['apellido'] ?? ''));
                                    if ($nombreCliente === '') {
                                        $nombreCliente = 'Sin cliente asignado';
                                    }
                                    $codigoEnvio = 'ENV-' . str_pad((string) $envio['cod_envio'], 5, '0', STR_PAD_LEFT);
                                    ?>
                                    <tr>
                                        <td><span class="fw-bold text-primary"><?= htmlspecialchars($codigoEnvio, ENT_QUOTES, 'UTF-8') ?></span></td>
                                        <td><?= htmlspecialchars($nombreCliente, ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars((string) $envio['destino'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>$<?= number_format((float) $envio['monto_total'], 2, '.', ',') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No hay envíos registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-wrench-adjustable text-warning me-2"></i>Alertas de Flota</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning border-start border-warning border-4 mb-3" role="alert">
                    <div class="d-flex">
                        <i class="bi bi-truck fs-4 me-3"></i>
                        <div>
                            <h6 class="alert-heading fw-bold mb-1">Flota Operativa: <?= (int) $totalVehiculos ?></h6>
                            <p class="mb-0 small">Vehículos en ruta actualmente: <?= (int) $vehiculosEnRuta ?>.</p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info border-start border-info border-4 mb-0" role="alert">
                    <div class="d-flex">
                        <i class="bi bi-boxes fs-4 me-3"></i>
                        <div>
                            <h6 class="alert-heading fw-bold mb-1">Despachos Pendientes: <?= (int) $despachosPendientes ?></h6>
                            <p class="mb-0 small">Control de salidas y asignaciones de flota en tiempo real.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
