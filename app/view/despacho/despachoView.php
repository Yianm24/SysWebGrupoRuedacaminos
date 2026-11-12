<main class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-12 mb-4">
            <header class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 text-primary fw-bold"><i class="bi bi-boxes me-2"></i> Gestión de Despachos</h2>
                <button type="button" class="btn btn-primary" title="Registrar" id="botonRegistrar">
                    <i class="bi bi-plus-circle"></i> Registrar
                </button>
            </header>

            <div id="formularioRegistrar" class="card shadow-sm border-0 mb-4 d-none">
                <!-- El form envuelve todo el contenido de la tarjeta -->
                <form action="?url=despacho" method="POST" id="formularioDespacho">

                    <header class="card-header bg-secondary text-white py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-boxes me-2"></i> Programar Nuevo Despacho y Carga</h5>
                        <!-- El botón btn-close nativo de Bootstrap 5 ya funciona como icono de "X" -->
                        <button type="button" class="btn-close btn-close-white" id="btnCerrarForm" aria-label="Cerrar"></button>
                    </header>

                    <div class="card-body p-4">
                        <!-- Paso 1: Recursos y Salida -->
                        <div class="border-bottom pb-4 mb-4">
                            <h6 class="fw-bold text-secondary mb-3">
                                <span class="badge bg-primary rounded-circle me-1">1</span> Asignación de Chofer, Vehículo y Fecha
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="select_chofer" class="form-label small fw-semibold">Chofer Conductor </label>
                                    <select class="form-select" id="select_chofer" name="cod_empleado" required>
                                        <option value="" selected disabled>Seleccione un chofer</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="select_vehiculo" class="form-label small fw-semibold">Vehículo de Carga </label>
                                    <select class="form-select" id="select_vehiculo" name="cod_vehiculo" required>
                                        <option value="" selected disabled data-capacidad="0">Seleccione un vehículo</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Fecha y Hora Programada </label>
                                    <div class="input-group">
                                        <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                                        <input type="time" name="hora_salida" id="hora_salida" class="form-control" value="<?= date('H:i'); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 2: Selección de Envíos Pendientes -->
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="fw-bold text-secondary mb-0">
                                        <span class="badge bg-primary rounded-circle me-1">2</span> Selección de Envíos Pendientes a Despachar
                                    </h6>
                                    <span class="text-muted small">Marque las casillas de los envíos que subirá al vehículo.</span>
                                </div>
                            </div>

                            <!-- Tabla de Envíos Disponibles -->
                            <div class="table-responsive border rounded-3" style="max-height: 350px; overflow-y: auto;">
                                <table class="table table-hover align-middle mb-0" id="tablaEnviosPendientes">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th class="ps-3" style="width: 50px;">
                                                <input class="form-check-input" type="checkbox" id="check_todos_head">
                                            </th>
                                            <th>GUÍA</th>
                                            <th>DESTINATARIO</th>
                                            <th>DESTINO</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th class="text-center">PESO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <footer id="footerForm" class="card-footer bg-light d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary px-4" id="cancelarRegistro">Cancelar</button>
                        <button type="button" class="btn btn-primary px-4 fw-semibold shadow-sm" name="tipoSolicitud" value="Registrar">
                            <i class="bi bi-save me-1"></i> Registrar
                        </button>
                    </footer>
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