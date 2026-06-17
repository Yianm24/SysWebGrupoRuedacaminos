<div class="modal fade" id="editClienteJuridico" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-person-plus"></i> Editar Datos del Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=cliente" method="POST" id="formCliente">
                <div class="modal-body">
                    <input type="hidden" name="cod_cliente" id="cod_cliente">





                    <fieldset id="remitente_juridico-fields">
                        <legend>Datos de Persona Jurídica</legend>
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
                                        <option value="P">P-</option>
                                    </select>
                                    <input type="text" class="form-control" id="rif" name="rif" placeholder="12345678-9">
                                </div>
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
                    <button name="tipoSolicitud" value="editarJuridico" type="submit" class="btn btn-primary"><i class="bi bi-save"></i>Editar</button>
                </footer>
            </form>
        </div>
    </div>
</div>