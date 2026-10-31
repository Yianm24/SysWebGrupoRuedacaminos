<div class="modal fade" id="modalGastoDespacho" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">registrar gasto despacho</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="cod-gasto-despacho" name="cod_gasto_despacho">
                    
                    <div class="mb-3">
                        <label class="form-label">Código de Despacho</label>
                        <input type="number" class="form-control " id="cod_despacho" name="cod_despacho" placeholder="Ej: 101" required>
                        <span class="mensaje-error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción del Gasto</label>
                        <textarea class="form-control " id="descripcion" name="descripcion" rows="2" placeholder="Ej: Pago de viáticos o peaje" required></textarea>
                        <span class="mensaje-error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Monto</label>
                        <input type="number" step="0.01" class="form-control " id="monto" name="monto" placeholder="Ej: 50.00" required>
                        <span class="mensaje-error"></span>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="registrar" class="btn btn-primary">registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>