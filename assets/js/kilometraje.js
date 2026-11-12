$(document).ready(function () {
    ajaxConsultarKilometraje();
    const modalKilometraje = $('#modalKilometraje');
    let hasChanged = false;

    if (modalKilometraje.length) {
        modalKilometraje.on('shown.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
        });
        modalKilometraje.on('hidden.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
        });
    }

    //Formatear digitos con . para los miles y , para decimales.
    $('.numeros-decimales').on('input', function() {
        let input = $(this);
        let valorPuro = input.val().replace(/\D/g, ''); 

        if (valorPuro !== '') {
            let num = parseInt(valorPuro, 10) / 100;
            if (num > 99999.99) num = 99999.99; 
            input.val(num.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        } else {
            input.val('');
        }

        input.valid(); 
    });

    // JQuery Validate
    $('#formKilometraje').validate({
        onkeyup: false,
        onfocusout: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').attr('value') === 'actualizar') hasChanged = true;
            evaluarBotonModificar(); 
        },
        
        rules: {
            kilometraje: { 
                required: true,
                minlength: 4, 
                maxlength: 9
            },
            precio_kilometraje: { 
                required: true,
                minlength: 4, 
                maxlength: 9
            }
        },
        messages: {
            kilometraje: { 
                required: "Debe ingresar el kilometraje.",
                minlength: "Debe tener al menos 1 número.",
                maxlength: "No puede superar los 7 números."
            },
            precio_kilometraje: { 
                required: "Debe ingresar el precio.",
                minlength: "Debe tener al menos 1 número.",
                maxlength: "No puede superar los 7 números."
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
            const limpiarMoneda = (val) => val ? parseFloat(val.replace(/\./g, '').replace(',', '.')) : 0;
            const kmLimpio = limpiarMoneda($("#kilometraje_input").val());
            const precioLimpio = limpiarMoneda($("#precio_kilometraje").val());

            if (solicitud === "actualizar") {
                const originales = JSON.parse($('#formKilometraje').attr('data-originales'));
                const kmOriginal = parseFloat(originales.km);
                const precioOriginal = parseFloat(originales.precio);
                
                if (kmOriginal.toFixed(2) === kmLimpio.toFixed(2) && precioOriginal.toFixed(2) === precioLimpio.toFixed(2)) {
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
                cod_preciokilometraje: $("#id_tarifa").val(),
                kilometraje: kmLimpio.toFixed(2),
                precio_kilometraje: precioLimpio.toFixed(2)
            };

            const objModal = bootstrap.Modal.getInstance(modalKilometraje[0]);
            ajaxEnvioDatosKilometraje(solicitud, objModal, btnEnviar, datos);
        }
    });

    $('#formKilometraje input').on('input', function() {
        if ($('#btnSubmitModal').attr('value') === 'actualizar') {
            hasChanged = true;
            evaluarBotonModificar();
        }
    });

    function evaluarBotonModificar() {
        setTimeout(() => {
            let validador = $('#formKilometraje').validate();
            let esValido = validador.checkForm();
            let btnEnviar = $('#btnSubmitModal');
            let solicitud = btnEnviar.attr('value');

            let kmVal = $("#kilometraje_input").val();
            let precioVal = $("#precio_kilometraje").val();
            let valValidos = (kmVal !== "0,00" && precioVal !== "0,00" && kmVal !== "" && precioVal !== "");
            
            if (solicitud === 'actualizar') {
                btnEnviar.prop('disabled', !(esValido && valValidos && hasChanged));
            } else {
                btnEnviar.prop('disabled', !(esValido && valValidos));
            }
        }, 0);
    }

    if (modalKilometraje.length) {
        modalKilometraje.on('show.bs.modal', function (event) {
            const boton = $(event.relatedTarget);
            accionModalKilometraje(boton);
        });
    }

    // Modal Eliminar
    $("table tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        const idTarifa = $(this).attr("data-id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Está seguro que desea eliminar esta tarifa?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
            didOpen: () => { if(document.activeElement) document.activeElement.blur(); }
        }).then((result) => {
            if (result.isConfirmed) {
                const datos = { cod_preciokilometraje: idTarifa };
                ajaxEnvioDatosKilometraje("eliminar", null, null, datos);
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

function ajaxEnvioDatosKilometraje(solicitud, modal, btnEnviar, datos) {
    const startTime = Date.now();
    $.ajax({
        url: "index.php?url=kilometraje",
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
            ajaxConsultarKilometraje();
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

function ajaxConsultarKilometraje() {
    $.ajax({
        url: "index.php?url=kilometraje", 
        type: "POST", 
        dataType: "json", 
        data: { tipoSolicitud: "consultar" }
    })
    .done(function (response) {
        let tbody = $("#tablaPrecios tbody");
        tbody.empty();

        if (Array.isArray(response) && response.length > 0) {
            let rowsHtml = "";
            $.each(response, function (index, dato) {
                let formatearATabla = (num) => parseFloat(num).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                let kmFormateado = formatearATabla(dato.kilometraje);
                let precioFormateado = formatearATabla(dato.monto_tarifa);
                
                rowsHtml += `
                    <tr>
                        <td class="ps-4 fw-medium">T-${dato.cod_preciokilometraje}</td>
                        <td class="text-secondary">${kmFormateado} KM</td>
                        <td class="text-secondary">$ ${precioFormateado}</td>
                        <td class="pe-4 text-center">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline me-3 btn-editar" title="Editar" data-bs-toggle="modal" data-bs-target="#modalKilometraje"
                                data-id="${dato.cod_preciokilometraje}" data-kilometraje="${parseFloat(dato.kilometraje)}" data-precio="${dato.monto_tarifa}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar" title="Eliminar" data-id="${dato.cod_preciokilometraje}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            tbody.html(rowsHtml);
        } else {
            tbody.html('<tr><td colspan="4" class="text-center text-muted py-4">No hay registros disponibles.</td></tr>');
        }
    })
    .fail(function (xhr, status, error) { 
        console.error(`Error AJAX al cargar la tabla:`, error); 
        console.log("Respuesta cruda del servidor:", xhr.responseText);
    });
}

function accionModalKilometraje(boton) {
    if(document.activeElement) document.activeElement.blur(); 
    hasChanged = false; 
    const tituloModal = $('#modalLabel');
    const btnSubmit = $('#btnSubmitModal');
    
    let validador = $('#formKilometraje').validate();
    validador.resetForm();
    $('#formKilometraje input, #formKilometraje select').removeClass('is-valid is-invalid');
    $('.mensaje-error').hide().text('');

    const formatView = (num) => {
        let f = parseFloat(num);
        return isNaN(f) ? "" : f.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };

    if (boton.attr('title') === "Registrar") {
        tituloModal.html('<i class="bi bi-currency-dollar"></i> Registrar Precio de Kilometraje');
        btnSubmit.val("registrar").html('<i class="bi bi-save"></i> Registrar');
        
        $("#id_tarifa, #kilometraje_input, #precio_kilometraje").val("");
        btnSubmit.prop('disabled', true);

    } else if (boton.attr('title') === "Editar") {
        tituloModal.html('<i class="bi bi-pencil-square"></i> Editar Precio de Kilometraje');
        btnSubmit.val("actualizar").html('<i class="bi bi-save"></i> Guardar');
        
        $("#id_tarifa").val(boton.attr('data-id'));
        $("#kilometraje_input").val(formatView(boton.attr('data-kilometraje')));
        $("#precio_kilometraje").val(formatView(boton.attr('data-precio')));

        const datosOriginales = {
            km: boton.attr('data-kilometraje'),
            precio: boton.attr('data-precio')
        };
        $('#formKilometraje').attr('data-originales', JSON.stringify(datosOriginales));
        btnSubmit.prop('disabled', true);
    }
}

//Mensajes y Alertas
function mostrarAlerta(status, mensaje = "") {
    let title, text, icon;
    switch (status) {
        case 'success': 
            title = "Registro exitoso!"; 
            text = mensaje !== "" ? mensaje : "Registro realizado exitosamente."; 
            icon = "success"; 
            break;
        case 'exists': 
            title = "¡Tarifa existente!"; 
            text = mensaje !== "" ? mensaje : "Ya existe una tarifa registrada para este kilometraje."; 
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
        case 'empty': 
            title = "¡Campos vacíos!"; 
            text = mensaje !== "" ? mensaje : "Uno o más campos están vacíos."; 
            icon = "warning"; 
            break;
        case 'error': 
            title = "¡Error de Formato!"; 
            text = mensaje !== "" ? mensaje : "Verifique los datos ingresados."; 
            icon = "error"; 
            break;
        case 'exception': 
            title = "¡Excepción Retornada!"; 
            text = `Mensaje del servidor: ${mensaje}`; 
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
            title: title, 
            text: text, 
            icon: icon, 
            didOpen: () => { if(document.activeElement) document.activeElement.blur(); },
            willClose: () => { if(document.activeElement) document.activeElement.blur(); }
        });
    }
}