<div class="modal fade" id="carouselEnvio" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-box-seam"></i> Crear Envio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=cliente" method="POST" id="formCliente">
                <div class="modal-body">
                    <div id="carouselExampleCaptions" class="carousel slide">
                        <!--<div class="carousel-indicators" style="background-color:aqua;">
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>-->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <!-- <fieldset class="mb-3">
                                    <legend>Datos de Clientes</legend>
                                    <div class="col">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Remitente</label>
                                            <div class="d-flex gap-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipo_persona_remitente" id="persona_natural" value="remitente_natural" checked>
                                                    <label class="form-check-label" for="persona_natural">
                                                        Persona Natural
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipo_persona_remitente" id="persona_juridica" value="remitente_juridico">
                                                    <label class="form-check-label" for="persona_juridica">
                                                        Persona Jurídica
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Campos de Persona Natural -->
                                <!-- <div id="remitente_natural-fields">
                                            <div class="row mb-3 ">
                                                <div class="col-12 mb-3">
                                                    <label for="cedula" class="form-label">Cédula</label>
                                                    <input type="text" class="form-control" id="cedula" name="cedula">
                                                </div>

                                                <div class="col-12 input-group ">
                                                    <span class="input-group-text">Nombre Completo</span>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre:">
                                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido:">
                                                </div>


                                            </div>
                                        </div>

                                        <!-- Campos de Persona Jurídica -->
                                <!-- <div id="remitente_juridico-fields" style="display: none;">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="razon_social" class="form-label">Razón Social</label>
                                                    <input type="text" class="form-control" id="razon_social" name="razon_social">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="rif" class="form-label">RIF</label>
                                                    <input type="text" class="form-control" id="rif" name="rif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Destinatario</label>
                                            <div class="d-flex gap-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipo_persona_destinatario" id="persona_natural" value="destinatario_natural" checked>
                                                    <label class="form-check-label" for="persona_natural">
                                                        Persona Natural
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="tipo_persona_destinatario" id="persona_juridica" value="destinatario_juridico">
                                                    <label class="form-check-label" for="persona_juridica">
                                                        Persona Jurídica
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="destinatario_natural-fields">
                                            <div class="row mb-3">
                                                <div class="col-4">
                                                    <label for="cedula" class="form-label">Cédula</label>
                                                    <input type="text" class="form-control" id="cedula" name="cedula">
                                                </div>
                                                <div class="col-4">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                                </div>
                                                <div class="col-4">
                                                    <label for="apellido" class="form-label">Apellido</label>
                                                    <input type="text" class="form-control" id="apellido" name="apellido">
                                                </div>

                                            </div>
                                        </div> -->

                                <!-- Campos de Persona Jurídica -->
                                <!-- <div id="destinatario_juridico-fields" style="display: none;">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="razon_social" class="form-label">Razón Social</label>
                                                    <input type="text" class="form-control" id="razon_social" name="razon_social">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="rif" class="form-label">RIF</label>
                                                    <input type="text" class="form-control" id="rif" name="rif">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="telefono" class="form-label">Teléfono</label>
                                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="+58 414 1234567" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="correo" class="form-label">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset> -->

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
                                                                <input class="form-check-input" type="radio" name="tipo_persona_remitente" id="persona_natural" value="remitente_natural" checked>
                                                                <label class="form-check-label" for="persona_natural">
                                                                    Persona Natural
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tipo_persona_remitente" id="persona_juridica" value="remitente_juridico">
                                                                <label class="form-check-label" for="persona_juridica">
                                                                    Persona Jurídica
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Campos Persona Natural (Remitente) -->
                                                    <div id="rem_campos_natural" class="d-none">
                                                        <div class="row g-3">
                                                            <div class="col-md-5">
                                                                <label for="rem_cedula" class="form-label small fw-semibold">Cédula</label>
                                                                <div class="input-group">
                                                                    <select class="form-select flex-grow-0" style="width: 75px;" name="rem_nacionalidad">
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
                                                    <div id="rem_campos_juridico">
                                                        <div class="row g-3">
                                                            <div class="col-md-5">
                                                                <label for="rem_rif" class="form-label small fw-semibold">RIF</label>
                                                                <div class="input-group">
                                                                    <select class="form-select flex-grow-0" style="width: 75px;" name="rem_tipo_rif">
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
                                                                <input class="form-check-input" type="radio" name="tipo_persona_destinatario" id="persona_natural" value="destinatario_natural" checked>
                                                                <label class="form-check-label" for="persona_natural">
                                                                    Persona Natural
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tipo_persona_destinatario" id="persona_juridica" value="destinatario_juridico">
                                                                <label class="form-check-label" for="persona_juridica">
                                                                    Persona Jurídica
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Campos Persona Natural (Destinatario) -->
                                                    <div id="des_campos_natural">
                                                        <div class="row g-3">
                                                            <div class="col-md-5">
                                                                <label for="des_cedula" class="form-label small fw-semibold">Cédula</label>
                                                                <div class="input-group">
                                                                    <select class="form-select flex-grow-0" style="width: 75px;" name="des_nacionalidad">
                                                                        <option value="V">V-</option>
                                                                        <option value="E">E-</option>
                                                                    </select>
                                                                    <input type="text" class="form-control" id="des_cedula" name="des_cedula" placeholder="12345678">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <label for="des_nombre" class="form-label small fw-semibold">Nombre Completo</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="des_nombre" name="des_nombre" placeholder="Nombre">
                                                                    <input type="text" class="form-control" id="des_apellido" name="des_apellido" placeholder="Apellido">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Campos Persona Jurídica (Destinatario) -->
                                                    <div id="des_campos_juridico" class="d-none">
                                                        <div class="row g-3">
                                                            <div class="col-md-5">
                                                                <label for="des_rif" class="form-label small fw-semibold">RIF</label>
                                                                <div class="input-group">
                                                                    <select class="form-select flex-grow-0" style="width: 75px;" name="des_tipo_rif">
                                                                        <option value="J">J-</option>
                                                                        <option value="G">G-</option>
                                                                        <option value="V">V-</option>
                                                                    </select>
                                                                    <input type="text" class="form-control" id="des_rif" name="des_rif" placeholder="12345678-0">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <label for="des_razon_social" class="form-label small fw-semibold">Razón Social</label>
                                                                <input type="text" class="form-control" id="des_razon_social" name="des_razon_social" placeholder="Nombre de la empresa">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Contacto Destinatario -->
                                                    <div class="row g-3 mt-1">
                                                        <div class="col-md-6">
                                                            <label for="des_telefono" class="form-label small fw-semibold">Teléfono</label>
                                                            <input type="tel" class="form-control" id="des_telefono" name="des_telefono" placeholder="0414 1234567" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="des_correo" class="form-label small fw-semibold">Correo Electrónico</label>
                                                            <input type="email" class="form-control" id="des_correo" name="des_correo" placeholder="destinatario@correo.com" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="carousel-item">
                                <!-- <fieldset class="mb-3">
                                    <legend>Datos del Envio</legend>
                                    <div class="row mb-3">
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
                                        <div class="col-md-6">
                                            <label for="ubicacion" class="form-label">Ubicación despacho</label>
                                            <select class="form-select" id="ubicacion" name="ubicacion_select" required>
                                                <option value="" selected disabled>Seleccionar Ubicación...</option>
                                                <option value="1">Caracas</option>
                                                <option value="2">Valencia</option>
                                                <option value="3">Maracaibo</option>
                                                <option value="4">Barquisimeto</option>
                                            </select>
                                        </div>

                                    </div>
                                    <label for="kilometraje" class="form-label">Kilometraje Estimado</label>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="vehiculo" class="form-label">Vehiculo</label>
                                            <select class="form-select" id="vehiculo" name="vehiculo_select" required>
                                                <option value="" selected disabled>Seleccionar vehiculo...</option>
                                                <option value="1">Fiat AD543ED</option>
                                                <option value="2">Mitsubishi A17BN1E</option>
                                                <option value="3">Renault Canguro A19BQ78</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="chofer" class="form-label">Chofer</label>
                                            <select class="form-select" id="chofer" name="chofer_select" required>
                                                <option value="" selected disabled>Seleccionar chofer...</option>
                                                <option value="1">Ruben Perez</option>
                                                <option value="2">Alimir Perez</option>
                                                <option value="3">Alison Perez</option>

                                            </select>
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-3 md-4">
                                            <label for="fecha_solicitud" class="form-label">Fecha de Envio</label>
                                            <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud" value="<?= date('Y-m-d') ?>" readonly>
                                        </div>
                                        <div class="col-3 md-4">
                                            <label for="kilometraje" class="form-label">Cliente Pago:</label>
                                            <select class="form-select" id="Chofer" name="Chofer" required>
                                                <option value="1">50%</option>
                                                <option value="2">+50%</option>
                                                <option value="3">Monto Completo</option>

                                            </select>
                                        </div>
                                        <div class="col-6 md-4 ">
                                            <label for="pago_envio" class="form-label">Pago del Envio:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Pago Incial" aria-label="Dollar amount (with dot and two decimal places)">
                                                <span class="input-group-text">Monto Total:</span>
                                                <span class="input-group-text">Bs</span>
                                                <span class="input-group-text">0.00</span>
                                                <span class="input-group-text">$</span>
                                                <span class="input-group-text">0.00</span>
                                            </div>
                                            </br>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="metodos" class="form-label">Metodo de Pago</label>
                                                    <select class="form-select" id="metodos" name="metodos" required>
                                                        <option value="" selected disabled>Metodos...</option>
                                                        <option value="1">Pago Movil</option>
                                                        <option value="2">Transferencia</option>
                                                        <option value="3">Divisa</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="chofer" class="form-label">Cuenta Destino</label>
                                                    <select class="form-select" id="Chofer" name="Chofer" required>
                                                        <option value="" selected disabled>Seleccionar banco...</option>
                                                        <option value="1">Banesco</option>
                                                        <option value="2">Venezuela</option>

                                                    </select>
                                                </div>

                                                <div class="col-12 ">
                                                    <label for="alto" class="form-label">Referencia</label>
                                                    <input type="number" step="0.01" class="form-control" id="alto" name="alto" required>
                                                </div>
                                            </div>

                                        </div>
                                </fieldset> -->
                                <fieldset class="mb-3">
                                    <legend class="h5 fw-bold text-secondary mb-3 pb-2 border-bottom">Datos del Envio</legend>
                                </fieldset>

                            </div>
                            <div class="carousel-item">
                                <fieldset class="mb-3">
                                    <legend class="h5 fw-bold text-secondary mb-3 pb-2 border-bottom">Paqueteria</legend>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción del Contenido</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                                    </div>

                                    <div class="row mb-3">

                                        <div class="col-md-3">
                                            <label for="alto" class="form-label">Alto Total (cm)</label>
                                            <input type="number" step="0.01" class="form-control" id="alto" name="alto" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="ancho" class="form-label">Ancho Total(cm)</label>
                                            <input type="number" step="0.01" class="form-control" id="ancho" name="ancho" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="largo" class="form-label">Largo Total(cm)</label>
                                            <input type="number" step="0.01" class="form-control" id="largo" name="largo" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="alto" class="form-label">Peso</label>
                                            <div class=" input-group">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon1">Sumar</button>
                                                <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                            </div>
                                            </br>
                                            <button class="btn btn-secondary" type="button" id="button-addon1">Reset</button>
                                            <label class="form-label">Peso total aqui Kg</label>


                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="articulos_fragil" name="articulos_fragil">
                                            <label class="form-check-label text-danger fw-bold" for="articulos_fragil">¿Contiene Artículos Frágiles?</label>
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
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>
<script src="assets\js\envio.js">
    // document.addEventListener("DOMContentLoaded", function() {

    //     // Lógica para alternar campos de Persona Natural o Jurídica en el Módulo de Clientes
    //     const tipoPersona_remitente = document.querySelectorAll('input[name="tipo_persona_remitente"]');
    //     const remitente_natural = document.getElementById('remitente_natural-fields');
    //     const remitente_juridico = document.getElementById('remitente_juridico-fields');

    //     if (tipoPersona_remitente.length > 0 && remitente_natural && remitente_juridico) {
    //         tipoPersona_remitente.forEach(input => {
    //             input.addEventListener('change', function() {
    //                 if (this.value === 'remitente_natural') {
    //                     console.log('Remitente Natural seleccionado');
    //                     remitente_natural.style.display = 'block';
    //                     remitente_juridico.style.display = 'none';
    //                 } else if (this.value === 'remitente_juridico') {
    //                     console.log('Remitente Jurídico seleccionado');
    //                     remitente_natural.style.display = 'none';
    //                     remitente_juridico.style.display = 'block';
    //                 }
    //             });
    //         });
    //     }

    //     const tipoPersona_destinatario = document.querySelectorAll('input[name="tipo_persona_destinatario"]');
    //     const destinatario_natural = document.getElementById('destinatario_natural-fields');
    //     const destinatario_juridico = document.getElementById('destinatario_juridico-fields');

    //     if (tipoPersona_destinatario.length > 0 && destinatario_natural && destinatario_juridico) {
    //         tipoPersona_destinatario.forEach(input => {
    //             input.addEventListener('change', function() {
    //                 if (this.value === 'destinatario_natural') {
    //                     destinatario_natural.style.display = 'block';
    //                     destinatario_juridico.style.display = 'none';
    //                 } else if (this.value === 'destinatario_juridico') {
    //                     destinatario_natural.style.display = 'none';
    //                     destinatario_juridico.style.display = 'block';
    //                 }
    //             });
    //         });
    //     }
    // });
</script>