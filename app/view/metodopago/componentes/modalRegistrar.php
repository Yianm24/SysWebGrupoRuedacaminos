<div class="modal fade" id="registerMetodo" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-credit-card"></i> Registrar Nuevo Método</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=metodopago" method="POST">
                <div class=" row mb-3 modal-body">

                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="Moneda" class="form-label">Moneda</label>
                        <select class="form-select" id="cod_moneda" name="cod_moneda" style="max-width: 80px;" aria-label="Moneda" required>
                            <option value="V">USD</option>
                            <option value="E">VES</option>
                            <option value="E">USDT</option>
                            <option value="E">EUR</option>
                        </select>
                    </div>

                    <!-- hay que modificar las proporciones de los inputs para que se vean mejor -->
                    <div class="col-md-5 mb-9 mb-md-0">
                        <label class="form-label">Nombre Método</label>
                        <input type="text" class="form-control" name="nombre_metodo" placeholder="Ej: Pago Móvil, Zelle, Transferencia" required>
                    </div>


                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>