<div class="modal fade" id="customReporte" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5 " id="registerModalLabel"><i class="bi bi-person-plus"></i> Reportes Personalizados</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=pago" method="POST" id="formPago">
                <div class="modal-body">
                        <fieldset class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha_pago" class="form-label">Fecha Inicio</label>
                                <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?= date('Y-m-d') ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_pago" class="form-label">Fecha Fin</label>
                                <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?= date('Y-m-d') ?>" required>
                            </div>
                    </fieldset>

                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>