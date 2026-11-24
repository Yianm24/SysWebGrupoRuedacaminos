<div class="modal fade" id="modalDespacho" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            
            <form action="?url=despacho" method="POST" id="formularioDespacho">
                
                <header class="modal-header bg-secondary text-white">
                    <h1 class="modal-title fs-5 fw-bold" id="modalLabel">
                        <i class="bi bi-boxes me-2"></i> Programar Nuevo Despacho y Carga
                    </h1>
                    <button type="button" class="btn-close btn-close-white" id="btnCerrarForm" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </header>

                <div class="modal-body p-4">

                    <div class="border-bottom pb-4 mb-4">
                        <h6 class="fw-bold text-secondary mb-3">
                            <span class="badge bg-primary rounded-circle me-1">1</span> Asignación de Chofer, Vehículo y Fecha
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="select_chofer" class="form-label small fw-semibold">Chofer Conductor</label>
                                <select class="form-select" id="select_chofer" name="cod_empleado" required>
                                    <option value="0" selected disabled>Seleccione un chofer</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="select_vehiculo" class="form-label small fw-semibold">Vehículo de Carga</label>
                                <select class="form-select" id="select_vehiculo" name="cod_vehiculo" required>
                                    <option value="0" selected disabled data-capacidad="0">Seleccione un vehículo</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Fecha y Hora Programada</label>
                                <div class="input-group">
                                    <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                                    <input type="time" name="hora_salida" id="hora_salida" class="form-control" value="<?= date('H:i'); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selección de Envíos Pendientes -->
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
                            <table id="tablaEnviosPendientes" class="table table-hover align-middle mb-0">
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

                <footer id="footerForm" class="modal-footer bg-light">
                    <button type="button" id="btnCerrar" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" name="tipoSolicitud" value="registrar" class="btn btn-primary px-4 fw-semibold shadow-sm disabled">
                        <i class="bi bi-save me-1"></i> Registrar
                    </button>
                </footer>

            </form>
        </div>
    </div>
</div>