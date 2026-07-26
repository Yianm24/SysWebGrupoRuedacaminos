<div class="modal fade" id="registerBanco" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-bank"></i> Registrar Banco</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=banco" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Banco</label>
                        <input class="form-control" list="listaBancos" name="nombre" placeholder="Escriba o seleccione un banco..." required>
                        <datalist id="listaBancos">
                            <?php foreach ($registros as $banco): ?>
                                <option value="<?= $banco['cod_banco'] ?>"> <?= $banco['nombrebanco'] ?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de Cuenta (20 dígitos)</label>
                        <input type="text" class="form-control" name="numero_cuenta" placeholder="0134-xxxx-xx-xxxxxxxxxx" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefono</label>
                        <input type="number" class="form-control" name="telefono" placeholder="0414-xxxxxxx" required>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="registrar" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>