<div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <div class="modal-title row align-items-center ms-2" id="div_codigo_envio" style="display:none;">
                    <div class="col align-self-center">
                        <h5 class="mb-0"> Código Envío: <span id="codigo_envio_mostrar"></span></h5>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=pago" method="POST" id="formPago">
                <input type="hidden" name="cod_pago" id="cod_pago">
                <input type="hidden" name="cod_envio" id="cod_envio">
                <input type="hidden" name="cod_detallepago" id="cod_detallepago">
                <input type="hidden" id="tasas_backend_json" value='<?= $tasasJSON ?? "{}" ?>'>

                <div class="modal-body">
                    <fieldset class="row mb-3">
                        <div class="col-md-6">
                            <label for="monto_ingresado" class="form-label">Monto Abonado:</label>
                            <div class="input-group position-relative mb-4">
                                <span class="input-group-text fw-bold text-primary" id="simbolo_moneda_dinamico">$</span>
                                <input type="text" class="form-control numeros-decimales input-evaluar" id="monto_ingresado" name="monto_ingresado" placeholder="0.00" required>
                                <input type="hidden" name="monto" id="monto_dolares_oculto">
                                <button class="btn btn-outline-secondary" type="button" id="btn_autocompletar">Añadir</button>
                                <span class="mensaje-error text-danger font-monospace small position-absolute start-0" style="display:none; top: 100%; margin-top: 4px; z-index: 10;"></span>
                            </div>

                            <div class="input-group col-12">
                                <span class="input-group-text">Restante:</span>
                                <span class="input-group-text">Bs</span>
                                <span class="input-group-text bg-white fw-bold" id="monto_restante_bs_dinamico">0.00</span>
                                <span class="input-group-text">$</span>
                                <span class="input-group-text bg-white fw-bold" id="monto_restante_dinamico">0.00</span>
                            </div>
                            <div id="alerta_visual" class="mt-2 small"></div>
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
                                <?php foreach ($metodosPago as $metodo): ?>
                                    <option value="<?= $metodo['cod_metodo'] ?>" data-moneda="<?= $metodo['abreviatura'] ?>"><?= $metodo['nombre'] ?> (<?= $metodo['abreviatura'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="cuentas" class="form-label">Cuenta Destino</label>
                            <select class="form-select select-banco" id="cuentas" name="cuentas" required>
                                <option value="" selected disabled>Seleccionar banco...</option>
                                <?php foreach ($bancos as $banco): ?>
                                    <option value="<?= $banco['cod_banco'] ?>"><?= $banco['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="referencia" class="form-label">Referencia Bancaria</label>
                            <input type="text" class="form-control solo-numeros input-evaluar" id="referencia" name="referencia" placeholder="Ej: 123456789" required>
                            <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                        </div>
                        <div class="col-md-4 mt-3">
                            <!-- Tarjeta visual de estatus -->
                            <div id="tarjeta_estatus" class="alert alert-secondary text-center shadow-sm mb-0 p-2" role="alert">
                                <span class="d-block small fw-bold text-uppercase mb-1 opacity-75">ESTATUS DEL PAGO</span>
                                <h5 class="mb-0 fw-bold" id="estatus_pago_visual">Pendiente</h5>
                            </div>
                            <input type="hidden" id="estatus_pago" name="estatus_pago" value="0">
                        </div>
                    </fieldset>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" id="btnSubmitModal" value="" class="btn btn-primary" disabled></button>
                </footer>
            </form>
        </div>
    </div>
</div>