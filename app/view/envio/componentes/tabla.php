<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <!-- <th class="ps-4">CODIGO</th> -->
                    <th>REMITENTE</th>
                    <th>DESTINO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>ANCHO</th>
                    <th>ALTO</th>
                    <th>PESO TOTAL</th>
                    <th>FECHA</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr class="align-middle">
                        <td class="ps-4 fw-semibold text-dark py-3">
                            <?= $dato['tipo_documento'] . " - " . $dato['razon_social'] . " " . $dato['apellido']; ?>
                        </td>
                        <td>
                            <span class="fw-medium"></span>
                        </td>
                        <td class="text-secondary py-3"><?= $dato['descrip_contenido']; ?></td>
                        <td class="text-secondary py-3"><?= $dato['anchura']; ?></td>
                        <td class="text-secondary py-3"><?= $dato['altura']; ?></td>
                        <td class="text-secondary fw-medium py-3"><?= $dato['peso_total']; ?></td>
                        <td class="text-secondary py-3">
                            <?= $dato['fecha']; ?>
                        </td>
                        <td class="pe-4 text-center py-3">
                            <a href="#" class="btn btn-sm btn-outline-primary me-2 shadow-sm" title="Modificar"
                                data-bs-toggle="modal" data-bs-target="#carouselEnvio">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="?url=envio&type=delete&id=<? //= $value['id'] 
                                                                ?>"
                                class="btn btn-sm btn-outline-danger shadow-sm"
                                title="Eliminar"
                                onclick="return confirm('¿Está seguro de eliminar este envío?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>