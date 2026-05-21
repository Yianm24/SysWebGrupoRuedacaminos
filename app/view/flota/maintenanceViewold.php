<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4 text-primary"><i class="bi bi-tools"></i> Módulo de Flota y Mantenimiento</h2>
        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Registro de Vehículo</h5>
            </div>
            <div class="card-body border-bottom">
                <form action="#" method="POST">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="placa" class="form-label">Placa del Vehículo</label>
                            <input type="text" class="form-control" id="placa" name="placa" placeholder="Ej: ABC12D" required>
                        </div>
                        <div class="col-md-6">
                            <label for="estado_operativo" class="form-label">Estado Operativo</label>
                            <select class="form-select" id="estado_operativo" name="estado_operativo" required>
                                <option value="disponible">Disponible</option>
                                <option value="en_ruta">En Ruta</option>
                                <option value="en_taller">En Taller</option>
                            </select>
                        </div>
                    </div>
                <!-- Form remains open for order logic if needed, or close it here depending on flow. For prototype, one big form is fine -->
            </div>
            <div class="card-header bg-white mt-2 border-top-0">
                <h5 class="mb-0">Orden de Mantenimiento</h5>
            </div>
            <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="repuesto" class="form-label">Repuesto Utilizado</label>
                            <select class="form-select" id="repuesto" name="repuesto">
                                <option value="" selected disabled>Seleccionar Repuesto...</option>
                                <option value="caucho">Caucho 750-16</option>
                                <option value="aceite">Aceite de Motor 15W40</option>
                                <option value="pastillas">Pastillas de Freno</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" min="1" class="form-control" id="cantidad" name="cantidad">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="costo" class="form-label">Costo de Reparación ($)</label>
                            <input type="number" step="0.01" class="form-control" id="costo" name="costo">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_servicio" class="form-label">Fecha de Servicio</label>
                            <input type="date" class="form-control" id="fecha_servicio" name="fecha_servicio" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-wrench-adjustable"></i> Guardar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

