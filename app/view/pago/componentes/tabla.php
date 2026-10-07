<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">CÓDIGO ENVÍO</th>
                    <th class="text-center">ESTADO</th>
                    <th>MONTO TOTAL</th>
                    <th>ÚLTIMO ABONO</th>
                    <th>MONTO RESTANTE</th>
                    <th class="text-center">AÑADIR PAGO</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($registros)): ?>
                    <?php foreach ($registros as $value): 
                        $montoRestante = $value['monto_total'] - $value['monto_abonado'];
                    ?>
                        <tr>
                            <td class="ps-4 fw-medium"><?= $value['cod_envio']; ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?= ($value['estado_pago'] == 1) ? 'success' : 'warning'; ?>">
                                    <?= ($value['estado_pago'] == 1) ? 'Completado' : 'Pendiente'; ?>
                                </span>
                            </td>
                            <td class="text-secondary">$<?= number_format($value['monto_total'], 2); ?></td>
                            <td class="text-secondary">$<?= number_format($value['monto_abonado'], 2); ?></td>
                            <td class="text-secondary">$<?= number_format(max(0, $montoRestante), 2); ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#registerPago"
                                    data-envio="<?= $value['cod_envio']; ?>">
                                    <i class="bi bi-wallet2 me-1"></i> Registrar
                                </button>
                            </td>
                            <td class="pe-4 text-center">
                                <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"
                                    data-bs-toggle="modal" data-bs-target="#modalEditarPago"
                                    data-id="<?= $value['cod_pago']; ?>"
                                    data-monto="<?= $value['monto_abonado']; ?>"
                                    data-referencia="<?= $value['referencia']; ?>"
                                    data-estatus="<?= $value['estado_pago']; ?>"
                                    data-metodo="<?= $value['cod_metodopago'] ?? ''; ?>"
                                    data-banco="<?= $value['cod_banco'] ?? ''; ?>"
                                    data-detalle="<?= $value['cod_detallepago']; ?>">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="#" class="text-secondary text-decoration-none btn-eliminar" title="Eliminar"
                                    data-id="<?= $value['cod_pago']; ?>">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No hay pagos registrados actualmente.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>