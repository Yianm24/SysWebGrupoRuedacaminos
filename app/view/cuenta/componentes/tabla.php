<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">PROPIETARIO</th>
                    <th class="ps-4">BANCO</th>
                    <th class="ps-4">ETIQUETA</th>
                    <th class="ps-4 text-center">NÚMERO DE CUENTA</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-medium"><?= $dato['propietario'] ?></td>
                        <td class="ps-4 fw-medium"><?= $dato['nombrebanco'] ?></td>
                        <td class="ps-4 fw-medium"><?= $dato['etiqueta'] ?></td>
                        <td class="ps-4 text-center">
                            <span class="fw-medium"><?php echo $dato['numero_cuenta']; ?></span>
                        </td>

                        <td class="pe-4 text-center">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalCuenta"
                                datos-cod-cuenta="<?php echo $dato['cod_cuenta'];?>"
                                datos-nombre-propietario="<?php echo $dato['propietario']; ?>"
                                datos-numero-cuenta="<?php echo $dato['numero_cuenta']; ?>"
                                datos-cod-banco="<?php echo $dato['cod_banco']; ?>"
                                datos-etiqueta="<?php echo $dato['etiqueta']; ?>"
                                datos-estado="<?php echo $dato['estado'];?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="#" class="text-secondary btn-eliminar"
                                data-id="<?= $dato['cod_cuenta'] ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>