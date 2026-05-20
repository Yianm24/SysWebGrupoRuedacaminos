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
                
                    <div class="input-group" >
                        <span class="input-group-text bg-primary border-end-0 text-muted">
                            <i class="bi bi-search" style="color: white"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 text-muted" placeholder="Buscar cliente...">
                        
                    </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>CÉDULA</th>
                            <th>NOMBRE</th>
                            <th>CODIGO ENVIO</th>
                            <th>FECHA ENVIO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">15432987</th>
                        <td>Carlos Mendoza</td>
                        <td>15caju2052026</td>
                        <td>20/05/2026</td>
                        </tr>
                    </tbody>
                </table>
                <form action="#" method="POST">
                    
                    <div class="row mb-3">
                        <div class="col-md-6 ">
                            
                            <label for="monto_abonado" class="form-label">Monto Abonado:</label>
                            <div class="input-group" id="monto_abonado" >
                                <input type="text" class="form-control" placeholder="" aria-label="Dollar amount (with dot and two decimal places)">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1">Button</button>
                            </div>
                            
                                <div class="input-group col-12" id="monto_abonado" >
                                    <span class="input-group-text">Restante:</span>
                                    <span class="input-group-text">Bs</span>
                                    <span class="input-group-text">0.00</span>
                                    <span class="input-group-text">$</span>
                                    <span class="input-group-text">0.00</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        
                        <div class="col-md-4">
                            <label for="metodo_pago" class="form-label">Método de Pago</label>
                            <select class="form-select" id="metodos" name="metodos" required>
                                    <option value="" selected disabled>Seleccionar...</option>
                                    <option value="1">Pago Movil</option>
                                    <option value="2">Transferencia</option>
                                    <option value="3">Divisa</option>
                                </select>
                        </div>
                        <div class="col-md-4">
                                <label for="chofer" class="form-label">Cuenta Destino</label>
                                <select class="form-select" id="Chofer" name="Chofer" required>
                                    <option value="" selected disabled>Seleccionar banco...</option>
                                    <option value="1">Banesco</option>
                                    <option value="2">Venezuela</option>
                                    
                                </select>
                            </div>
                        <div class="col-md-4">
                            <label for="referencia" class="form-label">Referencia Bancaria</label>
                            <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ej: 123456789">
                        </div>
                        <div class="col-md-4">
                            <label for="estatus_pago" class="form-label">Estatus del Pago</label>
                            <select class="form-select" id="estatus_pago" name="estatus_pago" required>
                                <option value="abonado">Pendiente</option>
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
