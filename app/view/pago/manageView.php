<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4 text-primary"><i class="bi bi-wallet2"></i> Gestión de Pagos</h2>
        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Registro de Pago o Adelanto</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill"></i> Recuerde que se requiere un <strong>50% de adelanto</strong> para proceder con el envío.
                </div>

                <form action="#" method="POST">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="monto_abono" class="form-label">Monto del Abono ($)</label>
                            <input type="number" step="0.01" class="form-control" id="monto_abono" name="monto_abono" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="metodo_pago" class="form-label">Método de Pago</label>
                            <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                <option value="" selected disabled>Seleccionar...</option>
                                <option value="transferencia">Transferencia Bancaria</option>
                                <option value="pago_movil">Pago Móvil</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="zelle">Zelle</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="referencia" class="form-label">Referencia Bancaria</label>
                            <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ej: 123456789">
                        </div>
                        <div class="col-md-4">
                            <label for="estatus_pago" class="form-label">Estatus del Pago</label>
                            <select class="form-select" id="estatus_pago" name="estatus_pago" required>
                                <option value="pendiente">Pendiente</option>
                                <option value="abonado">Abonado (Adelanto)</option>
                                <option value="completado">Completado (100%)</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success"><i class="bi bi-cash-coin"></i> Registrar Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
