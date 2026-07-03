<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">PLACA</th>
                    <th>COLOR</th>
                    <th>TIPO VEHÍCULO</th>
                    <th>MODELO</th>
                    <th class="text-center">AÑO</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato):?>
                    <tr>
                        <td class="ps-4 fw-medium"><?= $dato['placa'] ?></td>
                        <td>
                            <span class="fw-medium"><?= $dato['color'] ?></span>
                        </td>
                        <td class="text-secondary"><?= $dato['nombretipovehiculo'] ?></td>
                        <td class="text-secondary"><?= $dato['nombremodelo'] ?></td>
                        <td class="text-center">
                            <span class="fw-medium"><?= $dato['ano'] ?></span>
                        </td>
                        <td class="pe-4 text-center">

                            <!--Elementos para Actualizar un vehiculo-->
                            <input type="hidden" class="codigo_vehiculo" >    
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#actualizarVehiculo"
                                datos-cod-vehiculo="<?php echo $dato['cod_vehiculo']; ?>"
                                datos-placa="<?php echo $dato['placa']; ?>"
                                datos-color="<?php echo $dato['color']; ?>"
                                datos-tipovehiculo="<?php echo $dato['cod_tipovehiculo']; ?>"
                                datos-modelo="<?php echo $dato['cod_modelo']; ?>"
                                datos-ano="<?php echo $dato['ano']; ?>"
                                >
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