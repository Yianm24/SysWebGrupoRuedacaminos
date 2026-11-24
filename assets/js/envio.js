$(document).ready(function () {

    const miTabla = instanciarDatatableGlobal('#tablaEnvio');

    dibujarTabla(miTabla);

    const modal = $('#carouselEnvio');

    const selectModal_dest = $('select#municipio_destino');
    const selectModal_desp = $('select#municipio_despacho');

    dibujarSelect(selectModal_dest);
    dibujarSelect(selectModal_desp);

    if (modal) {
        modal.on('show.bs.modal', (event) => {
            const boton = event.relatedTarget;
            if (typeof AccionModal === "function") {
                AccionModal(boton);
            }
        });

        $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
            event.preventDefault();

            const remitente = obtenerValoreCliente('remitente', 'rem');
            const destinatario = obtenerValoreCliente('destinatario', 'dest');
            const articuloFragil = $("#articulos_fragil").is(":checked") ? 1 : 0;

            const despacho = {
                municipio: $('#municipio_despacho').val(),
                direccion: $('textarea[name="direccion_despacho"]').val().trim()
            };

            const destino = {
                municipio: $('#municipio_destino').val(),
                direccion: $('textarea[name="direccion_destino"]').val().trim()
            };

            const datos = {
                cod_envio: $("#cod_envio").val(),
                ancho: $("#ancho").val(),
                alto: $("#alto").val(),
                descripcion: $("#descripcion").val(),
                peso_total: $("#peso_total").val(),
                kilometraje: $('input[name="kilometraje"]').val(),
                articuloFragil: articuloFragil,
                despacho: despacho,
                destino: destino,
                remitente: remitente,
                destinatario: destinatario
            };

            const btnEnviar = this;
            const solicitud = $(this).val();

            const objmodal = bootstrap.Modal.getInstance(modal[0]) ?? null;

            ajaxEnvioDatosGlobal('envio', solicitud, dibujarTabla, miTabla, datos, objmodal, btnEnviar);
        });
    } 

    $("#tablaEnvio tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();

        const codenvio = this.getAttribute("data-cod-envio");

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success ms-2",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Está seguro que desea eliminar este registro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxEnvioDatosGlobal('envio', 'eliminar', dibujarTabla, miTabla, { cod_envio: codenvio }, null, null);
            }
        }); // <-- Fin de swalWithBootstrapButtons.fire().then()
    }); // <-- Fin del click en .btn-eliminar

}); // <-- Fin de $(document).ready()

function dibujarTabla(objTable) {

    const modulo = 'envio';
    ajaxConsultarGlobal(modulo, (response) => {

        objTable.clear();

        let lista = Array.isArray(response) ? response : [];

        if (lista.length > 0) {

            $.each(lista, function (index, dato) {

                console.log(dato.dest_nombre);
                const botones = `<td class="text-start pe-4">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Modificar" data-bs-toggle="modal" data-bs-target="#carouselEnvio"
                                 datos-cod-envio="${dato.cod_envio}"
                                 datos-estado="${dato.estado}"
                                 datos-municipio-despacho="${dato.cod_municipio_origen ?? ''}"
                                 datos-direccion-despacho="${dato.direccion_origen ?? ''}"
                                 datos-municipio-destino="${dato.cod_municipio_destino ?? ''}"
                                 datos-direccion-destino="${dato.direccion_destino ?? ''}"
                                 datos-kilometraje="${dato.distancia_total ?? 0}"
                                 datos-monto-total="${dato.monto_total ?? 0}"
                                 datos-rem-tipo-doc="${dato.rem_tipo_doc ?? 'V'}"
                                 datos-rem-doc="${dato.rem_doc ?? ''}"
                                 datos-rem-nombre="${dato.rem_nombre ?? ''}"
                                 datos-rem-apellido="${dato.rem_apellido ?? ''}"
                                 datos-rem-telefono="${dato.rem_telefono ?? ''}"
                                 datos-rem-correo="${dato.rem_correo ?? ''}"
                                 datos-dest-tipo-doc="${dato.dest_tipo_doc ?? 'V'}"
                                 datos-dest-doc="${dato.dest_doc ?? ''}"
                                 datos-dest-nombre="${dato.dest_nombre ?? ''}"
                                 datos-dest-apellido="${dato.dest_apellido ?? ''}"
                                 datos-dest-telefono="${dato.dest_telefono ?? ''}"
                                 datos-dest-correo="${dato.dest_correo ?? ''}"
                                 datos-descripcion="${dato.descrip_contenido ?? ''}"
                                 datos-alto="${dato.altura ?? ''}"
                                 datos-ancho="${dato.anchura ?? ''}"
                                 datos-peso-total="${dato.peso_total ?? 0}"
                                 datos-estatus-fragil="${dato.estatus_fragil ?? 0}"
                                 >
                                 <i class="bi bi-pencil"></i>
                             </button>
                         <a href="#" class="text-secondary btn-eliminar"
                                 data-cod-envio="${dato.cod_envio}" >
                                 <i class="bi bi-trash"></i>
                         </a>
                     </td>`;
                objTable.row.add([
                    dato.rem_tipo_doc+ '-' +dato.rem_doc + '-' + dato.rem_nombre + ' ' + (dato.rem_apellido ?? ''),
                    dato.dest_tipo_doc+ '-' +dato.dest_doc + '-' + dato.dest_nombre + ' ' + (dato.dest_apellido ?? ''),
                    dato.direccion_destino,
                    dato.descrip_contenido,
                    dato.peso_total,
                    dato.estatus,
                    dato.fecha,
                    botones
                ])
            })
            objTable.draw();
        }
    })
}


function dibujarSelect(objtSelect) {

    $.ajax({
        url: 'index.php?url=municipio',
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: "consultarToSelect"
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Procesando...',
                text: 'Por favor espere un momento.',
                allowOutsideClick: false,
                didOpen: () => {
                    if (document.activeElement) document.activeElement.blur();
                    Swal.showLoading();
                }
            });
        }
    })
        .done(function (response) {
            let opciones = "";
            const data=response;
        $.each(data, function (index, dato) {
            opciones += `
         <option value=${dato.cod_municipio}>${dato.nombre_municipio}</option>
        `
        })
        $(objtSelect).html(opciones);

        })
        .fail(function (xhr, status, error) {
            console.error("Error al cargar los datos:", error);
            console.log("Respuesta cruda del servidor:", xhr.responseText);
        })
        .always(function () {
            Swal.close();
        })
}

function AccionModal(boton) {
    const encabezadoModal = $('#registerModalLabel');
    const botonModal = $('#carouselEnvio button[name="tipoSolicitud"]');

    // Reiniciar el carrusel al primer slide siempre que se abre el modal
    const carouselEl = document.getElementById('carouselExampleCaptions');
    if (carouselEl) {
        const carouselInstance = bootstrap.Carousel.getOrCreateInstance(carouselEl);
        carouselInstance.to(0);
    }

    // Limpiar estilos de validación previos si existen
    $('#formEnvio input, #formEnvio select, #formEnvio textarea').removeClass('is-valid is-invalid');
    $('#formEnvio .mensaje-error').text('');

    // Referencias a los campos del formulario dentro del modal
    const inputCodEnvio = $('#cod_envio');
    const selectMunicipioDespacho = $('#municipio_despacho');
    const inputDireccionDespacho = $('#direccion_despacho');
    const selectMunicipioDestino = $('#municipio_destino');
    const inputDireccionDestino = $('#direccion_destino');
    const inputKilometraje = $('input#kilometraje');
    const inputPrecioHidden = $('#precio_envio_hidden');
    const spanPrecioEnvio = $('#precio_envio');

    // Remitente
    const selectRemDocNat = $('#rem_documento_natural');
    const inputRemCedula = $('#rem_cedula');
    const inputRemNombre = $('#rem_nombre');
    const inputRemApellido = $('#rem_apellido');
    const selectRemDocJur = $('#rem_documento_juridico');
    const inputRemRif = $('#rem_rif');
    const inputRemRazonSocial = $('#rem_razon_social');
    const inputRemTelefono = $('#rem_telefono');
    const inputRemCorreo = $('#rem_correo');

    // Destinatario
    const selectDestDocNat = $('#dest_documento_natural');
    const inputDestCedula = $('#dest_cedula');
    const inputDestNombre = $('#dest_nombre');
    const inputDestApellido = $('#dest_apellido');
    const selectDestDocJur = $('#dest_documento_juridico');
    const inputDestRif = $('#dest_rif');
    const inputDestRazonSocial = $('#dest_razon_social');
    const inputDestTelefono = $('#dest_telefono');
    const inputDestCorreo = $('#dest_correo');

    // Paquetería
    const inputDescripcion = $('#descripcion');
    const inputAlto = $('#alto');
    const inputAncho = $('#ancho');
    const inputPesoSumar = $('#peso_sumar');
    const inputPesoTotal = $('#peso_total');
    const checkFragil = $('#articulos_fragil');

    // 1. Limpiar TODOS los inputs al inicio para que no queden datos viejos ("inputs sucios")
    inputCodEnvio.val("");
    selectMunicipioDespacho.val("").prop('selectedIndex', 0);
    inputDireccionDespacho.val("");
    selectMunicipioDestino.val("").prop('selectedIndex', 0);
    inputDireccionDestino.val("");
    inputKilometraje.val("");
    inputPrecioHidden.val("0");
    spanPrecioEnvio.text("0.00");

    radioNaturalRem.prop("checked", true);
    selectRemDocNat.val("V");
    inputRemCedula.val("");
    inputRemNombre.val("");
    inputRemApellido.val("");
    selectRemDocJur.val("J");
    inputRemRif.val("");
    inputRemRazonSocial.val("");
    inputRemTelefono.val("");
    inputRemCorreo.val("");

    radioNaturalDest.prop("checked", true);
    selectDestDocNat.val("V");
    inputDestCedula.val("");
    inputDestNombre.val("");
    inputDestApellido.val("");
    selectDestDocJur.val("J");
    inputDestRif.val("");
    inputDestRazonSocial.val("");
    inputDestTelefono.val("");
    inputDestCorreo.val("");

    actualizarFormulario("remitente");
    actualizarFormulario("destinatario");

    inputDescripcion.val("");
    inputAlto.val("");
    inputAncho.val("");
    inputPesoSumar.val("");
    inputPesoTotal.val("0");
    checkFragil.prop("checked", false);

    // 2. Diferenciar la acción según el botón que llamó al modal (Crear vs Modificar)
    const accion = ($(boton).attr('title') || '').toLowerCase();

    switch (accion) {
        case "crear":
            encabezadoModal.html('<i class="bi bi-box-seam me-2"></i> Crear Envío');
            botonModal.val("crear");
            botonModal.html('<i class="bi bi-save"></i> Registrar');
            break;

        case "modificar":

            encabezadoModal.html('<i class="bi bi-box-seam me-2"></i> Modificar Envío');
            botonModal.val("modificar");
            botonModal.html('<i class="bi bi-save"></i> Modificar');

            // Obtener los datos desde los atributos datos- del botón
            const cod_envio = $(boton).attr('datos-cod-envio');
            const estado = $(boton).attr('datos-estado');

            if (cod_envio !== "" && estado == 1) {
                const municipio_despacho = $(boton).attr('datos-municipio-despacho');
                const direccion_despacho = $(boton).attr('datos-direccion-despacho');
                const municipio_destino = $(boton).attr('datos-municipio-destino');
                const direccion_destino = $(boton).attr('datos-direccion-destino');
                const kilometraje = parseFloat($(boton).attr('datos-kilometraje')) || 0;
                const monto_total = parseFloat($(boton).attr('datos-monto-total')) || (kilometraje * 2.36);

                const rem_tipo_doc = $(boton).attr('datos-rem-tipo-doc');
                const rem_doc = $(boton).attr('datos-rem-doc');
                const rem_nombre = $(boton).attr('datos-rem-nombre');
                const rem_apellido = $(boton).attr('datos-rem-apellido');
                const rem_telefono = $(boton).attr('datos-rem-telefono');
                const rem_correo = $(boton).attr('datos-rem-correo');

                const dest_tipo_doc = $(boton).attr('datos-dest-tipo-doc');
                const dest_doc = $(boton).attr('datos-dest-doc');
                const dest_nombre = $(boton).attr('datos-dest-nombre');
                const dest_apellido = $(boton).attr('datos-dest-apellido');
                const dest_telefono = $(boton).attr('datos-dest-telefono');
                const dest_correo = $(boton).attr('datos-dest-correo');

                const descripcion = $(boton).attr('datos-descripcion');
                const alto = $(boton).attr('datos-alto');
                const ancho = $(boton).attr('datos-ancho');
                const peso_total = $(boton).attr('datos-peso-total');
                const estatus_fragil = $(boton).attr('datos-estatus-fragil');

                // Autocompletar Datos del Envío
                inputCodEnvio.val(cod_envio);
                selectMunicipioDespacho.val(municipio_despacho);
                inputDireccionDespacho.val(direccion_despacho);
                selectMunicipioDestino.val(municipio_destino);
                inputDireccionDestino.val(direccion_destino);
                inputKilometraje.val(kilometraje);
                inputPrecioHidden.val(monto_total.toFixed(2));
                spanPrecioEnvio.text(monto_total.toFixed(2));

                // Autocompletar Remitente (Natural vs Jurídica)
                if (['J', 'G', 'P', 'C'].includes(rem_tipo_doc)) {
                    radioJuridicaRem.prop("checked", true);
                    selectRemDocJur.val(rem_tipo_doc);
                    inputRemRif.val(rem_doc);
                    inputRemRazonSocial.val(rem_nombre);
                } else {
                    radioNaturalRem.prop("checked", true);
                    selectRemDocNat.val(rem_tipo_doc || 'V');
                    inputRemCedula.val(rem_doc);
                    inputRemNombre.val(rem_nombre);
                    inputRemApellido.val(rem_apellido);
                }
                inputRemTelefono.val(rem_telefono);
                inputRemCorreo.val(rem_correo);
                actualizarFormulario("remitente");

                // Autocompletar Destinatario (Natural vs Jurídica)
                if (['J', 'G', 'P', 'C'].includes(dest_tipo_doc)) {
                    radioJuridicaDest.prop("checked", true);
                    selectDestDocJur.val(dest_tipo_doc);
                    inputDestRif.val(dest_doc);
                    inputDestRazonSocial.val(dest_nombre);
                } else {
                    radioNaturalDest.prop("checked", true);
                    selectDestDocNat.val(dest_tipo_doc || 'V');
                    inputDestCedula.val(dest_doc);
                    inputDestNombre.val(dest_nombre);
                    inputDestApellido.val(dest_apellido);
                }
                inputDestTelefono.val(dest_telefono);
                inputDestCorreo.val(dest_correo);
                actualizarFormulario("destinatario");

                // Autocompletar Paquetería
                inputDescripcion.val(descripcion);
                inputAlto.val(alto);
                inputAncho.val(ancho);
                inputPesoTotal.val(peso_total);
                checkFragil.prop("checked", estatus_fragil == 1);

            } else {
                const msgError = "Error: Registro inactivo";
                inputCodEnvio.val(msgError);
                inputDireccionDespacho.val(msgError);
                inputDireccionDestino.val(msgError);
                inputDescripcion.val(msgError);
            }
            break;
    }
}

function obtenerValoreCliente(tipoCliente, abrev) {

    let cliente = {};
    if ($(`#persona_natural_${tipoCliente}`).is(":checked")) {
        cliente = {
            tipo_document: $(`#${abrev}_documento_natural`).val(),
            cedula: $(`#${abrev}_cedula`).val(),
            nombre: $(`#${abrev}_nombre`).val(),
            apellido: $(`#${abrev}_apellido`).val(),
            correo: $(`#${abrev}_correo`).val(),
            telefono: $(`#${abrev}_telefono`).val(),
        }
    } else if ($(`#persona_juridica_${tipoCliente}`).is(":checked")) {
        cliente = {
            tipo_document: $(`#${abrev}_documento_juridico`).val(),
            rif: $(`#${abrev}_rif`).val(),
            razon_social: $(`#${abrev}_razon_social`).val(),
            correo: $(`#${abrev}_correo`).val(),
            telefono: $(`#${abrev}_telefono`).val()
        }
    }

    return cliente;

}

// Variables para el remitente
const radioNaturalRem = $("#persona_natural_remitente");
const radioJuridicaRem = $("#persona_juridica_remitente");
const camposNaturalRem = $("#rem_campos_natural");
const camposJuridicoRem = $("#rem_campos_juridico");

// Variables para el destinatario
const radioNaturalDest = $("#persona_natural_destinatario");
const radioJuridicaDest = $("#persona_juridica_destinatario");
const camposNaturalDest = $("#dest_campos_natural");
const camposJuridicoDest = $("#dest_campos_juridico");

// 2. Función que evalúa cuál radio está seleccionado y cambia las clases
function actualizarFormulario(tipoCliente) {
    switch (tipoCliente) {
        case "remitente":
            if (radioJuridicaRem.is(":checked")) {
                // Si Jurídica está seleccionada, mostramos jurídico y ocultamos natural
                camposJuridicoRem.removeClass("d-none");
                camposNaturalRem.addClass("d-none");
            } else {
                // Si Natural está seleccionada, mostramos natural y ocultamos jurídico
                camposNaturalRem.removeClass("d-none");
                camposJuridicoRem.addClass("d-none");
            }
            break;

        case "destinatario":
            if (radioJuridicaDest.is(":checked")) {
                // Si Jurídica está seleccionada, mostramos jurídico y ocultamos natural
                camposJuridicoDest.removeClass("d-none");
                camposNaturalDest.addClass("d-none");
            } else {
                // Si Natural está seleccionada, mostramos natural y ocultamos jurídico
                camposNaturalDest.removeClass("d-none");
                camposJuridicoDest.addClass("d-none");
            }
            break;
    }
}

// Dar el precio de un envío en tiempo real
$('input[name="kilometraje"]').on('input', function () {
    const kilometraje = Math.max(0, parseFloat($(this).val()) || 0);
    const costoEnvio = kilometraje * 2.36;

    $('#formEnvio #precio_envio').text(costoEnvio.toFixed(2));
    $('#formEnvio #precio_envio_hidden').val(costoEnvio.toFixed(2));
});

// 3. Asignamos el evento 'change' a ambos inputs radio con jQuery
radioNaturalRem.on("change", () => actualizarFormulario("remitente"));
radioJuridicaRem.on("change", () => actualizarFormulario("remitente"));

radioNaturalDest.on("change", () => actualizarFormulario("destinatario"));
radioJuridicaDest.on("change", () => actualizarFormulario("destinatario"));
actualizarFormulario("remitente");
actualizarFormulario("destinatario");

const pesoSumarInput = $('#peso_sumar');
const pesoTotalInput = $('#peso_total');
const btnSumarPeso = $('#btn_sumar_peso');
const btnResetPesoTotal = $('#btn_reset_pesoTotal');

pesoTotalInput.val(0); // Inicializamos el valor del peso total a 0

function sumarPesoTotal() {
    const valorInput = pesoSumarInput.val().trim();
    if (valorInput !== "" && parseFloat(valorInput) >= 0) {
        let pesoSumar = parseFloat(valorInput);
        let pesoTotal = parseFloat(pesoTotalInput.val()) || 0;
        pesoTotal += pesoSumar;
        pesoTotalInput.val(pesoTotal.toFixed(2)); // Actualizamos el valor del input con dos decimales
        pesoSumarInput.val(0); // Limpiamos el input de peso a sumar
    } else {
        alert("Por favor, ingrese un número válido para el peso.");
    }
}

btnSumarPeso.on('click', sumarPesoTotal);
pesoSumarInput.on('keydown', (event) => {
    if (event.key === 'Enter') {
        event.preventDefault();
        sumarPesoTotal();
    }
});

btnResetPesoTotal.on('click', () => {
    pesoTotalInput.val(0); // Reiniciamos el valor del peso total a 0
});