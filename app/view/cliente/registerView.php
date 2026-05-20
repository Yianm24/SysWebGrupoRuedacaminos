<div class="container-fluid py-5 px-4">
    <div class="row">
        
        <div class="col-xl-5 col-lg-6 mb-4">
            
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2 class="mb-4 text-primary"><i class="bi bi-person-plus"></i> Registro de Cliente</h2>
                    
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Información del Cliente</h5>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST">
                                
                                <div class="mb-4">
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_persona_remitente" id="persona_natural" value="remitente_natural" checked>
                                            <label class="form-check-label" for="persona_natural">
                                                Persona Natural
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_persona_remitente" id="persona_juridica" value="remitente_juridico">
                                            <label class="form-check-label" for="persona_juridica">
                                                Persona Jurídica
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div id="remitente_natural-fields">
                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="cedula" class="form-label">Cédula</label>
                                            <input type="text" class="form-control" id="cedula" name="cedula">
                                        </div>
                                        <div class="col-4">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre">
                                        </div>
                                        <div class="col-4">
                                            <label for="apellido" class="form-label">Apellido</label>
                                            <input type="text" class="form-control" id="apellido" name="apellido">
                                        </div>
                                        
                                    </div>
                                </div>

                                <div id="remitente_juridico-fields" style="display: none;">
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

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar Cliente</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>

        <div class="col-xl-7 col-lg-6 mb-4">
            
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">Directorio</h4>
                    <div class="input-group" style="max-width: 250px;">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 text-muted" placeholder="Buscar cliente...">
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light table-header-custom">
                                <tr>
                                    <th class="ps-4">CÉDULA</th>
                                    <th>NOMBRE</th>
                                    <th>CONTACTO</th>
                                    <th>CORREO ELECTRÓNICO</th>
                                    <th class="pe-4 text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 fw-medium">15432987</td>
                                    <td>
                                        <span class="fw-medium">Carlos Mendoza</span>
                                    </td>
                                    <td class="text-secondary">0414-5551234</td>
                                    <td class="text-secondary">carlos.mendoza@email.com</td>
                                    <td class="pe-4 text-center">
                                        <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary text-decoration-none" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-medium">22876543</td>
                                    <td>
                                        <span class="fw-medium">María Rodríguez</span>
                                    </td>
                                    <td class="text-secondary">0424-9876543</td>
                                    <td class="text-secondary">mrodriguez22@email.com</td>
                                    <td class="pe-4 text-center">
                                        <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary text-decoration-none" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-medium">18345678</td>
                                    <td>
                                        <span class="fw-medium">José Pérez</span>
                                    </td>
                                    <td class="text-secondary">0412-3334455</td>
                                    <td class="text-secondary">jose.perez.contacto@email.com</td>
                                    <td class="pe-4 text-center">
                                        <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary text-decoration-none" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-medium">26901234</td>
                                    <td>
                                        <span class="fw-medium">Ana Lucía Gómez</span>
                                    </td>
                                    <td class="text-secondary">0416-1112233</td>
                                    <td class="text-secondary">ana.lucia.g@email.com</td>
                                    <td class="pe-4 text-center">
                                        <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary text-decoration-none" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center px-4 py-3">
                    <span class="text-muted small">Mostrando 4 de 4 clientes</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm px-3 text-muted" disabled>Anterior</button>
                        <button class="btn btn-outline-secondary btn-sm px-3 text-muted">Siguiente</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="assets/js/cliente.js"></script>
