<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <!-- <th class="ps-4">CODIGO</th> -->
                    <th>TIPO DOCUMENTO</th>
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
                    <tr>
                          <td class="text-center"><?= $dato['tipo_documento']; ?></td>
                        <td class="ps-4 fw-medium"><?= $dato['razon_social']." ".$dato['apellido']; ?></td>
                        <td>
                            <span class="fw-medium"></span>
                        </td>
                        <td class="text-secondary"><?= $dato['descrip_contenido']; ?></td>
                        <td class="text-secondary"><?= $dato['anchura']; ?></td>
                        <td class="text-secondary"><?= $dato['altura']; ?></td>
                        <td class="text-secondary"><?= $dato['peso_total']; ?></td>
                        <td class="text-center">
                            <span class="badge">
                            </span>
                        </td>
                        <td class="pe-4 text-center">
                            <a href="#" class="text-secondary me-2 text-decoration-none" title="Modificar"
                                data-bs-toggle="modal" data-bs-target="#carouselEnvio">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="?url=envio&type=delete&id=<?//= $value['id'] ?>" class="text-secondary text-decoration-none" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este envío?');"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>