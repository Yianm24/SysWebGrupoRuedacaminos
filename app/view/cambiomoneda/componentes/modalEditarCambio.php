<div class="modal fade" id="modalEditarCambio" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="editarModalLabel"><i class="bi bi-pencil-square"></i> Editar Tasa de Cambio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=cambiomoneda" method="POST" id="formEditarCambio">
                <div class="modal-body">
                    <input type="hidden" name="tipoSolicitud" value="actualizar">
                    <input type="hidden" name="id_cambio_editar" id="id_cambio_editar" value="">
                    <input type="hidden" name="moneda_editar" id="moneda_editar" value="">
                    
                    <div class="mb-3">
                        <label for="tasa_editar" class="form-label">Valor Tasa (VES)</label>
                        <input type="number" step="0.01" class="form-control" id="tasa_editar" name="tasa_editar" required>
                    </div>
                </div>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                </footer>
            </form>
        </div>
    </div>
</div>