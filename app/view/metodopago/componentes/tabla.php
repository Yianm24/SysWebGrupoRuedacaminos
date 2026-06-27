<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">NOMBRE DEL MÉTODO</th>
                    <th class="ps-4">MONEDA AFILIADA</th>
                    <th class="text-end pe-4">ACCIONES</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-medium text-secondary"><?= $dato['nombre']; ?></td>
                        <td class="ps-4 fw-medium text-secondary"><?= $dato['nombremoneda']; ?></td>
                        <td class="text-end pe-4">
                            <a href="#" class="text-secondary me-2" title="Editar"><i class="bi bi-pencil"></i></a>
                            <a href="#" class="text-secondary" title="Eliminar"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>