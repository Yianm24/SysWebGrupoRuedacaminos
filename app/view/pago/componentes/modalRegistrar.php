<div class="modal fade" id="registerPago" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-wallet2"></i> Registro de Pago:</h1>
                <div class="modal-title row align-items-center ms-2">
                    <div class="col align-self-center">
                        <h5 class="mb-0"> Código Envío: <span id="codigo_envio_mostrar"></span></h5>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=pago" method="POST" id="formPago">
                <input type="hidden" name="tipoSolicitud" value="registrar">
                <input type="hidden" name="cod_envio" id="cod_envio_input">
                <input type="hidden" id="tasas_backend_json" value='<?= $tasasJSON ?>'>

                <div class="modal-body">
                    <fieldset class="row mb-3">
                        <div class="col-md-6">
                            <label for="monto_abonado_input" class="form-label">Monto Abonado:</label>
    
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold text-primary" id="simbolo_moneda_dinamico">$</span>
                                <input type="number" step="0.01" class="form-control" id="monto_abonado_input" name="monto_ingresado" placeholder="0.00" required>
                                <input type="hidden" name="monto" id="monto_dolares_oculto">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1">Añadir</button>
                            </div>

                            <div class="input-group col-12">
                                <span class="input-group-text">Restante:</span>
                                <span class="input-group-text">Bs</span>
                                <span class="input-group-text bg-white fw-bold" id="monto_restante_bs_dinamico">0.00</span>
                                <span class="input-group-text">$</span>
                                <span class="input-group-text bg-white fw-bold" id="monto_restante_dinamico">0.00</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </fieldset>

                    <fieldset class="row mb-4">
                        <div class="col-md-4">
                            <label for="metodos" class="form-label">Método de Pago</label>
                            <select class="form-select select-metodo-pago" id="metodos" name="metodos" required>
                                <option value="" selected disabled data-moneda="USD">Seleccionar...</option>
                                <option value="1" data-moneda="VES">Pago Movil (Bs)</option>
                                <option value="2" data-moneda="VES">Transferencia (Bs)</option>
                                <option value="3" data-moneda="USD">Divisa Efectivo ($)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="Chofer" class="form-label">Cuenta Destino</label>
                            <select class="form-select" id="Chofer" name="Chofer" required>
                                <option value="" selected disabled>Seleccionar banco...</option>
                                <option value="1">Banesco</option>
                                <option value="2">Venezuela</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="referencia" class="form-label">Referencia Bancaria</label>
                            <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ej: 123456789" required>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="estatus_pago" class="form-label">Estatus del Pago</label>
                            <select class="form-select" id="estatus_pago" name="estatus_pago" required>
                                <option value="0">Pendiente</option>
                                <option value="1">Completado (100%)</option>
                            </select>
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