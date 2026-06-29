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
                            <!--Elementos para Actualizar un vehiculo-->
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#actualizarMetodoPago"
                                datos-cod-metodo="<?php echo $dato['cod_metodo']; ?>"
                                datos-nombre="<?php echo $dato['nombre']; ?>"
                                datos-cod-moneda="<?php echo $dato['cod_moneda']; ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="?url=metodopago" method="POST" style="display: inline;">
                                <fieldset style="display: inline;">
                                    <!-- Elementos para eliminar un vehiculo -->
                                    <input type="hidden" name="cod_metodo" value="<?= $dato['cod_metodo'] ?>">
                                    <button type="submit" name="tipoSolicitud" value="eliminar" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este método de pago?');">
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