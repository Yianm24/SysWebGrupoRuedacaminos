<div class="modal fade" id="modalKilometraje" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form id="formKilometraje" action="?url=kilometraje" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="" id="id_tarifa" value="">
                    
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="kilometraje_input" class="form-label">Kilometraje (Distancia)</label>
                            <input type="text" class="form-control numeros-decimales input-evaluar" id="kilometraje_input" name="kilometraje" placeholder="Ej: 1 o 9.5" required>
                            <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                        </div>
                        <div class="col-md-12">
                            <label for="precio_kilometraje" class="form-label">Monto de la Tarifa ($)</label>
                            <input type="text" class="form-control numeros-decimales input-evaluar" id="precio_kilometraje" name="precio_kilometraje" placeholder="0.00" required>
                            <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
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