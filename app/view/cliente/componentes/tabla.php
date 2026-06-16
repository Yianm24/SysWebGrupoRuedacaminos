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
<<<<<<< HEAD
                <?php foreach ($registros as $dato): ?> 
                    <tr>
                        <td class="ps-4 fw-medium"><?= $dato['doc_identidad'] ?></td>
                        <td>
                            <span class="fw-medium"><?php echo $dato['razon_social'].' '.$dato['apellido'] ?></span>
=======
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-medium"><?= $dato['doc_identidad'] ?></td>
                        <td>
                            <span class="fw-medium"><?php echo $dato['razon_social'] . ' ' . $dato['apellido'] ?></span>
>>>>>>> dfe0de8ef2e593da69e581107a1e0c8bd60499e0
                        </td>
                        <td class="text-secondary"><?= $dato['telefono'] ?></td>
                        <td class="text-secondary"><?= $dato['email'] ?></td>
                        <td class="text-center"><?= $dato['tipo_documento'] ?></td>
                        <td class="pe-4 text-center">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Editar" data-bs-toggle="modal" data-bs-target="#editCliente"
                                datos-cod-cliente="<?php echo $dato['cod_cliente']; ?>"
                                datos-doc-identidad="<?php echo $dato['doc_identidad']; ?>"
                                datos-razon-social="<?php echo $dato['razon_social']; ?>"
                                datos-apellido="<?php echo $dato['apellido']; ?>"    
                                datos-telefono="<?php echo $dato['telefono']; ?>" 
                                datos-email="<?php echo $dato['email']; ?>"
                                datos-tipo-documento="<?php echo $dato['tipo_documento']; ?>"   
                                >
                            <i class="bi bi-pencil"></i>
                            </button>
                            <form action="?url=cliente" method="POST" style="display: inline;">
                                <fieldset style="display: inline;">
                                    <!-- Elementos para eliminar un vehiculo -->
                                    <input type="hidden" name="cod_cliente" value="<?= $dato['cod_cliente'] ?>">
                                    <button type="submit" name="tipoSolicitud" value="eliminar" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este cliente?');">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </fieldset>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>