<?php if (!isset($listaMonedas)) $listaMonedas = []; ?>
<div class="modal fade" id="modalCambio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=cambiomoneda" method="POST" id="formCambio">
                <div class="modal-body">
                    <input type="hidden" name="id_cambio" id="id_cambio" value="">

                    <div class="mb-3">
                        <label for="moneda" class="form-label">Moneda</label>
                        <select class="form-select input-evaluar" id="moneda" name="moneda" required>
                            <option value="" selected disabled>Seleccionar...</option>
                            <?php foreach ($listaMonedas as $moneda): ?>
                                <option value="<?= $moneda['cod_moneda'] ?>">
                                    <?= $moneda['abreviatura'] ?> (<?= $moneda['nombre'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                    </div>

                    <div class="mb-3">
                        <label for="tasa" class="form-label">Valor Tasa (VES)</label>
                        <input type="text" class="form-control numeros-decimales input-evaluar" id="tasa" name="tasa" placeholder="Ej: 10,00" maxlength="12" required>
                        <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                    </div>

                    <div class="p-3 bg-light rounded border d-flex justify-content-between align-items-center" id="div_estado_cambio" style="display:none !important;">
                        <div>
                            <label class="form-label fw-semibold mb-0" for="estado_cambio">Estatus del Registro</label>
                            <small class="d-block text-muted">Indica si la tasa se encuentra activa o inactiva</small>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input fs-5" type="checkbox" role="switch" id="estado_cambio" name="estado" value="1">
                            <label class="form-check-label fw-medium" id="label_estado_cambio" for="estado_cambio">Activo</label>
                        </div>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" name="tipoSolicitud" id="btnSubmitModal" value="" class="btn btn-primary" disabled></button>
                </footer>
            </form>
        </div>
    </div>
</div>