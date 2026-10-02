<div class="modal fade" id="carouselEnvio" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-box-seam"></i> Crear Envio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=envio" method="POST" id="formEnvio">
                <div class="modal-body">
                    <div id="carouselExampleCaptions" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <fieldset class="mb-4">
                                    <legend class="h5 fw-bold text-secondary mb-3 pb-2 border-bottom">Datos de los Clientes</legend>
                                    <div class="row g-4">
                                        <!-- Panel Remitente -->
                                        <div class="col-12 col-lg-6">
                                            <div class="card h-100 shadow-sm border-0 bg-light-subtle">
                                                <div class="card-body p-4">
                                                    <h6 class="card-title fw-bold mb-3 d-flex align-items-center">
                                                        Remitente
                                                    </h6>

                                                    <!-- Selector de Tipo de Persona -->
                                                    <div class="btn-group w-100 mb-3" role="group">
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tipo_persona_remitente" id="persona_natural_remitente" value="remitente_natural" checked>
                                                                <label class="form-check-label" for="persona_natural_remitente">
                                                                    Persona Natural
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tipo_persona_remitente" id="persona_juridica_remitente" value="remitente_juridico">
                                                                <label class="form-check-label" for="persona_juridica_remitente">
                                                                    Persona Jurídica
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Campos Persona Natural (Remitente) -->
                                                    <div id="rem_campos_natural">
                                                        <div class="row g-3">
                                                            <div class="col-md-5">
                                                                <label for="rem_cedula" class="form-label small fw-semibold">Cédula</label>
                                                                <div class="input-group">
                                                                    <select class="form-select flex-grow-0" style="width: 75px;" name="rem_documento_natural">
                                                                        <option value="V">V-</option>
                                                                        <option value="E">E-</option>
                                                                    </select>
                                                                    <input type="text" class="form-control" id="rem_cedula" name="rem_cedula" placeholder="12345678">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <label for="rem_nombre" class="form-label small fw-semibold">Nombre Completo</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="rem_nombre" name="rem_nombre" placeholder="Nombre">
                                                                    <input type="text" class="form-control" id="rem_apellido" name="rem_apellido" placeholder="Apellido">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Campos Persona Jurídica (Remitente) -->
                                                    <div id="rem_campos_juridico" class="d-none">
                                                        <div class="row g-3">
                                                            <div class="col-md-5">
                                                                <label for="rem_rif" class="form-label small fw-semibold">RIF</label>
                                                                <div class="input-group">
                                                                    <select class="form-select flex-grow-0" style="width: 75px;" name="rem_documento_juridico">
                                                                        <option value="J">J-</option>
                                                                        <option value="G">G-</option>
                                                                        <option value="V">V-</option>
                                                                    </select>
                                                                    <input type="text" class="form-control" id="rem_rif" name="rem_rif" placeholder="12345678-0">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <label for="rem_razon_social" class="form-label small fw-semibold">Razón Social</label>
                                                                <input type="text" class="form-control" id="rem_razon_social" name="rem_razon_social" placeholder="Nombre de la empresa">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Contacto Remitente -->
                                                    <div class="row g-3 mt-1">
                                                        <div class="col-md-6">
                                                            <label for="rem_telefono" class="form-label small fw-semibold">Teléfono</label>
                                                            <input type="tel" class="form-control" id="rem_telefono" name="rem_telefono" placeholder="0414 1234567">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="rem_correo" class="form-label small fw-semibold">Correo Electrónico</label>
                                                            <input type="email" class="form-control" id="rem_correo" name="rem_correo" placeholder="remitente@correo.com">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Panel Destinatario -->
                                        <div class="col-12 col-lg-6">
                                            <div class="card h-100 shadow-sm border-0 bg-light-subtle">
                                                <div class="card-body p-4">
                                                    <h6 class="card-title fw-bold mb-3 d-flex align-items-center">
                                                        Destinatario
                                                    </h6>

                                                    <div class="btn-group w-100 mb-3" role="group">
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tipo_persona_destinatario" id="persona_natural_destinatario" value="destinatario_natural" checked>
                                                                <label class="form-check-label" for="persona_natural_destinatario">
                                                                    Persona Natural
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tipo_persona_destinatario" id="persona_juridica_destinatario" value="destinatario_juridico">
                                                                <label class="form-check-label" for="persona_juridica_destinatario">
                                                                    Persona Jurídica
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Campos Persona Natural (Destinatario) -->
                                                    <div id="dest_campos_natural">
                                                        <div class="row g-3">
                                                            <div class="col-md-5">
                                                                <label for="dest_cedula" class="form-label small fw-semibold">Cédula</label>
                                                                <div class="input-group">
                                                                    <select class="form-select flex-grow-0" style="width: 75px;" name="dest_nacionalidad">
                                                                        <option value="V">V-</option>
                                                                        <option value="E">E-</option>
                                                                    </select>
                                                                    <input type="text" class="form-control" id="dest_cedula" name="dest_cedula" placeholder="12345678">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <label for="dest_nombre" class="form-label small fw-semibold">Nombre Completo</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="dest_nombre" name="dest_nombre" placeholder="Nombre">
                                                                    <input type="text" class="form-control" id="dest_apellido" name="dest_apellido" placeholder="Apellido">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Campos Persona Jurídica (Destinatario) -->
                                                    <div id="dest_campos_juridico" class="d-none">
                                                        <div class="row g-3">
                                                            <div class="col-md-5">
                                                                <label for="dest_rif" class="form-label small fw-semibold">RIF</label>
                                                                <div class="input-group">
                                                                    <select class="form-select flex-grow-0" style="width: 75px;" name="dest_tipo_rif">
                                                                        <option value="J">J-</option>
                                                                        <option value="G">G-</option>
                                                                        <option value="V">V-</option>
                                                                    </select>
                                                                    <input type="text" class="form-control" id="dest_rif" name="dest_rif" placeholder="12345678-0">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <label for="dest_razon_social" class="form-label small fw-semibold">Razón Social</label>
                                                                <input type="text" class="form-control" id="dest_razon_social" name="dest_razon_social" placeholder="Nombre de la empresa">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Contacto Destinatario -->
                                                    <div class="row g-3 mt-1">
                                                        <div class="col-md-6">
                                                            <label for="dest_telefono" class="form-label small fw-semibold">Teléfono</label>
                                                            <input type="tel" class="form-control" id="dest_telefono" name="dest_telefono" placeholder="0414 1234567" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="dest_correo" class="form-label small fw-semibold">Correo Electrónico</label>
                                                            <input type="email" class="form-control" id="dest_correo" name="dest_correo" placeholder="destinatario@correo.com" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            

                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-secondary" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev"><i class="bi bi-arrow-left"></i>Anterior</button>
                        <button class="btn btn-outline-primary" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">Siguiente<i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="crear" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>
<script src="assets\js\envio.js">
</script>