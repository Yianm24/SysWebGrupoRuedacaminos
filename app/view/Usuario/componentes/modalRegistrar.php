<div class="modal fade" id="registrarUsuario" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-person-plus"></i> Registro de Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>
            <form action="#" method="POST" id="formUsuario">
                <div class="modal-body">
                    <fieldset>
                        <legend class="visually-hidden">Datos de Usuario</legend>
                        <div class="row mb-3">
                            <div class="col-md-2 mb-md-0">
                                <label for="cedula" class="form-label">Cédula</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="12345678">
                                </div>
                            </div>
                            <div class="col-md-4 mb-md-0">
                                <label for="nombre" class="form-label">Nombre del Usuario</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <div class="col-md-3">
                                <label for="estado_operativo" class="form-label">Rol</label>
                                <select class="form-select" id="rol" name="rol" required>
                                    <?php
                                    foreach ($regRol as $dato): ?>
                                        <option value="<?php echo $dato['cod_rol']; ?>"><?php echo $dato['nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-md-0">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
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