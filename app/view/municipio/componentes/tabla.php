<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4 ">NOMBRE DE LA MUNICIPIO</th>
                    <th class="ps-4 ">NOMBRE DE LA ESTADO</th>
                    <th class="text-end pe-4">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-bold "><?= $dato['nombre'] ?></td>
                        <td class="ps-4 text-secondary "><?= $dato['nombre_estado'] ?></td>
                        <td class="text-end pe-4">

                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalMunicipio"
                                datos-cod-municipio="<?php echo $dato['cod_municipio']; ?>"
                                datos-nombre="<?php echo $dato['nombre']; ?>"
                                datos-estado-ubi="<?= $dato['cod_estado'] ?>"
                                datos-estado="<?= $dato['estado']?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="#" class="text-secondary btn-eliminar"
                                datos-cod-municipio="<?= $dato['cod_municipio'] ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>