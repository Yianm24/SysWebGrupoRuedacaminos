<div class="modal fade" id="registrarCuenta" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-bank"></i> Registrar Cuenta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre de propietario</label>
                        <input type="text" class="form-control" name="nombre_propietario" placeholder="John Doe" required>
                    </div>
                    <fieldset>
                        <legend>Datos de la cuenta</legend>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Ultimos 4 digitos</label>
                                <input type="text" class="form-control" name="numero_cuenta" placeholder="0123" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Banco</label>
                                <input class="form-control" list="listaBancos" name="nombre_banco" placeholder="Escriba o seleccione un banco..." required>
                                <datalist id="listaBancos">
                                    <?php foreach ($registros as $banco): ?>
                                        <option value="<?= $banco['cod_banco'] ?>"> <?= $banco['nombrebanco'] ?></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Etiqueta para la cuenta</label>
                            <input type="text" class="form-control" name="etiqueta_cuenta" placeholder="Cuenta de ahorro" required>
                        </div>
                    </fieldset>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="registrar" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>