<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">ABREVIATURA</th>
                    <th>NOMBRE</th>
                    <th class="text-end pe-4">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-bold text-secondary"><?php echo $dato['abreviatura']; ?></td>
                        <td><?php echo $dato['nombre']; ?></td>
                        <td class="text-end pe-4">
                            <input type="hidden" class="codigo_moneda">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Modificar" data-bs-toggle="modal" data-bs-target="#modificarMoneda"
                                datos-cod-moneda="<?php echo $dato['cod_moneda']; ?>"
                                datos-nombre="<?php echo $dato['nombre']; ?>"
                                datos-abreviatura="<?php echo $dato['abreviatura']; ?>"
                                >
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="?url=moneda" method="POST" style="display: inline;">
                                <fieldset style="display: inline;">
                                    <!-- Elementos para eliminar una moneda -->
                                    <input type="hidden" name="cod-moneda" value="<?= $dato['cod_moneda'] ?>">
                                    <button type="submit" name="tipoSolicitud" value="eliminar" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar esta moneda?');">
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