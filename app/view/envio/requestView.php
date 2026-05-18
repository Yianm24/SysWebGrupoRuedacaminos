<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4 text-primary"><i class="bi bi-box-seam"></i> Solicitud de Envío y Paquetería</h2>
        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Datos del Envío</h5>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="fecha_solicitud" class="form-label">Fecha de Solicitud</label>
                            <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud" value="<?= date('Y-m-d') ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="monto_base" class="form-label">Monto Base ($)</label>
                            <input type="number" step="0.01" class="form-control" id="monto_base" name="monto_base" required>
                        </div>
                        <div class="col-md-4">
                            <label for="kilometraje" class="form-label">Kilometraje Estimado</label>
                            <input type="number" step="0.1" class="form-control" id="kilometraje" name="kilometraje" required>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ubicacion" class="form-label">Ubicación despacho</label>
                            <select class="form-select" id="ubicacion" name="ubicacion" required>
                                <option value="" selected disabled>Seleccionar Ubicación...</option>
                                <option value="1">Caracas</option>
                                <option value="2">Valencia</option>
                                <option value="3">Maracaibo</option>
                                <option value="4">Barquisimeto</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_punto" class="form-label">Ubicación destino</label>
                            <select class="form-select" id="ubicacion" name="ubicacion" required>
                                <option value="" selected disabled>Seleccionar Ubicación...</option>
                                <option value="1">Caracas</option>
                                <option value="2">Valencia</option>
                                <option value="3">Maracaibo</option>
                                <option value="4">Barquisimeto</option>
                            </select>
                        </div>
                    </div>
                  

                    <h5 class="mt-4 mb-3 border-bottom pb-2">Detalles de la Paquetería</h5>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción del Contenido</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="peso" class="form-label">Peso (Kg)</label>
                            <input type="number" step="0.01" class="form-control" id="peso" name="peso" required>
                        </div>
                        <div class="col-md-3">
                            <label for="alto" class="form-label">Alto (cm)</label>
                            <input type="number" step="0.01" class="form-control" id="alto" name="alto" required>
                        </div>
                        <div class="col-md-3">
                            <label for="ancho" class="form-label">Ancho (cm)</label>
                            <input type="number" step="0.01" class="form-control" id="ancho" name="ancho" required>
                        </div>
                        <div class="col-md-3">
                            <label for="largo" class="form-label">Largo (cm)</label>
                            <input type="number" step="0.01" class="form-control" id="largo" name="largo" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="articulos_fragil" name="articulos_fragil">
                            <label class="form-check-label text-danger fw-bold" for="articulos_fragil">¿Contiene Artículos Frágiles?</label>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-send-check"></i> Registrar Envío</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
