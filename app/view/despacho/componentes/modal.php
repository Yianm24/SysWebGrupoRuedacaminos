<div class="modal fade" id="modalDespacho" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST" id="formularioDespacho">
                <div class="modal-body">
                    <div id="carouselExampleCaptions" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light table-header-custom">
                                            <tr>
                                                <th class="ps-4">DESTINATARIO</th>
                                                <th class="text-center">DESTINO</th>
                                                <th class="text-center">VEHICULO</th>
                                                <th class="text-center">ASIGNAR FECHA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($datosForaneos['envio'] as $envio):?>
                                            <tr>
                                                <td class="ps-4 fw-medium">
                                                    <?php echo $envio['razon_social'].' '. $envio['apellido']; ?>
                                                </td>
                                                <td>
                                                    <span class="fw-medium"></span>
                                                </td>

                                                <td class="text-center align-middle">
                                                    <select class="form-select form-select-sm" aria-label="Seleccionar Vehiculo" id="vehiculos" required>
                                                        <option selected>Vehiculos</option>
                                                        <?php foreach ($datosForaneos['vehiculo'] as $vehiculo): ?>
                                                            <option value="<?= $vehiculo['cod_vehiculo']; ?>"><?php echo $vehiculo['placa'] . ' ' . $vehiculo['nombremodelo']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="input-group d-inline-flex justify-content-center w-auto mx-auto">
                                                        <input type="date" id="fecha" class="form-control">
                                                        <input type="time" id="hora" class="form-control" required>
                                                    </div>
                                                </td>

                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="carousel-item">

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light table-header-custom">
                                            <tr>
                                                <th class="ps-4">VEHICULO ASIGNADO</th>
                                                <th class="text-center">FECHA ESTABLECIDA</th>
                                                <th class="text-center">CANTIDAD ENVIO</th>
                                                <th class="text-center">CHOFER</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <?php //foreach ($result as $value): 
                                                    ?> -->
                                            <tr>
                                                <td class="ps-4 fw-medium">
                                                    <select class="form-select form-select-sm" aria-label="Seleccionar Vehiculo" id="vehiculos_asignado" name="cod_vehiculo" disabled required>
                                                        <option selected>Vehiculos</option>
                                                    </select>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="input-group d-inline-flex justify-content-center w-auto mx-auto">
                                                        <input type="date" id="fecha_asignada" name="fecha" class="form-control" disabled>
                                                        <input type="time" id="hora_asignada" name="hora_despacho" class="form-control" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">

                                                </td>

                                                <td class="text-center align-middle">
                                                    <select class="form-select form-select-sm" aria-label="Seleccionar Empleado" name="cod_empleado" required>
                                                        <option selected>Empleados</option>
                                                        <?php if (!empty($datosForaneos['empleado'])): ?>
                                                            <?php foreach ($datosForaneos['empleado'] as $empleado): ?>
                                                                <option value="<?= $empleado['cod_empleado']; ?>"><?php echo $empleado['nombre'] . ' ' . $empleado['apellido']; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <option value="">No hay empleados con el cargo especificado</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </td>

                                            </tr>
                                            <?php //endforeach; 
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-outline-secondary" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev"><i class="bi bi-arrow-left"></i>Anterior</button>
                            <button class="btn btn-outline-primary" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">Siguiente<i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                    <footer class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="tipoSolicitud" value="" class="btn btn-primary"></button>
                    </footer>
                </div>
            </form>
        </div>
    </div>
</div>