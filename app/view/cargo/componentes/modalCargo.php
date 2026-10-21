<div class="modal fade" id="modalCargo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=cargo" method="POST" id="formCargo">
                <div class="modal-body">
                    <input type="hidden" name="" id="cod_cargo" value="">
                    
                    <div class="mb-3">
                        <label class="form-label">Nombre del Cargo</label>
                        <input type="text" class="form-control solo-letras input-evaluar" id="nombre" name="nombre" placeholder="Ej: Gerente" required>
                        <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
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