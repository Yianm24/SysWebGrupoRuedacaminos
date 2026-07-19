<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">NOMBRE DEL ROL</th>
                    <th class="text-end pe-4">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-medium text-secondary"><?php echo $dato['nombre']; ?></td>
                        <td class="text-end pe-4">
                            <input type="hidden" class="codigo_rol">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#actualizarRol"
                                datos-cod-rol="<?php echo $dato['cod_rol']; ?>"
                                datos-nombre="<?php echo $dato['nombre']; ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="?url=rol" method="POST" style="display: inline;">
                                <fieldset style="display: inline;">
                                    <!-- Elementos para eliminar un vehiculo -->
                                    <input type="hidden" name="cod_rol" value="<?= $dato['cod_rol'] ?>">
                                    <button type="submit" name="tipoSolicitud" value="eliminar" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este rol?');">
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


