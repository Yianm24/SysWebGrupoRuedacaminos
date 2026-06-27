<div class="modal fade" id="registerMetodo" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-credit-card"></i> Registrar Nuevo Método</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=metodopago" method="POST">
                <div class="modal-body">

                    <div class="input-group">
                        <select class="form-select" id="moneda" name="moneda" style="max-width: 80px;" aria-label="Moneda">
                            <option value="V">VES-</option>
                            <option value="E">USD-</option>
                            <option value="E">USDT-</option>
                            <option value="E">EUR-</option>
                        </select>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el método de pago">
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