<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4 ">NOMBRE DE LA MARCA</th>
                    <th class="ps-4">NOMBRE DE LA MODELO</th>
                    <th class="text-end pe-4">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-bold text-secondary"><?php echo $dato['nombre_marca']; ?></td>
                        <td><?php echo $dato['nombre']; ?></td>
                        <td class="text-end pe-4">

                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#actualizarModelo"
                                datos-cod-modelo="<?php echo $dato['cod_modelo']; ?>"
                                datos-nombre="<?php echo $dato['nombre']; ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="#" class="text-secondary btn-eliminar"
                                datos-cod-modelo="<?= $dato['cod_modelo'] ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>