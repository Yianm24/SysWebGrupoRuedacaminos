<?php
if (!isset($metodosPago))$metodosPago = [];
if (!isset($bancos))$bancos = [];
?>
<div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <header class="modal-header py-2 px-4">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <div class="modal-title row align-items-center ms-2" id="div_codigo_envio" style="display:none;">
                    <div class="col-auto">
                        <h6 class="mb-0 fw-semibold">Código Envío: <span id="codigo_envio_mostrar" class="badge bg-primary"></span></h6>
                    </div>
                    <div class="col-auto" id="div_total_abonado_modal" style="display:none;">
                        <h6 class="mb-0 fw-semibold">Total Abonado: <span id="total_abonado_mostrar" class="badge bg-success">$0,00</span></h6>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=pago" method="POST" id="formPago" novalidate="novalidate">
                <input type="hidden" name="cod_pago" id="cod_pago">
                <input type="hidden" name="cod_envio" id="cod_envio">
                <input type="hidden" name="cod_detallepago" id="cod_detallepago">
                <input type="hidden" name="hora_original" id="hora_original">
                <input type="hidden" id="tasas_backend_json" value='<?= $tasasJSON ?? "{}" ?>'>

                <div class="modal-body py-3 px-4">
                    <div id="selectorPagoEditarWrapper" class="border rounded-3 p-2 mb-3 bg-light" style="display:none;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="fw-bold text-primary mb-0 small">
                                <i class="bi bi-list-check me-1"></i> Seleccione el registro de pago a editar (Envío #<span id="editar_cod_envio_label"></span>)
                            </h6>
                            <span class="badge bg-secondary" id="editar_total_pagos_badge">0 pagos</span>
                        </div>
                        <div class="table-responsive border rounded-2 bg-white" style="max-height: 145px; overflow-y: auto;">
                            <table class="table table-sm table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th class="ps-2 text-center" style="width: 55px;">ELEGIR</th>
                                        <th>PAGO</th>
                                        <th>FECHA</th>
                                        <th>MÉTODO</th>
                                        <th>MONTO INGRESADO</th>
                                        <th class="pe-2">REFERENCIA</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyPagosEditar">
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-2">Cargando pagos del envío...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <fieldset class="row g-3 mb-2">
                        <div class="col-md-6">
                            <label for="monto_ingresado" class="form-label mb-1" id="label_monto_ingresado">Monto Abonado:</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold text-primary" id="simbolo_moneda_dinamico">$</span>
                                <input type="text" class="form-control input-evaluar" id="monto_ingresado" name="monto_ingresado" placeholder="0,00">
                                <input type="hidden" name="monto" id="monto_dolares_oculto">
                                <button class="btn btn-outline-primary fw-semibold" type="button" id="btn_autocompletar" title="Completar saldo total restante">
                                    <i class="bi bi-check2-circle me-1"></i>Completar
                                </button>
                            </div>
                            <span class="mensaje-error text-danger font-monospace small d-block mt-1" style="display:none;"></span>

                            <div class="mt-2">
                                <div id="div_equivalente_moneda_usd" class="mb-1" style="display:none;">
                                    <small class="text-muted fw-semibold">Equivalente en Dólares:</small>
                                    <span class="fw-bold text-dark ms-1" id="monto_equivalente_usd_badge">$0,00</span>
                                    <small class="text-muted ms-1" id="texto_tasa_referencia_modal"></small>
                                </div>

                                <div>
                                    <small class="text-muted fw-semibold" id="label_restante_modal">Restante en Dólares:</small>
                                    <span class="fw-bold text-primary ms-1" id="monto_restante_dinamico">$0,00</span>
                                </div>
                            </div>
                            <div id="alerta_visual" class="mt-1 small"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_pago" class="form-label mb-1">Fecha de Pago</label>
                            <input type="date"
                                    class="form-control bg-light"
                                    id="fecha_pago"
                                    name="fecha_pago"
                                    value="<?= date('Y-m-d') ?>"
                                    readonly
                                    tabindex="-1">
                            <small class="text-muted d-block mt-1">La fecha se asigna automáticamente y no puede modificarse.</small>
                            <span class="mensaje-error text-danger font-monospace small d-block mt-1" style="display:none;"></span>
                        </div>
                    </fieldset>

                    <fieldset class="row g-3 align-items-start">
                        <div class="col-md-4">
                            <label for="metodos" class="form-label mb-1">Método de Pago</label>
                            <select class="form-select select-metodo-pago" id="metodos" name="metodos">
                                <option value="" selected disabled data-moneda="USD">Seleccionar...</option>
                                <?php foreach ($metodosPago as$metodo): ?>
                                    <?php if (strtolower(trim($metodo['nombre'])) === 'zelle') continue; ?>
                                    <option value="<?= $metodo['cod_metodo'] ?>" data-moneda="<?= $metodo['abreviatura'] ?>">
                                        <?= $metodo['nombre'] ?> (<?=$metodo['abreviatura'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="mensaje-error text-danger font-monospace small d-block mt-1" style="display:none;"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="cuentas" class="form-label mb-1" id="label_cuenta_destino">Cuenta Destino</label>
                            <select class="form-select select-banco" id="cuentas" name="cuentas">
                                <option value="" selected disabled>Seleccionar banco...</option>
                                <?php foreach ($bancos as$banco): ?>
                                    <option value="<?= $banco['cod_banco'] ?>"><?= $banco['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="mensaje-error text-danger font-monospace small d-block mt-1" style="display:none;"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="referencia" class="form-label mb-1">Referencia Bancaria</label>
                            <input type="text" class="form-control solo-numeros input-evaluar" id="referencia" name="referencia" placeholder="Ej: 123456789">
                            <span class="mensaje-error text-danger font-monospace small d-block mt-1" style="display:none;"></span>
                        </div>

                        <div class="col-md-4" id="div_tarjeta_estatus">
                            <div id="tarjeta_estatus" class="alert alert-secondary text-center shadow-sm mb-0 py-1 px-2" role="alert">
                                <span class="d-block small fw-bold text-uppercase opacity-75" style="font-size: 0.72rem;">ESTATUS DEL PAGO</span>
                                <h6 class="mb-0 fw-bold" id="estatus_pago_visual">Pendiente</h6>
                            </div>
                            <input type="hidden" id="estatus_pago" name="estatus_pago" value="0">
                        </div>
                    </fieldset>
                </div>

                <footer class="modal-footer py-2 px-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" id="btnSubmitModal" value="" class="btn btn-primary" disabled></button>
                </footer>
            </form>
        </div>
    </div>
</div>

<!-- Modal Historial de Pagos -->
<div class="modal fade" id="modalHistorialPago" tabindex="-1" aria-labelledby="modalHistorialLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <header class="modal-header bg-white border-bottom">
                <h1 class="modal-title fs-5 fw-bold text-primary" id="modalHistorialLabel">
                    <i class="bi bi-clock-history me-2"></i> Historial Detallado de Pagos - Envío #<span id="hist_cod_envio"></span>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>
            <div class="modal-body p-4">
                <div class="row g-3 mb-4" id="resumenEnvioHistorial">
                    <div class="col-md-3">
                        <div class="border rounded-3 p-3 bg-light">
                            <small class="text-muted d-block fw-semibold">Fecha del Envío</small>
                            <span class="fw-bold text-dark" id="hist_fecha_envio">-</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded-3 p-3 bg-light">
                            <small class="text-muted d-block fw-semibold">Estatus Envío</small>
                            <span class="fw-bold text-dark" id="hist_estatus_envio">-</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded-3 p-3 bg-light">
                            <small class="text-muted d-block fw-semibold">Monto Total Envío</small>
                            <span class="fw-bold text-dark" id="hist_monto_total">$0,00</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded-3 p-3 bg-light">
                            <small class="text-muted d-block fw-semibold">Total Abonado</small>
                            <span class="fw-bold text-success" id="hist_total_abonado">$0,00</span>
                        </div>
                    </div>
                </div>

                <div class="border rounded-3 p-3 mb-4 bg-white">
                    <h6 class="fw-bold text-secondary mb-3">
                        <i class="bi bi-person-badge me-1"></i> Datos del Cliente Remitente
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <small class="text-muted d-block fw-semibold">Nombre / Razón Social</small>
                            <span class="fw-semibold text-dark" id="hist_remitente_nombre">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block fw-semibold">Cédula / Documento</small>
                            <span class="fw-semibold text-dark" id="hist_remitente_doc">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block fw-semibold">Teléfono</small>
                            <span class="fw-semibold text-dark" id="hist_remitente_tel">-</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block fw-semibold">Correo Electrónico</small>
                            <span class="fw-semibold text-dark" id="hist_remitente_email">-</span>
                        </div>
                    </div>
                </div>

                <div class="border rounded-3 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">CANTIDAD</th>
                                    <th>FECHA Y HORA</th>
                                    <th>MÉTODO</th>
                                    <th>CUENTA DESTINO</th>
                                    <th>REFERENCIA</th>
                                    <th>MONTO INGRESADO</th>
                                    <th>TASA CAMBIO</th>
                                    <th>EQUIVALENTE A USD</th>
                                    <th>SALDO RESTANTE</th>
                                    <th class="pe-3 text-center">ESTADO</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyHistorialPagos"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <footer class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </footer>
        </div>
    </div>
</div>