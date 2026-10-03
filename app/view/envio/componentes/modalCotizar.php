<div class="modal fade" id="cotizarEnvio" tabindex="-1" aria-labelledby="cotizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="cotizarModalLabel"><i class="bi bi-currency-dollar"></i> Cotización</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=cliente" method="POST" id="formCliente">
                <div class="modal-body">

                    <fieldset class="row mb-3">

                        <legend class="h5 fw-bold text-secondary mb-3 pb-2 border-bottom">Datos de la Cotización</legend>

                        <div class="row">
                            <!-- Columna Izquierda: El Mapa y Precio -->
                            <!-- Usamos d-flex y flex-column para que el mapa empuje el precio hacia abajo de forma prolija -->
                            <section class="col-12 col-md-6 mb-4 mb-md-0 d-flex flex-column">

                                <!-- Contenedor del Mapa -->
                                <div class="flex-grow-1 bg-light border rounded d-flex align-items-center justify-content-center p-4">
                                    <!-- <h3 class="text-muted">El mapa</h3> -->
                                    <div id="map" class="rounded"></div>
                                </div>

                                <!-- Contenedor del Precio (Debajo del mapa) -->
                                <div class="alert alert-success text-center shadow-sm mt-3 mb-0" role="alert">
                                    <span class="d-block small fw-bold text-uppercase mb-1 opacity-75">Costo Estimado del Envío</span>
                                    <h3 class="mb-0 fw-bold">$<span id="precio_envio">0.00</span></h3>
                                </div>
                            </section>

                            <!-- Columna Derecha: Formularios -->
                            <section class="col-12 col-md-6">

                                <!-- Bloque 1: Origen -->
                                <div class="mb-3">
                                    <label for="direccion_origen" class="form-label small fw-semibold">Dirección de Origen</label>

                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <select class="form-select form-select-sm" aria-label="Seleccionar Estado">
                                                <option selected>Estado</option>
                                                <option value="lara">Lara</option>
                                                <option value="yaracuy">Yaracuy</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select class="form-select form-select-sm" aria-label="Seleccionar Municipio">
                                                <option selected>Municipio</option>
                                                <option value="iribarren">Iribarren</option>
                                                <option value="palavecino">Palavecino</option>
                                            </select>
                                        </div>
                                    </div>

                                    <textarea id="direccion_origen" class="form-control" rows="2" placeholder="Calle, número, ciudad..." required></textarea>
                                </div>

                                <!-- Bloque 2: Destino -->
                                <div class="mb-3">
                                    <label for="direccion_destino" class="form-label small fw-semibold">Dirección de Destino</label>

                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <select class="form-select form-select-sm" aria-label="Seleccionar Estado Destino">
                                                <option selected>Estado</option>
                                                <option value="lara">Lara</option>
                                                <option value="portuguesa">Portuguesa</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select class="form-select form-select-sm" aria-label="Seleccionar Municipio Destino">
                                                <option selected>Municipio</option>
                                                <option value="araure">Araure</option>
                                                <option value="jimenez">Jiménez</option>
                                            </select>
                                        </div>
                                    </div>

                                    <textarea id="direccion_destino" class="form-control" rows="2" placeholder="Calle, número, ciudad..." required></textarea>
                                </div>

                                <!-- Bloque 3: Kilometraje -->
                                <div class="mb-2">
                                    <label for="kilometraje" class="form-label small fw-semibold">Distancia del Recorrido</label>

                                    <!-- Aquí sí es ideal el input-group -->
                                    <div class="input-group">
                                        <input type="number" class="form-control text-end bg-white" id="kilometraje" placeholder="0.0" step="0.1" readonly>
                                        <span class="input-group-text fw-semibold text-secondary">km</span>
                                    </div>
                                </div>

                            </section>
                        </div>
                    </fieldset>


                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary"><i class="bi bi-save"></i> Calcular</button>
                    <button type="button" class="btn btn-primary"><i class="bi bi-dropbox"></i> Crear</button>

                </footer>

            </form>
        </div>
    </div>
</div>