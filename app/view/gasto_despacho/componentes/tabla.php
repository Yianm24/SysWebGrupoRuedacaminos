<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4 text-center">CÓD. DESPACHO</th>
                    <th class="text-center">DESCRIPCIÓN</th>
                    <th class="text-center">MONTO</th>
                    <th class="text-start pe-4">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?>
                <tr>
                    <td class="ps-4 text-center fw-bold text-secondary">aqui ba el codigo despacho</td>
                    <td class="text-center text-secondary"><?= $dato['descripcion'] ?></td>
                    <td class="text-center fw-bold text-success">$<?= number_format($dato['monto'], 2) ?></td>
                    <td class="text-start pe-4">
                        <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalGastoDespacho"
                            datos-cod-gasto-despacho="<?= $dato['cod_gasto_despacho'] ?>"
                            datos-cod-despacho="aqui ba el codigo despacho"
                            datos-descripcion="<?= $dato['descripcion'] ?>"
                            datos-monto="<?= $dato['monto'] ?>"
                            datos-estado="<?= $dato['estado'] ?>"
                            >
                            <i class="bi bi-pencil"></i>
                        </button>
                        <a href="#" class="text-secondary btn-eliminar"
                            datos-cod-gasto-despacho="<?= $dato['cod_gasto_despacho'] ?>">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>