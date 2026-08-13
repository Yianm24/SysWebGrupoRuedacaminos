<div class="modal fade" id="modalCuenta" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"><i class="bi bi-bank"></i> Registrar Cuenta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="cod_cuenta" id="cod-cuenta">
                    
                    <div class="mb-3">
                        <label class="form-label" for="nombre-propietario">Nombre de propietario</label>
                        <input type="text" class="form-control" name="nombre_propietario" id="nombre-propietario" required>
                    </div>
                    <fieldset>
                        <legend>Datos de la cuenta</legend>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="numero-cuenta">Ultimos 4 digitos</label>
                                <input type="text" class="form-control" name="numero_cuenta" id="numero-cuenta" placeholder="0123" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="nombre-banco">Banco</label>
                                <input class="form-control" list="listaBancos" name="nombre_banco" id="nombre-banco" placeholder="Escriba o seleccione un banco..." required>
                                <datalist id="listaBancos">
                                    <?php foreach ($bancos as $banco): ?>
                                        <option value="<?= $banco['cod_banco'] ?>"> <?= $banco['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="etiqueta-cuenta">Etiqueta para la cuenta</label>
                            <input type="text" class="form-control" name="etiqueta_cuenta" id="etiqueta-cuenta" placeholder="Cuenta de ahorro" required>
                        </div>
                    </fieldset>
                </div>
                
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <!--<button type="submit" name="tipoSolicitud" value="actualizar" class="d-none btn btn-primary"><i class="bi bi-save"></i> Actualizar</button>-->
                    <button type="submit" name="tipoSolicitud" value="" class="btn btn-primary"></button>
                </footer>
            </form>
        </div>
    </div>
</div>