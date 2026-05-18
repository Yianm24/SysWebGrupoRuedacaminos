<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4 text-primary"><i class="bi bi-geo-alt-fill"></i> Seguimiento y Cierre de Servicio</h2>
        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Actualización de Estatus</h5>
            </div>
            <div class="card-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="estatus_envio" class="form-label">Estatus del Envío</label>
                            <select class="form-select fw-bold" id="estatus_envio" name="estatus_envio" required>
                                <option value="en_transito" class="text-primary">En Tránsito</option>
                                <option value="entregado" class="text-success">Entregado</option>
                                <option value="incidencia" class="text-danger">Incidencia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_entrega" class="form-label">Fecha/Hora Real de Entrega</label>
                            <input type="datetime-local" class="form-control" id="fecha_entrega" name="fecha_entrega">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="persona_recibe" class="form-label">Persona que Recibe (Nombre y Cédula)</label>
                        <input type="text" class="form-control" id="persona_recibe" name="persona_recibe" placeholder="Ej: Maria Perez - V-12345678">
                    </div>

                    <div class="mb-3">
                        <label for="evidencia" class="form-label">Evidencia Fotográfica</label>
                        <input class="form-control" type="file" id="evidencia" name="evidencia" accept="image/*">
                        <div class="form-text">Cargue una foto de la guía firmada o del paquete entregado.</div>
                    </div>

                    <div class="mb-4">
                        <label for="observaciones" class="form-label">Observaciones de Entrega</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Detalles sobre la entrega o incidencias..."></textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle-fill"></i> Actualizar Estatus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
