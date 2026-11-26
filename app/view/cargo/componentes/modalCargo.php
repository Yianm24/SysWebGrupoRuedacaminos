<div class="modal fade" id="modalCargo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=cargo" method="POST" id="formCargo">
                <div class="modal-body">
                    <input type="hidden" name="cod_cargo" id="cod_cargo" value="">
                    
                    <div class="mb-3">
                        <label class="form-label">Nombre del Cargo</label>
                        <input type="text" class="form-control solo-letras" id="nombre" name="nombre" placeholder="Ej: Gerente" minlength="3" maxlength="15" required>
                        <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                    </div>

                    <div class="p-3 bg-light rounded border d-flex justify-content-between align-items-center" id="div_estado_cargo" style="display:none !important;">
                        <div>
                            <label class="form-label fw-semibold mb-0" for="estado_cargo">Estatus del Registro</label>
                            <small class="d-block text-muted">Indica si el cargo se encuentra activo o inactivo</small>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input fs-5" type="checkbox" role="switch" id="estado_cargo" name="estado" value="1">
                            <label class="form-check-label fw-medium" id="label_estado_cargo" for="estado_cargo">Activo</label>
                        </div>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" name="tipoSolicitud" id="btnSubmitModal" value="" class="btn btn-primary" disabled></button>
                </footer>
            </form>
        </div>
    </div>
</div>