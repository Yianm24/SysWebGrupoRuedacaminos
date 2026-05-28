<div class="modal fade" id="registerFlota" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-person-plus"></i> Registro de Vehículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=flota" method="POST" id="formFlota">
                <div class="modal-body">

                    <fieldset>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="placa" class="form-label">Placa</label>
                                <input type="text" class="form-control" id="placa" name="placa" placeholder="Ej: ABC12D" required>
                            </div>
                            <div class="col-md-6">
                                <label for="color" class="form-label">Color:</label>
                                <input type="text" class="form-control" id="color" name="color" required>
                            </div>

                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="col-md-6">

                                    <label for="tipo_punto" class="form-label">Ubicación destino</label>
                                    <select class="form-select" id="ubicacion" name="ubicacion_select" required>
                                        <option value="" selected disabled>Seleccionar Ubicación...</option>
                                        <option value="1">Caracas</option>
                                        <option value="2">Valencia</option>
                                        <option value="3">Maracaibo</option>
                                        <option value="4">Barquisimeto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="estado_operativo" class="form-label">Estado Operativo</label>
                                <select class="form-select" id="estado_operativo" name="estado_operativo" required>
                                    <option value="disponible">Disponible</option>
                                    <option value="en_ruta">En Ruta</option>
                                    <option value="en_taller">En Taller</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="input-group ">
                                    <select class="form-select" id="marca">
                                        <option selected>Marca</option>
                                        <option value="1">Fiat</option>
                                        <option value="2">Mitsubishi</option>
                                        <option value="3">Renoult</option>
                                    </select>
                                    <select class="form-select" id="modelo">
                                        <option selected>Modelo</option>
                                        <option value="1">Fiesta</option>
                                        <option value="2">Canguro</option>
                                        <option value="3">Fiorino</option>
                                    </select>
                                    <input type="text" class="form-control" id="year" name="year" placeholder="Año:" required>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                </footer>
            </form>
        </div>
    </div>
</div>