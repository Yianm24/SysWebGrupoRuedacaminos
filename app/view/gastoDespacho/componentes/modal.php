<div class="modal fade" id="modalGastoDespacho" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST" id="formGastoDespacho">
                <div class="modal-body">
                    <input type="hidden" id="cod_gasto_despacho" name="cod_gasto_despacho">

                    <div class="mb-3">
                        <label for="cod_despacho" class="form-label">Código de Despacho</label>
                        <input type="text" class="form-control input-evaluar solo-numeros" id="cod_despacho" name="cod_despacho" placeholder="Ej: 101" required>
                        <span class="mensaje-error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control input-evaluar letra-num-ceb" id="descripcion" name="descripcion" maxlength="70" placeholder="Ej: PEAJE AUTOPISTA" required>
                        <span class="mensaje-error"></span>
                    </div>

                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="text" class="form-control input-evaluar numeros-decimales" id="monto" name="monto" placeholder="Ej: 25.50" required>
                        <span class="mensaje-error"></span>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="" class="btn btn-primary" disabled></button>
                </footer>
            </form>
        </div>
    </div>
</div>