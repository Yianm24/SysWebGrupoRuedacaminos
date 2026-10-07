<div class="modal fade" id="modalEditarPago" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarLabel"><i class="bi bi-pencil-square"></i> Editar Pago</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=pago" method="POST" id="formEditarPago">
                <input type="hidden" name="tipoSolicitud" value="actualizar">
                <input type="hidden" name="cod_pago" id="cod_pago_editar">
                <input type="hidden" name="cod_detallepago" id="cod_detallepago_editar">

                <div class="modal-body">
                    <fieldset class="row mb-3">
                        <div class="col-md-6">
                            <label for="monto_editar" class="form-label">Monto Abonado:</label>
                            <input type="text" class="form-control" id="monto_editar" name="monto" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_pago_editar" class="form-label">Fecha de Pago</label>
                            <input type="date" class="form-control" id="fecha_pago_editar" name="fecha_pago" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </fieldset>

                    <fieldset class="row mb-4">
                        <div class="col-md-4">
                            <label for="metodo_editar" class="form-label">Método de Pago</label>
                            <select class="form-select" id="metodo_editar" name="metodos" required>
                                <option value="" selected disabled>Seleccionar...</option>
                                <option value="1">Pago Movil</option>
                                <option value="2">Transferencia</option>
                                <option value="3">Divisa</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="banco_editar" class="form-label">Cuenta Destino</label>
                            <select class="form-select" id="banco_editar" name="Chofer" required>
                                <option value="" selected disabled>Seleccionar banco...</option>
                                <option value="1">Banesco</option>
                                <option value="2">Venezuela</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="referencia_editar" class="form-label">Referencia Bancaria</label>
                            <input type="text" class="form-control" id="referencia_editar" name="referencia" required>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="estatus_pago_editar" class="form-label">Estatus del Pago</label>
                            <select class="form-select" id="estatus_pago_editar" name="estatus_pago" required>
                                <option value="0">Pendiente</option>
                                <option value="1">Completado (100%)</option>
                            </select>
                        </div>
                    </fieldset>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar Cambios</button>
                </footer>
            </form>
        </div>
    </div>
</div>