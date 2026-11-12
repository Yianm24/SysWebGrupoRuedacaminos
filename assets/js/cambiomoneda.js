let tasaInput;
let hasChanged = false; 

$(document).ready(function () {
    ajaxConsultarCambio();
    const modalCambio = $('#modalCambio');

    if (document.getElementById('tasa')) {
        $('#tasa').attr('autocomplete', 'off');
    }
    //Inicialización de AutoNumeric
    if (document.getElementById('tasa')) {
        tasaInput = new AutoNumeric('#tasa', {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: 2,
            maximumValue: '9999999.99',
            minimumValue: '0',
            decimalPlacesShownOnFocus: 2,
            allowDecimalPadding: true,
            emptyInputBehavior: 'zero',
            unformatOnSubmit: true,
            modifyValueOnWheel: false,
            modifyValueOnUpDownArrow: false
        });
    }

    if (modalCambio.length) {
        modalCambio.on('show.bs.modal', function (event) {
            const boton = $(event.relatedTarget);
            accionModalCambio(boton);
        });

        modalCambio.on('shown.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
        });
        modalCambio.on('hidden.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
            if(tasaInput) tasaInput.set(''); 
        });
    }

    $('#tasa').on('autoNumeric:rawValueModified', function() {
        $(this).valid();
        if ($('#btnSubmitModal').attr('value') === 'actualizar') hasChanged = true;
        evaluarBotonModificar();
    });

    // JQuery Validate
    $.validator.addMethod("montoValido", function() {
        if (!tasaInput) return false;
        let num = tasaInput.getNumber();
        return num !== null && num > 0; 
    }, "Debe ser mayor a 0.");

    $('#formCambio').validate({
        onkeyup: false,
        onfocusout: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').attr('value') === 'actualizar') hasChanged = true;
            evaluarBotonModificar(); 
        },
        onclick: function(element) {
            if (element.tagName === 'SELECT') {
                $(element).valid();
                if ($('#btnSubmitModal').attr('value') === 'actualizar') hasChanged = true;
                evaluarBotonModificar();
            }
        },
        rules: {
            moneda: { required: true },
            tasa: { required: true, montoValido: true }
        },
        messages: {
            moneda: { required: "Debe seleccionar una moneda." },
            tasa: { 
                required: "Debe ingresar el valor de la tasa.",
                montoValido: "Monto inválido. Ingrese un valor mayor a 0."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            let spanError = element.siblings('.mensaje-error');
            spanError.text(error.text()).show();
        },
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
            $(element).siblings('.mensaje-error').hide().text('');
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            
            const btnEnviar = $('#btnSubmitModal');
            let solicitud = btnEnviar.attr('value');
            const tasaLimpia = tasaInput.getNumber(); 

            if (solicitud === "actualizar") {
                const originales = JSON.parse($('#formCambio').attr('data-originales'));
                const tasaOriginal = parseFloat(originales.tasa);
                const monedaOriginal = originales.moneda;
                
                if (tasaOriginal.toFixed(2) === tasaLimpia.toFixed(2) && monedaOriginal === $("#moneda").val()) {
                    Swal.fire({ 
                        title: "Sin modificaciones", 
                        text: "Los datos ingresados son iguales a los actuales.", 
                        icon: "info",
                        didOpen: () => { if(document.activeElement) document.activeElement.blur(); }
                    });
                    return false; 
                }
            }

            const datos = {
                cod_cambio: $("#id_cambio").val(),
                moneda: $("#moneda").val(),
                tasa: tasaLimpia.toFixed(2)
            };

            const objModal = bootstrap.Modal.getInstance(modalCambio[0]);
            ajaxEnvioDatosCambio(solicitud, objModal, btnEnviar, datos);
        }
    });

    $('#formCambio select').on('change', function() {
        if ($('#btnSubmitModal').attr('value') === 'actualizar') {
            hasChanged = true;
            evaluarBotonModificar();
        }
    });

    function evaluarBotonModificar() {
        setTimeout(() => {
            let validador = $('#formCambio').validate();
            let esValido = validador.checkForm();
            let btnEnviar = $('#btnSubmitModal');
            let solicitud = btnEnviar.attr('value');
            let tasaNumerica = tasaInput ? tasaInput.getNumber() : 0;
            let monedaVal = $("#moneda").val();
            
            let valValidos = (tasaNumerica !== null && tasaNumerica > 0 && monedaVal !== null && monedaVal !== "");

            if (solicitud === 'actualizar') {
                btnEnviar.prop('disabled', !(esValido && valValidos && hasChanged));
            } else {
                btnEnviar.prop('disabled', !(esValido && valValidos));
            }
        }, 0);
    }

    // Modal Eliminar
    $("table tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        const idCambio = $(this).attr("data-id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Está seguro que desea eliminar esta tasa?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
            didOpen: () => { if(document.activeElement) document.activeElement.blur(); }
        }).then((result) => {
            if (result.isConfirmed) {
                const datos = { cod_cambio: idCambio };
                ajaxEnvioDatosCambio("eliminar", null, null, datos);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({ 
                    title: "Cancelado",
                    text: "Eliminación cancelada.", 
                    icon: "error",
                    didOpen: () => { if(document.activeElement) document.activeElement.blur(); }
                });
            }
        });
    });
});


function ajaxEnvioDatosCambio(solicitud, modal, btnEnviar, datos) {
    const startTime = Date.now();
    $.ajax({
        url: "index.php?url=cambiomoneda",
        type: "POST",
        dataType: "json",
        data: { tipoSolicitud: solicitud, datos: datos },
        beforeSend: function () {
            if (modal) { modal.hide(); }
            if (btnEnviar) { $(btnEnviar).prop("disabled", true); }
            Swal.fire({ 
                title: 'Procesando...',
                text: 'Por favor espere un momento.', 
                allowOutsideClick: false, 
                didOpen: () => { 
                    if(document.activeElement) document.activeElement.blur(); 
                    Swal.showLoading(); 
                } 
            });
        }
    })
    .done(function (response) {
        console.log("Respuesta del servidor:", response);
        const elapsedTime = Date.now() - startTime;
        const delay = Math.max(0, 500 - elapsedTime);

        setTimeout(() => {
            mostrarAlerta(response.status, response.message);
            ajaxConsultarCambio();
        }, delay);
    })
    .fail(function (xhr, status, error) {
        console.error("Error AJAX:", error);
        console.log("Respuesta cruda del servidor:", xhr.responseText);
        Swal.fire({ 
            title: "Error de Servidor", 
            text: "Ocurrió un problema de conexión al procesar la solicitud.", 
            icon: "error",
            didOpen: () => { if(document.activeElement) document.activeElement.blur(); }
        });
    })
    .always(function () {
        if (btnEnviar) { $(btnEnviar).prop("disabled", false); }
    });
}

function ajaxConsultarCambio() {
    $.ajax({
        url: "index.php?url=cambiomoneda", 
        type: "POST", 
        dataType: "json", 
        data: { tipoSolicitud: "consultar" }
    })
    .done(function (response) {
        let tbody = $("table tbody");
        tbody.empty();

        if (Array.isArray(response) && response.length > 0) {
            let rowsHtml = "";
            $.each(response, function (index, dato) {
                let tasaComparar = dato.tasa;
                for (let i = index + 1; i < response.length; i++) {
                    if (response[i].cod_moneda === dato.cod_moneda) {
                        tasaComparar = response[i].tasa;
                        break;
                    }
                }
                
                let color = "";
                let icono = "";
                if (parseFloat(dato.tasa) > parseFloat(tasaComparar)) {
                    color = "text-success";
                    icono = "bi-arrow-up";
                } else if (parseFloat(dato.tasa) < parseFloat(tasaComparar)) {
                    color = "text-danger";
                    icono = "bi-arrow-down";
                } else {
                    color = "text-secondary";
                    icono = "bi-dash"; 
                }

                let formatearATabla = (num) => parseFloat(num).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2, useGrouping: true });
                let tasaFormateada = formatearATabla(dato.tasa);
                
                let fechaObjeto = new Date(dato.fecha.replace(' ', 'T'));
                let fechaString = fechaObjeto.toLocaleDateString('es-VE', {day: '2-digit', month: '2-digit', year: 'numeric'});
                let horaString = fechaObjeto.toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'});

                rowsHtml += `
                    <tr>
                        <td class="ps-4 fw-medium">${fechaString}</td>
                        <td class="text-secondary">${horaString}</td>
                        <td class="text-secondary">${dato.abreviatura}</td>
                        <td class="fw-bold">
                            ${tasaFormateada} VES
                            ${icono !== "bi-dash" ? `<small class="${color} ms-1"><i class="bi ${icono}"></i></small>` : ''}
                        </td>
                        <td class="pe-4 text-center">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline me-3 btn-editar" title="Editar" data-bs-toggle="modal" data-bs-target="#modalCambio"
                                data-id="${dato.cod_cambio}" data-moneda="${dato.cod_moneda}" data-tasa="${parseFloat(dato.tasa)}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar" title="Eliminar" data-id="${dato.cod_cambio}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            tbody.html(rowsHtml);
        } else {
            tbody.html('<tr><td colspan="5" class="text-center text-muted py-4">No hay registros disponibles.</td></tr>');
        }
    })
    .fail(function (xhr, status, error) { 
        console.error(`Error AJAX al cargar la tabla:`, error); 
        console.log("Respuesta cruda del servidor:", xhr.responseText);
    });
}

function accionModalCambio(boton) {
    if(document.activeElement) document.activeElement.blur(); 
    hasChanged = false; 
    const tituloModal = $('#modalLabel');
    const btnSubmit = $('#btnSubmitModal');
    
    let validador = $('#formCambio').validate();
    validador.resetForm();
    $('#formCambio input, #formCambio select').removeClass('is-valid is-invalid');
    $('.mensaje-error').hide().text('');

    if (boton.attr('title') === "Registrar") {
        tituloModal.html('<i class="bi bi-currency-exchange"></i> Registrar Cambio Moneda');
        btnSubmit.val("registrar").html('<i class="bi bi-save"></i> Registrar');
        
        $("#id_cambio, #moneda").val("");
        if(tasaInput) tasaInput.set(''); 
        btnSubmit.prop('disabled', true);

    } else if (boton.attr('title') === "Editar") {
        tituloModal.html('<i class="bi bi-pencil-square"></i> Editar Tasa de Cambio');
        btnSubmit.val("actualizar").html('<i class="bi bi-save"></i> Guardar');
        
        $("#id_cambio").val(boton.attr('data-id'));
        $("#moneda").val(boton.attr('data-moneda'));
        
        if(tasaInput) tasaInput.set(boton.attr('data-tasa')); 

        const datosOriginales = {
            moneda: boton.attr('data-moneda'),
            tasa: parseFloat(boton.attr('data-tasa'))
        };
        $('#formCambio').attr('data-originales', JSON.stringify(datosOriginales));
        btnSubmit.prop('disabled', true);
    }
}

// Mensajes y alertas
function mostrarAlerta(status, mensaje = "") {
    let title, text, icon;
    switch (status) {
        case 'success': 
            title = "Registro exitoso!"; 
            text = mensaje !== "" ? mensaje : "Registro realizado exitosamente."; 
            icon = "success"; 
            break;
        case 'exists': 
            title = "¡Tasa existente!"; 
            text = mensaje !== "" ? mensaje : "Ya existe una tasa registrada el día de hoy."; 
            icon = "warning"; 
            break;
        case 'updated': 
            title = "Modificación exitosa!"; 
            text = mensaje !== "" ? mensaje : "Modificación realizada exitosamente."; 
            icon = "success"; 
            break;
        case 'deleted': 
            title = "¡Eliminado!"; 
            text = mensaje !== "" ? mensaje : "Eliminación realizada exitosamente."; 
            icon = "success"; 
            break;
        case 'error': 
            title = "¡Error!"; 
            text = mensaje !== "" ? mensaje : "Verifique los datos ingresados."; 
            icon = "error"; 
            break;
        default: 
            title = "¡Error!"; 
            text = "Ha ocurrido un error inesperado."; 
            icon = "error"; 
            break;
    }
    if (title && text && icon) {
        Swal.fire({ 
            title: title, text: text, icon: icon, 
            didOpen: () => { if(document.activeElement) document.activeElement.blur(); },
            willClose: () => { if(document.activeElement) document.activeElement.blur(); }
        });
    }
}