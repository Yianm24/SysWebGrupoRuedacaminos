<div class="modal fade" id="cotizarEnvio" tabindex="-1" aria-labelledby="cotizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="cotizarModalLabel"><i class="bi bi-currency-dollar"></i> Cotización</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=cliente" method="POST" id="formCliente">
                <div class="modal-body">

                    <fieldset class="row mb-3">

                        <div class="col-md-12">
                            <label for="categoria_vehiculo" class="form-label">Datos de Paqueteria</label>
                            <div class="input-group ">
                                <input type="number" step="0.01" class="form-control" id="alto" name="alto" placeholder="Alto:" required>
                                <input type="number" step="0.01" class="form-control" id="largo" name="largo" placeholder="Largo:" required>
                                <input type="number" step="0.01" class="form-control" id="ancho" name="ancho" placeholder="Ancho:" required>
                                <input type="text" class="form-control" id="peso" name="peso" placeholder="Peso:" required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="row mb-3">
                        <div class="col-md-4">

                            <label for="categoria_vehiculo" class="form-label">Tipo Vehiculo a Utilizar</label>
                            <select class="form-select" id="categoria_vehiculo" name="categoria_vehiculo" required>
                                <option value="pequeño">Camioneta pequeña</option>
                                <option value="grande">Camioneta grande</option>
                                <option value="gigante">Camion</option>
                            </select>
                        </div>
                        <div class="col-md-4">

                            <label for="tipo_punto" class="form-label">Ubicación destino</label>
                            <select class="form-select" id="ubicacion" name="ubicacion_select" required>
                                <option value="" selected disabled>Seleccionar Ubicación...</option>
                                <option value="1">Caracas</option>
                                <option value="2">Valencia</option>
                                <option value="3">Maracaibo</option>
                                <option value="4">Barquisimeto</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="ubicacion" class="form-label">Ubicación despacho</label>
                            <select class="form-select" id="ubicacion" name="ubicacion_select" required>
                                <option value="" selected disabled>Seleccionar Ubicación...</option>
                                <option value="1">Caracas</option>
                                <option value="2">Valencia</option>
                                <option value="3">Maracaibo</option>
                                <option value="4">Barquisimeto</option>
                            </select>
                        </div>
                    </fieldset>


                </div>

                <footer class="modal-footer">
                    <div class="row bg-white ">
                        <div class="col align-self-center">
                            <h5 class="mb-0">Precio de envio aqui</h5>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary"><i class="bi bi-save"></i> Calcular</button>
                    <button type="button" class="btn btn-primary"><i class="bi bi-dropbox"></i> Crear</button>

                </footer>

            </form>
        </div>
    </div>
</div>