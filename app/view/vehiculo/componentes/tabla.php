<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">PLACA</th>
                    <th>COLOR</th>
                    <th>MODELO</th>
                    <th class="text-center">AÑO</th>
                    <th class="text-center">ANCHURA</th>
                    <th class="text-center">ALTURA</th>
                    <th class="text-center">PESO MÁXIMO</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-medium"><?= $dato['placa'] ?></td>
                        <td>
                            <span class="fw-medium"><?= $dato['color'] ?></span>
                        </td>
                        <td class="text-secondary"><?= $dato['nombremodelo'] ?></td>
                        <td class="text-center">
                            <span class="fw-medium"><?= $dato['anio'] ?></span>
                        </td>
                        <td class="text-center">
                            <span class="fw-medium"><?= $dato['anchura'] ?>M</span>
                        </td>
                        <td class="text-center">
                            <span class="fw-medium"><?= $dato['altura'] ?>M</span>
                        </td>
                        <td class="text-center">
                            <span class="fw-medium"><?= $dato['peso_max'] ?>KG</span>
                        </td>
                        <td class="pe-4 text-center">

                            <!--Elementos para Actualizar un vehiculo-->
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalVehiculo"
                                datos-cod-vehiculo="<?= $dato['cod_vehiculo']; ?>"
                                datos-placa="<?= $dato['placa']; ?>"
                                datos-color="<?= $dato['color']; ?>"
                                datos-anio="<?= $dato['anio']; ?>"
                                datos-anchura="<?= $dato['anchura']; ?>"
                                datos-altura="<?= $dato['altura']; ?>"
                                datos-peso-max="<?= $dato['peso_max']; ?>"
                                datos-modelo="<?= $dato['cod_modelo']; ?>"
                                datos-estado="<?= $dato['estado']; ?>">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <a href="#" class="text-secondary btn-eliminar"
                                data-id="<?= $dato['cod_vehiculo'] ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>