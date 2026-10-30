<main class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-12 mb-4">
            <header class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 text-primary fw-bold"><i class="bi bi-boxes me-2"></i> Gestión de Despachos</h2>
                <button type="button" class="btn btn-primary" title="Registrar" id="botonRegistrar">
                    <i class="bi bi-plus-circle"></i> Registrar
                </button>
            </header>

            <div id="formularioRegistrar" class="row m-sm-3 d-none">
                <form action="#" method="POST" id="formularioDespacho">
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
                                                            <input type="date" name="fechaSalida" class="form-control">
                                                            <input type="time" name="horaSalida" class="form-control">
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
                            <?php require 'componentes/modalChofer.php'; ?>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-outline-secondary" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev"><i class="bi bi-arrow-left"></i>Anterior</button>
                            <button class="btn btn-outline-primary" type="button" data-bs-target="#carouselExampleCaptions" id="btn_siguiente" data-bs-slide="next">Siguiente<i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button type="button" class="btn btn-secondary" id="cancelarRegistro">Cancelar</button>
                        <button type="submit" name="tipoSolicitud" value="" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>

            <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">Historial</h4>
            </div>

            <?php require 'componentes/tabla.php'; ?>

            <footer class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center px-4 py-3">
                <span class="text-muted small">Mostrando resultados</span>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm px-3 text-muted" disabled>Anterior</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 text-muted">Siguiente</button>
                </div>
            </footer>
            </section>
        </div>
    </div>
</main>
<script src="assets/js/sweetalert2.all.min.js"></script>
<script src="assets/js/despacho.js"></script>