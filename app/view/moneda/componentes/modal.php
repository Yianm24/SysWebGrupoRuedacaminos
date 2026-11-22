<div class="modal fade" id="modalMoneda" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=moneda" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="cod-moneda" name="cod-moneda">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_moneda" name="nombre" required placeholder="Ej: Dólar, Bolívar">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Abreviatura</label>
                        <input type="text" class="form-control" id="abreviatura" name="abreviatura" required placeholder="Ej: USD, VES">
                    </div>
                    <?php if ($_SESSION['usuario']['rol'] == '6'): ?>
                        <div class="p-3 bg-light rounded border d-flex justify-content-between align-items-center">
                            <div>
                                <label class="form-label fw-semibold mb-0" for="estado_moneda">Estatus del Registro</label>
                                <small class="d-block text-muted">Indica si la moneda se encuentra activa o inactiva</small>
                            </div>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input fs-5" type="checkbox" role="switch" id="estado_moneda" name="estado" value="1" checked disabled>
                                <label class="form-check-label fw-medium" id="label_estado_moneda" for="estado_moneda">Activo</label>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="" class="btn btn-primary"></button>
                </footer>
            </form>
        </div>
    </div>
</div>