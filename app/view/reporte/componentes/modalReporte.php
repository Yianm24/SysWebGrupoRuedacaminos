<div class="modal fade" id="customReporte" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel">
                    <i class="bi bi-calendar-range me-1"></i> Reporte Personalizado de Ingresos
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=reporte" method="POST" id="formReportePersonalizado">
                <input type="hidden" name="tipoSolicitud" value="ingresos">
                <input type="hidden" name="periodo" value="personalizado">

                <div class="modal-body">
                    <fieldset class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </fieldset>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-file-earmark-pdf"></i> Generar PDF
                    </button>
                </footer>
            </form>
        </div>
    </div>
</div>