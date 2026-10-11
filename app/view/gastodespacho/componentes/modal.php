<div class="modal fade" id="modalGastosDespacho" tabindex="-1" aria-labelledby="modalGastosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="?url=gastodespacho" method="POST">
                <header class="modal-header">
                    <h1 class="modal-title fs-5" id="modalGastosLabel"><i class="bi bi-cash-coin me-2"></i>Registrar Gasto de Despacho</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </header>

                <div class="modal-body">
                    <!-- Input oculto para recibir el código del despacho madre -->
                    <input type="hidden" name="cod_despacho" id="cod_despacho_gasto">
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción del Gasto</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required placeholder="Ej. Peaje, Viáticos, Combustible...">
                    </div>

                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" step="0.01" class="form-control" id="monto" name="monto" required placeholder="0.00">
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="registrar_gasto" class="btn btn-primary"><i class="bi bi-save"></i> Guardar Gasto</button>
                </footer>
            </form>
        </div>
    </div>
</div>