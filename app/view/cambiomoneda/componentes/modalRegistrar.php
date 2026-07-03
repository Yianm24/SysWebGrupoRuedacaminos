<?php 
if (!isset($listaMonedas)) $listaMonedas = []; 
?>

<div class="modal fade" id="registerCambio" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-currency-exchange"></i> Registrar Cambio Moneda</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=cambiomoneda" method="POST" id="formCambioMoneda">
                <div class="modal-body">
                    <input type="hidden" name="tipoSolicitud" value="registrar">
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
                        <input type="number" step="0.01" class="form-control" id="tasa" name="tasa" placeholder="0.00" required>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-repeat"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>