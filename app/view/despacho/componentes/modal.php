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
                                    <table class="table table-hover align-middle mb-0" id="tabla_vehiculo_fecha">
                                        <thead class="table-light table-header-custom">
                                            <tr>
                                                <th class="ps-4">DESTINATARIO</th>
                                                <th class="text-center">DESTINO</th>
                                                <th class="text-center">VEHICULO</th>
                                                <th class="text-center">ASIGNAR FECHA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($datosForaneos['envio'] as $envio): ?>
                                                <tr>
                                                    <td class="ps-4 fw-medium">
                                                        <?php echo $envio['razon_social'] . ' ' . $envio['apellido']; ?>
                                                        <input type="hidden" value="<?= $envio['cod_envio']; ?>" name="cod_envio">
                                                    </td>
                                                    <td>
                                                        <span class="fw-medium"></span>
                                                    </td>

                                                    <td class="text-center align-middle">
                                                        <select class="form-select form-select-sm" aria-label="Seleccionar Vehiculo" name="select_vehiculo" required>
                                                            <option selected>Vehiculos</option>
                                                            <?php foreach ($datosForaneos['vehiculo'] as $vehiculo): ?>
                                                                <option value="<?php echo $vehiculo['cod_vehiculo'] ?>"><?php echo $vehiculo['placa'] . ' ' . $vehiculo['nombremodelo']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <div class="input-group d-inline-flex justify-content-center w-auto mx-auto">
                                                            <input type="date" name="fecha" class="form-control">
                                                            <input type="time" name="hora" class="form-control">
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
                                    <table class="table table-hover align-middle mb-0" id="tabla_Despacho">
                                        <thead class="table-light table-header-custom">
                                            <tr>
                                                <th class="ps-4">VEHICULO ASIGNADO</th>
                                                <th class="text-center">FECHA ESTABLECIDA</th>
                                                <!-- <th class="text-center">CANTIDAD ENVIO</th> -->
                                                <th class="text-center">CHOFER</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-outline-secondary" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev"><i class="bi bi-arrow-left"></i>Anterior</button>
                            <button class="btn btn-outline-primary" type="button" data-bs-target="#carouselExampleCaptions" id="btn_siguiente" data-bs-slide="next">Siguiente<i class="bi bi-arrow-right"></i></button>
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