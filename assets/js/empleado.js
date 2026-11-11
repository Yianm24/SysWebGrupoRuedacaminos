$(document).ready(function () {
    ajaxConsultarEmpleado();
    const modalEmpleado = $('#modalEmpleado');
    let hasChanged = false;

    //jqueryvalidate
    $('#formEmpleado').validate({
        onkeyup: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').attr('value') === 'actualizar') {
                hasChanged = true;
            }
            evaluarBotonModificar();
        },
        onfocusout: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').attr('value') === 'actualizar') {
                hasChanged = true;
            }
            evaluarBotonModificar(); 
        },
        onclick: function(element) {
            if (element.tagName === 'SELECT') {
                $(element).valid();
                if ($('#btnSubmitModal').attr('value') === 'actualizar') {
                    hasChanged = true;
                }
                setTimeout(() => 
                    { 
                    evaluarBotonModificar(); 
                }, 0);
            }
        },
        rules: {
            cedula: { 
                required: true, 
                minlength: 7, 
                maxlength: 9 
            },
            nombre: { 
                required: true, 
                minlength: 3, 
                maxlength: 25 
            },
            apellido: { 
                required: true, 
                minlength: 3, 
                maxlength: 25 
            },
            telefono: { 
                required: true, 
                minlength: 11, 
                maxlength: 11 
            },
            telefono_emergencia: { 
                minlength: 11, 
                maxlength: 11 
            },
            cod_cargo: { 
                required: true 
            }
        },
        messages: {
            cedula: { 
                required: "Cédula requerida.", 
                minlength: "Mínimo 7 números.", 
                maxlength: "Máximo 9 números." 
            },
            nombre: { 
                required: "Nombre requerido.", 
                minlength: "Mínimo 3 letras.", 
                maxlength: "Máximo 25 letras."
            },
            apellido: { 
                required: "Apellido requerido.", 
                minlength: "Mínimo 3 letras.",
                maxlength: "Máximo 25 letras." 
            },
            telefono: { 
                required: "Teléfono requerido.", 
                minlength: "Debe tener 11 números.",
                maxlength: "Debe tener 11 números." 
            },
            telefono_emergencia: { 
                minlength: "Debe tener 11 números.", 
                maxlength: "Debe tener 11 números."
            },
            cod_cargo: { 
                required: "Seleccione un cargo." 
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

            if (solicitud === "actualizar") {
                const originales = JSON.parse($('#formEmpleado').attr('data-originales'));
                const actuales = {
                    cedula: $("#cedula").val(),
                    nombre: $("#nombre").val(),
                    apellido: $("#apellido").val(),
                    telefono: $("#telefono").val(),
                    emergencia: $("#telefono_emergencia").val(),
                    cargo: $("#cod_cargo").val()
                };
                if (JSON.stringify(originales) === JSON.stringify(actuales)) {
                    Swal.fire({ 
                        title: "Sin modificaciones", 
                        text: "Los datos ingresados son iguales a los actuales.", 
                        icon: "info" });
                    return false; 
                }
            }

            const datos = {
                cod_empleado: $("#id_empleado").val(),
                cedula: $("#cedula").val(),
                nombre: $("#nombre").val(),
                apellido: $("#apellido").val(),
                telefono: $("#telefono").val(),
                telefono_emergencia: $("#telefono_emergencia").val(),
                cod_cargo: $("#cod_cargo").val()
            };

            const objModal = bootstrap.Modal.getInstance(modalEmpleado[0]);
            ajaxEnvioDatosEmpleado(solicitud, objModal, btnEnviar, datos);
        }
    });

    $('#cod_cargo').on('change', function() {
        $(this).valid();
        if ($('#btnSubmitModal').attr('value') === 'actualizar') {
            hasChanged = true;
        }
        setTimeout(() => {
            let validador = $('#formEmpleado').validate();
            let esValido = validador.checkForm();
            let btnEnviar = $('#btnSubmitModal');
            let solicitud = btnEnviar.attr('value');

            if (solicitud === 'actualizar') {
                btnEnviar.prop('disabled', !(esValido && hasChanged));
            } else {
                btnEnviar.prop('disabled', !esValido);
            }
        }, 0);
    });

    $('#formEmpleado input').on('input', function() {
        if ($('#btnSubmitModal').attr('value') === 'actualizar') {
            hasChanged = true;
            evaluarBotonModificar();
        }
    });

    function evaluarBotonModificar() {
        let validador = $('#formEmpleado').validate();
        let esValido = validador.checkForm();
        let btnEnviar = $('#btnSubmitModal');
        let solicitud = btnEnviar.attr('value');

        if (solicitud === 'actualizar') {
            btnEnviar.prop('disabled', !(esValido && hasChanged));
        } else {
            btnEnviar.prop('disabled', !esValido);
        }
    }

    if (modalEmpleado.length) {
        modalEmpleado.on('show.bs.modal', function (event) {
            const boton = $(event.relatedTarget);
            accionModalEmpleado(boton);
        });
        
        modalEmpleado.on('shown.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
        });

        modalEmpleado.on('hidden.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
        });
    }

    // Modal Eliminar
    $("table tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        const idEmpleado = $(this).attr("data-id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Está seguro que desea eliminar este empleado?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
            didOpen: () => { if(document.activeElement) document.activeElement.blur(); }
        }).then((result) => {
            if (result.isConfirmed) {
                const datos = { cod_empleado: idEmpleado };
                ajaxEnvioDatosEmpleado("eliminar", null, null, datos);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({ 
                    title: "Cancelado",
                    text: "Eliminación cancelada.", 
                    icon: "error" });
            }
        });
    });
});

function ajaxEnvioDatosEmpleado(solicitud, modal, btnEnviar, datos) {
    const startTime = Date.now();
    $.ajax({
        url: "index.php?url=empleado",
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
            ajaxConsultarEmpleado();
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

function ajaxConsultarEmpleado() {
    $.ajax({
        url: "index.php?url=empleado", 
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
                let nombreCargo = dato.nombre_cargo ? dato.nombre_cargo.charAt(0).toUpperCase() + dato.nombre_cargo.slice(1) : "";
                
                rowsHtml += `
                    <tr>
                        <td class="ps-4 fw-medium">${dato.cedula}</td>
                        <td><span class="fw-medium">${dato.nombre} ${dato.apellido}</span></td>
                        <td class="text-secondary">${dato.telefono}</td>
                        <td class="text-secondary">${dato.telefono_emergencia || '-'}</td>
                        <td class="text-secondary">${nombreCargo}</td>
                        <td class="text-end pe-4 text-center">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline me-3" title="Editar" data-bs-toggle="modal" data-bs-target="#modalEmpleado"
                                data-id="${dato.cod_empleado}" data-cedula="${dato.cedula}" data-nombre="${dato.nombre}" data-apellido="${dato.apellido}" data-telefono="${dato.telefono}" data-emergencia="${dato.telefono_emergencia}" data-cargo="${dato.cod_cargo}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar" title="Eliminar" data-id="${dato.cod_empleado}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            tbody.html(rowsHtml);
        } else {
            tbody.html('<tr><td colspan="6" class="text-center text-muted py-4">No hay empleados registrados.</td></tr>');
        }
    })
    .fail(function (xhr, status, error) { 
        console.error(`Error AJAX:`, error); 
        console.log("Respuesta cruda del servidor:", xhr.responseText);
    });
}

function accionModalEmpleado(boton) {
    if(document.activeElement) document.activeElement.blur();
    hasChanged = false;
    const tituloModal = $('#modalLabel');
    const btnSubmit = $('#btnSubmitModal');
    
    let validador = $('#formEmpleado').validate();
    validador.resetForm();
    $('#formEmpleado input, #formEmpleado select').removeClass('is-valid is-invalid');
    $('.mensaje-error').hide().text('');

    if (boton.attr('title') === "Registrar") {
        tituloModal.html('<i class="bi bi-person-plus"></i> Registro de Empleado');
        btnSubmit.val("registrar").html('<i class="bi bi-save"></i> Registrar');
        
        $("#id_empleado, #cedula, #nombre, #apellido, #telefono, #telefono_emergencia, #cod_cargo").val("");
        btnSubmit.prop('disabled', true);

    } else if (boton.attr('title') === "Editar") {
        tituloModal.html('<i class="bi bi-pencil-square"></i> Modificar Empleado');
        btnSubmit.val("actualizar").html('<i class="bi bi-save"></i> Guardar');
        
        $("#id_empleado").val(boton.attr('data-id'));
        $("#cedula").val(boton.attr('data-cedula'));
        $("#nombre").val(boton.attr('data-nombre'));
        $("#apellido").val(boton.attr('data-apellido'));
        $("#telefono").val(boton.attr('data-telefono'));
        $("#telefono_emergencia").val(boton.attr('data-emergencia'));
        $("#cod_cargo").val(boton.attr('data-cargo'));

        const datosOriginales = {
            cedula: $("#cedula").val(), 
            nombre: $("#nombre").val(),
            apellido: $("#apellido").val(), 
            telefono: $("#telefono").val(),
            emergencia: $("#telefono_emergencia").val(), 
            cargo: $("#cod_cargo").val()
        };
        $('#formEmpleado').attr('data-originales', JSON.stringify(datosOriginales));
        btnSubmit.prop('disabled', true);
    }
}

//Mensajes y Alertas
function mostrarAlerta(status, mensaje = "") {
    let title, text, icon;
    switch (status) {
        case 'success':
            title = "Registro exitoso!";
            text = mensaje !== "" ? mensaje : "Registro de empleado realizado exitosamente";
            icon = "success";
            break;
        case 'exists':
            title = "¡Empleado existente!";
            text = mensaje !== "" ? mensaje : "Ya existe un empleado registrado con la cédula ingresada";
            icon = "warning";
            break;
        case 'updated':
            title = "Modificación exitosa!";
            text = mensaje !== "" ? mensaje : "Modificación del empleado realizado exitosamente";
            icon = "success";
            break;
        case 'deleted':
            title = "¡Eliminado!";
            text = mensaje !== "" ? mensaje : "Eliminación del empleado realizado exitosamente";
            icon = "success";
            break;
        case 'empty': 
            title = "¡Campos vacíos!";
            text = mensaje !== "" ? mensaje : "Uno o más campos están vacíos."; 
            icon = "warning"; break;
        case 'error': 
            title = "¡Error de Formato!"; 
            text = mensaje !== "" ? mensaje : `Verifique los datos ingresados.`; 
            icon = "error"; break;
        case 'exception': 
            title = "¡Excepción Retornada!"; 
            text = `Mensaje del servidor: ${mensaje}`; 
            icon = "error"; break;
        default: 
            title = "¡Error!"; 
            text = "Ha ocurrido un error inesperado."; 
            icon = "error"; break;
        }
    if (title && text && icon) {
        Swal.fire({ title: title, text: text, icon: icon, 
            didOpen: () => { if(document.activeElement) document.activeElement.blur(); },
            willClose: () => { if(document.activeElement) document.activeElement.blur(); }
        });
    }
}