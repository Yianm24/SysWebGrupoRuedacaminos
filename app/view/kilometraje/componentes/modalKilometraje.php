<div class="modal fade" id="modalKilometraje" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form id="formKilometraje" action="?url=kilometraje" method="POST" novalidate="novalidate">
                <div class="modal-body">
                    <input type="hidden" name="id_tarifa" id="id_tarifa" value="">

                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="kilometraje_input" class="form-label">Kilometraje (Distancia)</label>
                            <input type="text" class="form-control input-evaluar" id="kilometraje_input" name="kilometraje" placeholder="Ej: 10,00 o 1,00">
                            <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                        </div>
                        <div class="col-md-12">
                            <label for="precio_kilometraje" class="form-label">Monto de la Tarifa ($)</label>
                            <input type="text" class="form-control input-evaluar" id="precio_kilometraje" name="precio_kilometraje" placeholder="0,01">
                            <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded border d-flex justify-content-between align-items-center" id="div_estado_kilometraje" style="display:none !important;">
                        <div>
                            <label class="form-label fw-semibold mb-0" for="estado_kilometraje">Estatus del Registro</label>
                            <small class="d-block text-muted">Indica si la tarifa se encuentra activa o inactiva</small>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input fs-5" type="checkbox" role="switch" id="estado_kilometraje" name="estado" value="1">
                            <label class="form-check-label fw-medium" id="label_estado_kilometraje" for="estado_kilometraje">Activo</label>
                        </div>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" id="btnSubmitModal" value="" class="btn btn-primary" disabled></button>
                </footer>
            </form>
        </div>
    </div>
</div>