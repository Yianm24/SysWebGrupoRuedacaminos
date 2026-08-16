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
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Modificar" data-bs-toggle="modal" data-bs-target="#modalMoneda"
                                datos-cod-moneda="<?php echo $dato['cod_moneda']; ?>"
                                datos-nombre="<?php echo $dato['nombre']; ?>"
                                datos-abreviatura="<?php echo $dato['abreviatura']; ?>"
                                datos-estado="<?php echo $dato['estado']; ?>">

                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="#" class="text-secondary btn-eliminar"
                                datos-cod-moneda="<?= $dato['cod_moneda'] ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>