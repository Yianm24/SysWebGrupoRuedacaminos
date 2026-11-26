<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4 text-center">CÓD. DESPACHO</th>
                    <th class="text-start">DESCRIPCIÓN</th>
                    <th class="text-end">MONTO</th>
                    <th class="text-center pe-4">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?>
                <?php $sinDespacho = ($dato['despacho_texto'] === 'no se encontro despacho asociado'); ?>
                <tr>
                    <td class="ps-4 text-center fw-bold <?= $sinDespacho ? 'text-danger' : 'text-secondary' ?>">
                        <?= $sinDespacho ? '' : 'DCH-' ?><?= htmlspecialchars($dato['despacho_texto']) ?>
                    </td>
                    <td class="text-start fw-bold text-secondary"><?= htmlspecialchars($dato['descripcion']) ?></td>
                    <td class="text-end fw-bold text-secondary"><?= number_format((float)$dato['monto'], 2, '.', ',') ?></td>
                    <td class="text-center pe-4">
                        <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar"
                            data-bs-toggle="modal"
                            data-bs-target="#modalGastoDespacho"
                            datos-cod-gasto="<?= htmlspecialchars($dato['cod_gasto_despacho']) ?>"
                            datos-cod-despacho="<?= htmlspecialchars($dato['cod_despacho']) ?>"
                            datos-descripcion="<?= htmlspecialchars($dato['descripcion']) ?>"
                            datos-monto="<?= htmlspecialchars($dato['monto']) ?>"
                            datos-estado="<?= htmlspecialchars($dato['estado']) ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <a href="#" class="text-secondary btn-eliminar ms-2"
                            title="Eliminar"
                            datos-cod-gasto="<?= htmlspecialchars($dato['cod_gasto_despacho']) ?>">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>