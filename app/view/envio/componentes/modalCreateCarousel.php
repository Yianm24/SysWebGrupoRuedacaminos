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
                                    <legend class="h5 fw-bold text-secondary mb-3 pb-2 border-bottom">Datos del Envío</legend>

                                    <div class="row">
                                        <!-- Columna Izquierda: El Mapa y Precio -->
                                        <!-- Usamos d-flex y flex-column para que el mapa empuje el precio hacia abajo de forma prolija -->
                                        <section class="col-12 col-md-6 mb-4 mb-md-0 d-flex flex-column">

                                            <!-- Contenedor del Mapa -->
                                            <div class="flex-grow-1 bg-light border rounded d-flex align-items-center justify-content-center p-4">
                                                <!-- <h3 class="text-muted">El mapa</h3> -->
                                                <div id="mapCrear" class="map rounded"></div>
                                            </div>

                                            <!-- Contenedor del Precio (Debajo del mapa) -->
                                            <div class="alert alert-success text-center shadow-sm mt-3 mb-0" role="alert">
                                                <span class="d-block small fw-bold text-uppercase mb-1 opacity-75">Costo Estimado del Envío</span>
                                                <input type="hidden" name="precio_envio" id="precio_envio_hidden" value="0">
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

                                                <textarea id="direccion_origen" class="form-control" rows="2" placeholder="Calle, número, ciudad..."  ></textarea>
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

                                                <textarea id="direccion_destino" class="form-control" rows="2" placeholder="Calle, número, ciudad..."  ></textarea>
                                            </div>

                                            <!-- Bloque 3: Kilometraje -->
                                            <div class="mb-2">
                                                <label for="kilometraje" class="form-label small fw-semibold">Distancia del Recorrido</label>

                                                <!-- Aquí sí es ideal el input-group -->
                                                <div class="input-group">
                                                    <input type="number" class="form-control text-end bg-white" name="kilometraje" id="kilometraje" placeholder="0.0" step="0.1" readonly>
                                                    <span class="input-group-text fw-semibold text-secondary">km</span>
                                                </div>
                                            </div>

                                        </section>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="carousel-item">
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
                                                            <label for="rem_telefono" class="form-label small fw-semibold" required>Teléfono</label>
                                                            <input type="tel" class="form-control" id="rem_telefono" name="rem_telefono" placeholder="0414 1234567">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="rem_correo" class="form-label small fw-semibold" required>Correo Electrónico</label>
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
                                                                    <select class="form-select flex-grow-0" style="width: 75px;" name="dest_documento_natural">
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
                                                                    <select class="form-select flex-grow-0" style="width: 75px;" name="dest_documento_juridico">
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
                                                            <label for="dest_telefono" class="form-label small fw-semibold" required>Teléfono</label>
                                                            <input type="tel" class="form-control" id="dest_telefono" name="dest_telefono" placeholder="0414 1234567"  >
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="dest_correo" class="form-label small fw-semibold" required>Correo Electrónico</label>
                                                            <input type="email" class="form-control" id="dest_correo" name="dest_correo" placeholder="destinatario@correo.com"  >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                            </div>
                            <div class="carousel-item">
                                <fieldset class="mb-4">
                                    <!-- Usamos un Card para unificar el diseño con el resto del sistema -->
                                    <div class="card shadow-sm border-0 bg-light-subtle">
                                        <div class="card-body p-4">
                                            <legend class="h5 fw-bold text-secondary mb-3 pb-2 border-bottom">Datos de Paquetería</legend>

                                            <!-- Descripción -->
                                            <div class="mb-4">
                                                <label for="descripcion" class="form-label small fw-semibold">Descripción del Contenido</label>
                                                <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="Ej: Ropa, electrónicos, documentos..." required></textarea>
                                            </div>

                                            <!-- Dimensiones y Peso (Agregamos g-3 para separación vertical en móviles) -->
                                            <div class="row g-3 mb-4">

                                                <!-- Alto -->
                                                <div class="col-12 col-sm-6 col-md-3">
                                                    <label for="alto" class="form-label small fw-semibold">Alto</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" class="form-control" id="alto" name="alto" placeholder="0.00" required >
                                                        <span class="input-group-text text-muted">cm</span>
                                                    </div>
                                                </div>

                                                <!-- Ancho -->
                                                <div class="col-12 col-sm-6 col-md-3">
                                                    <label for="ancho" class="form-label small fw-semibold">Ancho</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" class="form-control" id="ancho" name="ancho" placeholder="0.00" required>
                                                        <span class="input-group-text text-muted">cm</span>
                                                    </div>
                                                </div>


                                                <!-- Peso interactivo -->
                                                <div class="col-12 col-sm-6 col-md-3">
                                                    <label for="peso_input" class="form-label small fw-semibold">Peso a sumar</label>
                                                    <!-- Input group con el botón de sumar integrado -->
                                                    <div class="input-group mb-2">
                                                        <input type="number" step="0.01" class="form-control" id="peso_input" name="peso_input" placeholder="0.00">
                                                        <span class="input-group-text text-muted">kg</span>
                                                        <button class="btn btn-secondary" type="button" id="btn_sumar_peso">
                                                            <!-- Icono opcional de suma, o solo texto "+" -->
                                                            +
                                                        </button>
                                                    </div>

                                                    <!-- Fila inferior del peso con el total y el reset -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge text-bg-primary fs-6 py-2 px-3">Total: <span id="peso_total_display">0.00</span> kg</span>
                                                        <button class="btn btn-sm btn-outline-danger" type="button" id="btn_reset_peso">Reset</button>
                                                        <!-- Input oculto para enviar el peso total real en el form -->
                                                        <input type="hidden" name="peso_total" id="peso_total_hidden" value="0">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Switch de Frágil (En un contenedor con un poco de fondo para resaltar) -->
                                            <div class="p-3 bg-white rounded border border-danger-subtle d-inline-block w-100">
                                                <div class="form-check form-switch d-flex align-items-center gap-2 m-0">
                                                    <input class="form-check-input fs-5 m-0" type="checkbox" role="switch" id="articulos_fragil" name="articulos_fragil" value="fragil">
                                                    <label class="form-check-label text-danger fw-bold m-0" for="articulos_fragil">¿Contiene Artículos Frágiles?</label>
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