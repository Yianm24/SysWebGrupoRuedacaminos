<div class="container-fluid py-5 px-4">
    <div class="row">
        
        <div class="col-xl-5 col-lg-6 mb-4">
            
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2 class="mb-4 text-primary"><i class="bi bi-person-plus"></i> Registro de Empleado</h2>
                    
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Información del Empleado</h5>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST">

                                <div id="natural-fields">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="cedula" class="form-label">Cédula</label>
                                            <input type="text" class="form-control" id="cedula" name="cedula">
                                        </div>
                                        <div class="col-md-6">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="+58 414 1234567" required>
                                    </div>
                                        <label for="nombre_completo" class="form-label">Nombre Completo</label>
                                        <div class="col-md-6 input-group " id="nombre_completo">
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre:">
                                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido:">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="correo" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
                                    </div>
                                </div>

                                <div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="cargo" class="form-label">Cargo</label>
                                            <select name="cargo" id="cargo" class="form-control">
                                                <option value="" hidden>Seleccione un cargo...</option>
                                                <option value="conductor">Chofer</option>
                                                <option value="auxiliar">Recepcionista</option>
                                                <option value="supervisor">Administrador</option>
                                                <option value="gerente">Gerente</option>
                                                <option value="director">Director</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="salario" class="form-label">Salario</label>
                                            <input type="number" class="form-control" id="salario" name="salario" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar Empleado</button>
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
                        <input type="text" class="form-control border-start-0 ps-0 text-muted" placeholder="Buscar Empleado...">
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
                                    <th>CARGO</th>
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
                                    <td class="text-secondary">Administrador</td>
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
                                    <td class="text-secondary">Administrador</td>
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
                                    <td class="text-secondary">Chofer</td>
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
                                    <td class="text-secondary">Recepcionista</td>
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
