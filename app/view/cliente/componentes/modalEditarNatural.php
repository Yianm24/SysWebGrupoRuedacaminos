<div class="modal fade" id="editClienteNatural" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-person-plus"></i> Editar Datos del Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=cliente" method="POST" id="formCliente">
                <div class="modal-body">
                    <input type="hidden" name="cod_cliente" id="cod_cliente">


                    <fieldset id="remitente_natural-fields">
                        <legend class="visually-hidden">Datos de Persona Natural</legend>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="cedula" class="form-label">Cédula</label>
                                <div class="input-group">
                                    <select class="form-select" id="tipo_doc_natural" name="tipo_doc_natural" style="max-width: 80px;" aria-label="Tipo de documento">
                                        <option value="V">V-</option>
                                        <option value="E">E-</option>
                                    </select>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="12345678">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="razon_social" name="razon_social">
                            </div>
                            <div class="col-md-4">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="visually-hidden">Datos de Contacto</legend>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="+58 414 1234567">
                            </div>
                            <div class="col-md-6">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@correo.com">
                            </div>
                        </div>

                    </fieldset>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button name="tipoSolicitud" value="editarNatural" type="submit" class="btn btn-primary"><i class="bi bi-save"></i>Editar</button>
                </footer>
            </form>
        </div>
    </div>
</div>