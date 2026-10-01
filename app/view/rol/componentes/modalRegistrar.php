<div class="modal fade" id="registerRol" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-person-badge"></i> Registrar Nuevo Rol</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=rol" method="POST">
                <div class="modal-body">
                    <!-- Campo Nombre del Rol -->
                    <div class="mb-3">
                        <label class="form-label">Nombre del Rol</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ej: Administrador, Recepcionista" required>
                    </div>

                    <hr>

                    <!-- Sección de Permisos -->
                    <div class="mb-2">
                        <label class="form-label fw-bold mb-3">Permisos de Acceso (Módulos)</label>

                        <div class="row">
                            <!-- Bloque 1: Módulos Generales (9 módulos) -->
                            <div class="col-md-5">
                                <h6 class="text-muted border-bottom pb-1">Módulos Principales</h6>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="dashboard" id="mod_dashboard">
                                    <label class="form-check-label" for="mod_dashboard">Dashboard / Inicio</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="cliente" id="mod_cliente">
                                    <label class="form-check-label" for="mod_cliente">Cliente</label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="envio" id="mod_envio">
                                    <label class="form-check-label" for="mod_envio">Envio</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="pago" id="mod_pago">
                                    <label class="form-check-label" for="mod_pago">Pago</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="despacho" id="mod_despacho">
                                    <label class="form-check-label" for="mod_despacho">Despacho</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="gastodespacho" id="mod_gastodespacho">
                                    <label class="form-check-label" for="mod_gastodespacho">Gasto Despacho</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="reportes" id="mod_reportes">
                                    <label class="form-check-label" for="mod_reportes">Reportes</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="empleados" id="mod_empleados">
                                    <label class="form-check-label" for="mod_empleados">Empleados</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="vehiculos" id="mod_vehiculos">
                                    <label class="form-check-label" for="mod_vehiculos">Vehículos</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="cambiomoneda" id="mod_cambiomoneda">
                                    <label class="form-check-label" for="mod_cambiomoneda">Cambio Moneda</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="usuario" id="mod_usuario">
                                    <label class="form-check-label" for="mod_usuario">Usuario</label>
                                </div>

                            </div>

                            <!-- Bloque 2: Configuración y sus dependencias (1 + 12 módulos) -->
                            <div class="col-md-7">
                                <h6 class="text-muted border-bottom pb-1">Administración del Sistema</h6>

                                <!-- Checkbox Padre: Configuración -->
                                <div class="form-check mb-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="permisos[]" value="configuracion" id="checkConfiguracion">
                                    <label class="form-check-label fw-bold text-primary" for="checkConfiguracion">Configuración</label>
                                </div>

                                <!-- Contenedor de submódulos indentado -->
                                <div class="row ps-4">
                                    <div class="col-sm-6">
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="precio_kilometraje" id="sub_precio" disabled>
                                            <label class="form-check-label text-secondary" for="sub_precio">Precio Kilometraje</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="unidad_medida" id="sub_medida" disabled>
                                            <label class="form-check-label text-secondary" for="sub_medida">Unidad de Medida</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="estado" id="sub_estado" disabled>
                                            <label class="form-check-label text-secondary" for="sub_estado">Estado</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="municipio" id="sub_municipio" disabled>
                                            <label class="form-check-label text-secondary" for="sub_municipio">Municipio</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="cargo" id="sub_cargo" disabled>
                                            <label class="form-check-label text-secondary" for="sub_cargo">Cargo</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="rol" id="sub_rol" disabled>
                                            <label class="form-check-label text-secondary" for="sub_rol">Rol</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="marca" id="sub_marca" disabled>
                                            <label class="form-check-label text-secondary" for="sub_marca">Marca</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="modelo" id="sub_modelo" disabled>
                                            <label class="form-check-label text-secondary" for="sub_modelo">Modelo</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="metodo_pago" id="sub_metodo" disabled>
                                            <label class="form-check-label text-secondary" for="sub_metodo">Método de Pago</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="moneda" id="sub_moneda" disabled>
                                            <label class="form-check-label text-secondary" for="sub_moneda">Moneda</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="banco" id="sub_banco" disabled>
                                            <label class="form-check-label text-secondary" for="sub_banco">Banco</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input config-dependiente" type="checkbox" name="permisos[]" value="cuenta" id="sub_cuenta" disabled>
                                            <label class="form-check-label text-secondary" for="sub_cuenta">Cuenta</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="registrar" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>