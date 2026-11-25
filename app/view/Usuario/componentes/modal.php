<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"><i class="bi bi-person-plus"></i> Registro de Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>
            <form action="#" method="POST" id="formUsuario">
                <div class="modal-body">
                    <input type="hidden" id="cod_usuario" name="cod_usuario">
                    <fieldset>
                        <legend class="visually-hidden">Datos de Usuario</legend>
                        <div class="row mb-3">
                            <div class="col-md-2 mb-md-0">
                                <label for="cedula" class="form-label">Cédula</label>
                                <div class="input-group">
                                    <input type="text" class="form-control input-evualuar solo-numeros" id="cedula" name="cedula" placeholder="12345678">
                                    <span class="mensaje-error"></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-md-0">
                                <label for="nombre_usuario" class="form-label">Nombre del Usuario</label>
                                <input type="text" class="form-control input-evaluar solo-letras" id="nombre_usuario" name="nombre_usuario">
                                <span class="mensaje-error"></span>
                            </div>
                            <div class="col-md-3">
                                <label for="cod_rol" class="form-label">Rol</label>
                                <select class="form-select" id="cod_rol" name="cod_rol" required>
                                </select>
                            </div>
                            <div class="col-md-3 mb-md-0">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control input-evaluar letra-num-ceb" id="password" name="password">
                                <span class="mensaje-error"></span>
                            </div>
                        </div>
                        <div id="avisoPasswordActualizar" class="alert alert-warning d-flex align-items-center py-2 px-3 mb-0 d-none" role="alert">
                            <i class="bi bi-shield-lock-fill me-2 fs-5"></i>
                            <div class="small">
                                <strong>Nota de seguridad:</strong> Por políticas de protección de datos, al actualizar la información del usuario es obligatorio asignar una nueva contraseña.
                            </div>
                        </div>
                    </fieldset>
                </div>
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="registrar" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>