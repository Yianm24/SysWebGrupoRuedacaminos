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
                    <input type="hidden" name="" id="id_cambio" value="">

                    <div class="mb-3">
                        <label for="moneda" class="form-label">Moneda</label>
                        <select class="form-select" id="moneda" name="moneda" required>
                            <option value="" selected disabled>Seleccionar...</option>
                            <?php foreach ($listaMonedas as $moneda): ?>
                                <option value="<?= $moneda['cod_moneda'] ?>">
                                    <?= $moneda['abreviatura'] ?> (<?= $moneda['nombre'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tasa" class="form-label">Valor Tasa (VES)</label>
                        <input type="text" class="form-control numeros-decimales input-evaluar" id="tasa" name="tasa" placeholder="0.00" required>
                        <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" id="btnSubmitModal" value="" class="btn btn-primary" disabled></button>
                </footer>
            </form>
        </div>
    </div>
</div>