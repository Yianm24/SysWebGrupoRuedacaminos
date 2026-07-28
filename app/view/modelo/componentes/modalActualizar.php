<div class="modal fade" id="actualizarMarca" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-rulers"></i> Registrar Nueva Marca de Vehiculo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="cod-marca" name="cod_marca">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Marca</label>
                        <input type="text" class="form-control" id="nombre_marca" name="nombre_marca" placeholder="Ej: Toyota" required>
                    </div>
                    
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="actualizar" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>