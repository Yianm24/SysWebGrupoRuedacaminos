<div class="modal fade" id="registerEmpleado" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">          
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">     
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-person-plus"></i> Registro de Empleado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>
 
            <form action="?url=empleado" method="POST" id="formEmpleado">
                <div class="modal-body">
                    <!-- <input type="hidden" name="id" id="empleado_id"> -->

                    <!-- <fieldset class="mb-4">
                        <legend class="visually-hidden">Tipo de Persona</legend>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_persona_remitente" id="persona_natural" value="remitente_natural" checked>
                                <label class="form-check-label" for="persona_natural">Persona Natural</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_persona_remitente" id="persona_juridica" value="remitente_juridico">
                                <label class="form-check-label" for="persona_juridica">Persona Jurídica</label>
                            </div>
                        </div>
                    </fieldset> -->

                    <fieldset>
                        <legend class="visually-hidden">Datos de Empleado</legend>
                        <div class="row mb-3">
                            <div class="col-md-3 mb-md-0">
                                <label for="cedula" class="form-label">Cédula</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="12345678">
                                </div>
                            </div>
                            <div class="col-md-3 mb-md-0">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <div class="col-md-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido">
                            </div>
                            
                            <div class="col-md-3">
                                        <label for="estado_operativo" class="form-label">Cargo</label>
                                        <select class="form-select" id="estado_operativo" name="estado_operativo" required>
                                            <option value="recepcionista">Recepcionista</option>
                                            <option value="chofer">Chofer</option>
                                            <option value="administrador">Administrador</option>
                                        </select>
                                    </div>
                        </div>
                    </fieldset>

                    <!-- <fieldset id="remitente_juridico-fields" style="display: none;">
                        <legend class="visually-hidden">Datos de Persona Jurídica</legend>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="razon_social" class="form-label">Razón Social</label>
                                <input type="text" class="form-control" id="razon_social" name="razon_social">
                            </div>
                            <div class="col-md-6">
                                <label for="rif" class="form-label">RIF</label>
                                <div class="input-group">
                                    <select class="form-select" id="tipo_doc_juridico" name="tipo_doc_juridico" style="max-width: 80px;" aria-label="Tipo de documento jurídico">
                                        <option value="J">J-</option>
                                        <option value="G">G-</option>
                                        <option value="V">V-</option>
                                        <option value="P">P-</option>
                                    </select>
                                    <input type="text" class="form-control" id="rif" name="rif" placeholder="12345678-9">
                                </div>
                            </div>
                        </div>
                    </fieldset> -->

                    <fieldset>
                        <legend class="visually-hidden">Datos de Contacto</legend>
                        <div class="row mb-3">
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="+58 414 1234567" required>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="telefono" class="form-label">Teléfono Emergencia</label>
                                <input type="tel" class="form-control" id="telefono-emergencia" name="telefono-emergencia" placeholder="+58 414 7778654" required>
                            </div>

                            <div class="col-md-6">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ej. Pueblo Nuevo, Calle 12" required>
                            </div>
                        </div>
                    </fieldset>
                </div>
                
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>