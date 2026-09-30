<div class="modal fade" id="carouselEnvio" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
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
                                                    <div id="rem_campos_juridico" class="d-none">
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
                            <div class="carousel-item">
                                <fieldset class="mb-3">
                                    <legend class="h5 fw-bold text-secondary mb-3 pb-2 border-bottom">Datos del Envio</legend>
                                </fieldset>

                            </div>
                            <div class="carousel-item">
                                <!-- <fieldset class="mb-3">
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
                                </fieldset> -->
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
                                                        <input type="number" step="0.01" class="form-control" id="alto" name="alto" placeholder="0.00" required>
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

                                                <!-- Largo -->
                                                <div class="col-12 col-sm-6 col-md-3">
                                                    <label for="largo" class="form-label small fw-semibold">Largo</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" class="form-control" id="largo" name="largo" placeholder="0.00" required>
                                                        <span class="input-group-text text-muted">cm</span>
                                                    </div>
                                                </div>

                                                <!-- Peso interactivo -->
                                                <div class="col-12 col-sm-6 col-md-3">
                                                    <label for="peso_input" class="form-label small fw-semibold">Peso a sumar</label>
                                                    <!-- Input group con el botón de sumar integrado -->
                                                    <div class="input-group mb-2">
                                                        <input type="number" step="0.01" class="form-control" id="peso_input" placeholder="0.00">
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
                                                    <input class="form-check-input fs-5 m-0" type="checkbox" role="switch" id="articulos_fragil" name="articulos_fragil">
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