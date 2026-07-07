<div class="modal fade" id="modificarMoneda" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-coin"></i> Modificar Moneda</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=moneda" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="cod-moneda" name="cod_moneda">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej: Dólar, Bolívar">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Abreviatura</label>
                        <input type="text" class="form-control" id="abreviatura" name="abreviatura" required placeholder="Ej: USD, VES">
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="modificar" class="btn btn-primary"><i class="bi bi-save"></i> Modificar</button>
                </footer>
            </form>
        </div>
    </div>
</div>