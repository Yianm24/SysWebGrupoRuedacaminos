<div class="modal fade" id="registerUnidad" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-rulers"></i> Registrar Nueva Unidad de Medida</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=unidadmedida" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Unidad</label>
                        <input type="text" class="form-control" name="nombre_unidad" placeholder="Ej: Kilogramos" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Abreviatura</label>
                            <input type="text" class="form-control" name="abreviatura" placeholder="Ej: KG" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Unidad</label>
                            <input class="form-control" list="listaTipos" name="tipo_unidad" placeholder="Escriba o seleccione..." required>
                            <datalist id="listaTipos">
                                <option value="Longitud">
                                <option value="Peso">
                                <option value="Volumen">
                                <option value="Distancia">
                            </datalist>
                        </div>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>