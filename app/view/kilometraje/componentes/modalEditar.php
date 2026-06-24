<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="editarModalLabel"><i class="bi bi-pencil-square"></i> Editar Precio de Kilometraje</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form id="formEditarPrecio" action="#" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="tipoSolicitud" value="actualizar">
                    <input type="hidden" name="id_tarifa_editar" id="id_tarifa_editar" value="">
                    
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="kilometraje_editar" class="form-label">Kilometraje (Distancia)</label>
                            <input type="number" step="0.01" min="0.1" class="form-control" id="kilometraje_editar" name="kilometraje_editar" required>
                        </div>
                        <div class="col-md-12">
                            <label for="precio_kilometraje_editar" class="form-label">Monto de la Tarifa ($)</label>
                            <input type="number" step="0.01" min="0.1" class="form-control" id="precio_kilometraje_editar" name="precio_kilometraje_editar" placeholder="0.00" required>
                            <div class="form-text">Debe ser un valor numérico mayor a 0.00</div>
                        </div>
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