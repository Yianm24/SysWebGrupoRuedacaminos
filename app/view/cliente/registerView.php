<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4 text-primary"><i class="bi bi-person-plus"></i> Registro de Cliente</h2>
        
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Información del Cliente</h5>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tipo de Persona</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_persona" id="persona_natural" value="natural" checked>
                                <label class="form-check-label" for="persona_natural">
                                    Persona Natural
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_persona" id="persona_juridica" value="juridica">
                                <label class="form-check-label" for="persona_juridica">
                                    Persona Jurídica
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="+58 414 1234567" required>
                        </div>
                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
                        </div>
                    </div>

                    <!-- Campos de Persona Natural -->
                    <div id="natural-fields">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <div class="col-4">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido">
                            </div>
                            <div class="col-4">
                                <label for="cedula" class="form-label">Cédula</label>
                                <input type="text" class="form-control" id="cedula" name="cedula">
                            </div>
                        </div>
                    </div>

                    <!-- Campos de Persona Jurídica -->
                    <div id="juridica-fields" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="razon_social" class="form-label">Razón Social</label>
                                <input type="text" class="form-control" id="razon_social" name="razon_social">
                            </div>
                            <div class="col-md-6">
                                <label for="rif" class="form-label">RIF</label>
                                <input type="text" class="form-control" id="rif" name="rif">
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
