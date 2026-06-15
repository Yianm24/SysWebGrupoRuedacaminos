<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">CÉDULA/DOCUMENTO</th>
                    <th>NOMBRE</th>
                    <th>CONTACTO</th>
                    <th>CORREO ELECTRÓNICO</th>
                    <th class="text-center">TIPO DOCUMENTO</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?> 
                    <tr>
                        <td class="ps-4 fw-medium"><?= $dato['doc_identidad'] ?></td>
                        <td>
                            <span class="fw-medium"><?php echo $dato['razon_social'].' '.$dato['apellido'] ?></span>
                        </td>
                        <td class="text-secondary"><?= $dato['telefono'] ?></td>
                        <td class="text-secondary"><?= $dato['email'] ?></td>
                        <td class="text-center"><?= $dato['tipo_documento'] ?></td>
                        <td class="pe-4 text-center">
                            <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"
                                data-bs-toggle="modal" data-bs-target="#registerCliente">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="?url=cliente&type=delete&id=<?//= $value['id'] ?>" class="text-secondary text-decoration-none" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este cliente?');"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>