<div class="modal fade" id="registerPrecio" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-currency-dollar"></i> Registrar Precio de Kilometraje</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form id="formPrecioKilometraje" action="#" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="tipoSolicitud" value="registrar">
                    
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="kilometraje" class="form-label">Kilometraje</label>
                            <input type="text" class="form-control" id="kilometraje" name="kilometraje" placeholder="Ej: 1km" required>
                        </div>
                        <div class="col-md-12">
                            <label for="precio_kilometraje" class="form-label">Precio por Kilómetro ($)</label>
                            <input type="number" step="0.01" min="0.1" class="form-control" id="precio_kilometraje" name="precio_kilometraje" placeholder="0.00" required>
                            <div class="form-text">Debe ser un valor numérico mayor a 0.00</div>
                        </div> 
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardar"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>