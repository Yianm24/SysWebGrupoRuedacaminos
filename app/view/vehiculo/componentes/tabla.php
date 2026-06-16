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
                        <td class="text-secondary"><?php switch($dato['cod_tipovehiculo']) { case 1: echo "Grande"; break; case 2: echo "Mediano"; break; case 3: echo "Pequeño"; break; default: echo "Desconocido"; } ?></td>
                        <td class="text-secondary"><?php switch($dato['cod_modelo']) { case 1: echo "Fiat"; break; case 2: echo "Canguro"; break; case 3: echo "Fiorino"; break; default: echo "Desconocido"; } ?></td>
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
                                datos-ano="<?php echo $dato['ano']; ?>"
                                >
                                    <i class="bi bi-pencil"></i>
                                </button>
                
                            
                            <!--<a href="?url=vehiculo&obtenercodigo=<?php /*$dato['cod_vehiculo'];*/ ?>" class="text-secondary text-decoration-none p-0 m-0" title="Actualizar"
                            data-bs-toggle="modal" data-bs-target="#actualizarVehiculo">
                                <i class="bi bi-pencil"></i>
                            </a>-->
                            
                            <form action="?url=vehiculo" method="POST" style="display: inline;">
                                <fieldset style="display: inline;">
                                    <!-- Elementos para eliminar un vehiculo -->
                                    <input type="hidden" name="cod_vehiculo" value="<?= $dato['cod_vehiculo'] ?>">
                                    <button type="submit" name="tipoSolicitud" value="eliminar" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este vehículo?');">
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