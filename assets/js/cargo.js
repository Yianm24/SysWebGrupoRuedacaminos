$(document).ready(function () {

    ajaxConsultarCargo();
    const modalCargo = $('#modalCargo');
    let hasChanged = false;

    if (modalCargo.length) {
        modalCargo.on('shown.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
        });
    }

    //JQueryValidate
    $('#formCargo').validate({
        rules: {
            nombre: {
                required: true,
                minlength: 3,
                maxlength: 15,
            }
        },
        messages: {
            nombre: {
                required: "Debes ingresar el nombre del cargo.",
                minlength: "El cargo debe tener al menos 3 letras.",
                maxlength: "El cargo no puede superar las 15 letras.",
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
        onkeyup: function (element, event) {
            $(element).valid();
            if ($('#btnSubmitModal').attr('value') === 'modificar') {
                hasChanged = true;
            }
            evaluarBotonModificarCargo();
        },
        onfocusout: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').attr('value') === 'modificar') {
                hasChanged = true;
            }
            evaluarBotonModificarCargo();
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            
            const btnEnviar = $('#btnSubmitModal');
            let solicitud = btnEnviar.attr('value');

            if (solicitud === "modificar") {
                const nombreOriginal = $('#formCargo').attr('data-nombre-original');
                const nombreActual = $("#nombre").val();
                if (nombreOriginal === nombreActual) {
                    Swal.fire({ title: "Sin modificaciones", text: "El nombre ingresado es igual al actual.", icon: "info" });
                    return false; 
                }
            }

            const datos = {
                cod_cargo: $("#cod_cargo").val(),
                nombre: $("#nombre").val()
            };

            const objModal = bootstrap.Modal.getInstance(modalCargo[0]);
            ajaxEnvioDatosCargo(solicitud, objModal, btnEnviar, datos);
        }
    });

    $('#nombre').on('input', function() {
        if ($('#btnSubmitModal').attr('value') === 'modificar') {
            hasChanged = true;
            evaluarBotonModificarCargo();
        }
    });

    function evaluarBotonModificarCargo() {
        let validador = $('#formCargo').validate();
        let esValido = validador.checkForm();
        let btnEnviar = $('#btnSubmitModal');
        let solicitud = btnEnviar.attr('value');

        if (solicitud === 'modificar') {
            btnEnviar.prop('disabled', !(esValido && hasChanged));
        } else {
            btnEnviar.prop('disabled', !esValido);
        }
    }

    if (modalCargo.length) {
        modalCargo.on('show.bs.modal', function (event) {
            const boton = $(event.relatedTarget);
            accionModalCargo(boton);
        });
    }

    // Modal Eliminar.
    $("table tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        const codCargo = $(this).attr("data-id");

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Está seguro que desea eliminar este cargo?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
            didOpen: () => { if(document.activeElement) document.activeElement.blur(); } 
        }).then((result) => {
            if (result.isConfirmed) {
                const datos = { cod_cargo: codCargo };
                ajaxEnvioDatosCargo("eliminar", null, null, datos);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({ 
                    title: "Cancelado", 
                    text: "Eliminación del cargo cancelada.", 
                    icon: "error" 
                });
            }
        });
    });
});

function ajaxEnvioDatosCargo(solicitud, modal, btnEnviar, datos) {
    const startTime = Date.now();
    $.ajax({
        url: "index.php?url=cargo",
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: solicitud,
            datos: datos
        },
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
            ajaxConsultarCargo();
        }, delay);
    })
    .fail(function (xhr, status, error) {
        console.error("Error AJAX:", error);
        console.log("Respuesta cruda del servidor:", xhr.responseText);
        Swal.fire({ title: "Error de Servidor", text: "Ocurrió un problema de conexión al procesar la solicitud.", icon: "error", didOpen: () => { if(document.activeElement) document.activeElement.blur(); }});
    })
    .always(function () {
        if (btnEnviar) { $(btnEnviar).prop("disabled", false); }
    });
}

function ajaxConsultarCargo() {
    $.ajax({
        url: "index.php?url=cargo",
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
                rowsHtml += `
                    <tr>
                        <td class="ps-4 fw-medium text-secondary">${dato.nombre}</td>
                        <td class="text-end pe-4">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Modificar" data-bs-toggle="modal" data-bs-target="#modalCargo"
                                datos-cod-cargo="${dato.cod_cargo}"
                                datos-nombre="${dato.nombre}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar ms-2" title="Eliminar" data-id="${dato.cod_cargo}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            tbody.html(rowsHtml);
        } else {
            tbody.html('<tr><td colspan="2" class="text-center text-muted py-4">No hay cargos registrados.</td></tr>');
        }
    })
    .fail(function (xhr, status, error) {
        console.error(`Error AJAX al cargar la tabla:`, error);
        console.log("Respuesta cruda del servidor:", xhr.responseText);
    });
}

function accionModalCargo(boton) {
    hasChanged = false;
    const tituloModal = $('#modalLabel');
    const btnSubmit = $('#btnSubmitModal');
    const inputId = $('#cod_cargo');
    const inputNombre = $('#nombre');
    
    let validador = $('#formCargo').validate();
    validador.resetForm();
    inputNombre.removeClass('is-valid is-invalid');
    inputNombre.siblings('.mensaje-error').hide().text('');

    if (boton.attr('title') === "Registrar") {
        tituloModal.html('<i class="bi bi-person-badge"></i> Registrar Nuevo Cargo');
        btnSubmit.val("registrar").html('<i class="bi bi-save"></i> Registrar');
        inputId.val(""); 
        inputNombre.val("");
        btnSubmit.prop('disabled', true);

    } else if (boton.attr('title') === "Modificar") {
        tituloModal.html('<i class="bi bi-pencil-square"></i> Modificar Cargo');
        btnSubmit.val("modificar").html('<i class="bi bi-save"></i> Guardar');
        inputId.val(boton.attr('datos-cod-cargo'));
        inputNombre.val(boton.attr('datos-nombre'));
        $('#formCargo').attr('data-nombre-original', inputNombre.val());
        btnSubmit.prop('disabled', true);
    }
}

function mostrarAlerta(status, mensaje = "") {
    let title, text, icon;

    switch (status) {
        case 'success':
            title = "¡Registro exitoso!";
            text = mensaje !== "" ? mensaje : "El cargo ha sido registrado correctamente.";
            icon = "success";
            break;
        case 'updated':
            title = "¡Actualización exitosa!";
            text = mensaje !== "" ? mensaje : "El cargo ha sido modificado correctamente.";
            icon = "success";
            break;
        case 'deleted':
            title = "¡Eliminado!";
            text = mensaje !== "" ? mensaje : "El cargo ha sido eliminado correctamente.";
            icon = "success";
            break;
        case 'exists':
            title = "¡Cargo existente!";
            text = mensaje !== "" ? mensaje : "El cargo ingresado ya existe en la base de datos.";
            icon = "warning";
            break;
        case 'empty':
            title = "¡Campos vacíos!";
            text = mensaje !== "" ? mensaje : "Uno o más campos están vacíos.";
            icon = "warning";
            break;
        case 'error':
            title = "¡Error!";
            text = mensaje !== "" ?  mensaje : `Se produjo un error en el proceso de ${mensaje}.`;
            icon = "error";
            break;
        case 'exception':
            title = "¡Excepción Retornada!";
            text = `El servidor devolvió el siguiente mensaje: ${mensaje}`;
            icon = "error";
            break;
        default:
            title = "¡Error!";
            text = "Ha ocurrido un error inesperado.";
            icon = "error";
            break;
    }

    if (title && text && icon) {
        Swal.fire({ title: title, text: text, icon: icon, didOpen: () => { if(document.activeElement) document.activeElement.blur(); } });
    }
}