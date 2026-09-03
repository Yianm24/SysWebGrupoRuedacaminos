<div class="modal fade" id="modalEstado" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="cod-estado" name="cod_estado">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Estado</label>
                        <input type="text" class="form-control" id="nombre_estado" name="nombre_estado" placeholder="Ej: Toyota" required>
                    </div>
                    
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="" class="btn btn-primary"></button>
                </footer>
            </form>
        </div>
    </div>
</div>