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
                            <span class="fw-medium"><?php echo $dato['razon_social'] . ' ' . $dato['apellido'] ?></span>
                        </td>
                        <td class="text-secondary"><?= $dato['telefono'] ?></td>
                        <td class="text-secondary"><?= $dato['email'] ?></td>
                        <td class="text-center"><?= $dato['tipo_documento'] ?></td>
                        <td class="pe-4 text-center">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Editar" data-bs-toggle="modal" <?= ($dato['tipo_documento'] == 'V' || $dato['tipo_documento'] == 'E') ? 'data-bs-target="#editClienteNatural"' : 'data-bs-target="#editClienteJuridico"' ?>
                                
                                datos-cod-cliente="<?= $dato['cod_cliente']; ?>"
                                datos-doc-identidad="<?= $dato['doc_identidad']; ?>"
                                datos-razon-social="<?= $dato['razon_social']; ?>"
                                datos-apellido="<?= $dato['apellido']; ?>"
                                datos-telefono="<?= $dato['telefono']; ?>"
                                datos-email="<?= $dato['email']; ?>"
                                datos-tipo-documento="<?= $dato['tipo_documento']; ?>"
                                datos-estado="<?= $dato['estado']; ?>" >
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="#" class="text-secondary btn-eliminar"
                                datos-cod-cliente="<?= $dato['cod_cliente'] ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>