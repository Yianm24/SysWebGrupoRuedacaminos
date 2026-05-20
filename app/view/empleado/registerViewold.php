<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4 text-primary"><i class="bi bi-person-plus"></i> Registro de Empleado</h2>
        
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Información del Empleado</h5>
            </div>
            <div class="card-body">
                <form action="#" method="POST">

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

                    <div id="natural-fields">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre y Apellido</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <div class="col-md-6">
                                <label for="cedula" class="form-label">Cédula</label>
                                <input type="text" class="form-control" id="cedula" name="cedula">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cargo" class="form-label">Cargo</label>
                                <select name="cargo" id="cargo" class="form-control">
                                    <option value="" hidden>Seleccione un cargo</option>
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
