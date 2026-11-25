$(document).ready(function () {
    const moduloActual = "empleado";
    const tablaSelector = "#tablaEmpleado";
    const esAdmin = $(tablaSelector).attr('data-es-admin') === '1';

    const dataTable = instanciarDatatableGlobal('table#tablaEmpleado');
    ajaxConsultarEmpleado();

    const modalEmpleado = $('#modalEmpleado');
    let hasChanged = false;

    $.validator.addMethod("soloNumerosEmp", function (value, element) {
        return this.optional(element) || /^\d+$/.test(value.trim());
    }, "Solo se permiten números.");

    $.validator.addMethod("soloLetrasEmp", function (value, element) {
        return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value.trim());
    }, "Solo se permiten letras y espacios.");

    $('#formEmpleado').validate({
        onfocusout: false,
        onkeyup: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').attr('value') === 'actualizar') {
                verificarCambiosEmpleado();
            }
            evaluarBotonModificar();
        },
        onclick: function (element) {
            if (element.tagName === 'SELECT') {
                $(element).valid();
                if ($('#btnSubmitModal').attr('value') === 'actualizar') {
                    verificarCambiosEmpleado();
                }
                evaluarBotonModificar();
            }
        },
        rules: {
            cedula: {
                required: true,
                minlength: 7,
                maxlength: 9,
                soloNumerosEmp: true
            },
            nombre: {
                required: true,
                minlength: 3,
                maxlength: 25,
                soloLetrasEmp: true
            },
            apellido: {
                required: true,
                minlength: 3,
                maxlength: 25,
                soloLetrasEmp: true
            },
            telefono: {
                required: true,
                minlength: 11,
                maxlength: 11,
                soloNumerosEmp: true
            },
            telefono_emergencia: {
                minlength: 11,
                maxlength: 11,
                soloNumerosEmp: true
            },
            cod_cargo: {
                required: true
            }
        },
        messages: {
            cedula: {
                required: "Cédula requerida.",
                minlength: "Mínimo 7 números.",
                maxlength: "Máximo 9 números.",
                soloNumerosEmp: "La cédula solo puede contener números."
            },
            nombre: {
                required: "Nombre requerido.",
                minlength: "Mínimo 3 letras.",
                maxlength: "Máximo 25 letras.",
                soloLetrasEmp: "El nombre solo puede contener letras."
            },
            apellido: {
                required: "Apellido requerido.",
                minlength: "Mínimo 3 letras.",
                maxlength: "Máximo 25 letras.",
                soloLetrasEmp: "El apellido solo puede contener letras."
            },
            telefono: {
                required: "Teléfono requerido.",
                minlength: "Debe tener 11 números.",
                maxlength: "Debe tener 11 números.",
                soloNumerosEmp: "El teléfono solo puede contener números."
            },
            telefono_emergencia: {
                minlength: "Debe tener 11 números.",
                maxlength: "Debe tener 11 números.",
                soloNumerosEmp: "El teléfono de emergencia solo puede contener números."
            },
            cod_cargo: {
                required: "Seleccione un cargo."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            let spanError = element.siblings('.mensaje-error');
            if (!spanError.length) {
                spanError = element.closest('.mb-3, .col-md-4').find('.mensaje-error');
            }
            spanError.text(error.text()).show();
        },
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
            let spanError = $(element).siblings('.mensaje-error');
            if (!spanError.length) {
                spanError = $(element).closest('.mb-3, .col-md-4').find('.mensaje-error');
            }
            spanError.hide().text('');
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const btnEnviar = $('#btnSubmitModal');
            const solicitud = btnEnviar.attr('value');

            if (solicitud === "actualizar") {
                verificarCambiosEmpleado();
                if (!hasChanged) {
                    Swal.fire({
                        title: "Sin modificaciones",
                        text: "Los datos ingresados son iguales a los actuales.",
                        icon: "info",
                        didOpen: () => { if (document.activeElement) document.activeElement.blur(); }
                    });
                    return false;
                }
            }

            const datos = {
                cod_empleado: $("#id_empleado").val(),
                cedula: $("#cedula").val().trim(),
                nombre: $("#nombre").val().trim(),
                apellido: $("#apellido").val().trim(),
                telefono: $("#telefono").val().trim(),
                telefono_emergencia: $("#telefono_emergencia").val().trim(),
                cod_cargo: $("#cod_cargo").val()
            };

            const objModal = bootstrap.Modal.getInstance(modalEmpleado[0]) || new bootstrap.Modal(modalEmpleado[0]);
            ajaxEnvioDatosGlobal(moduloActual, solicitud, ajaxConsultarEmpleado, dataTable, datos, objModal, btnEnviar);
        }
    });

    $('#btnSubmitModal').on('click', function (event) {
        event.preventDefault();
        $('#formEmpleado').trigger('submit');
    });

    $('#cod_cargo').on('change', function () {
        $(this).valid();
        if ($('#btnSubmitModal').attr('value') === 'actualizar') {
            verificarCambiosEmpleado();
        }
        evaluarBotonModificar();
    });

    $('#formEmpleado input').on('keyup input', function () {
        if ($('#btnSubmitModal').attr('value') === 'actualizar') {
            verificarCambiosEmpleado();
        }
        evaluarBotonModificar();
    });

    function obtenerEstadoActualEmpleado() {
        return {
            cedula: ($("#cedula").val() || '').trim(),
            nombre: ($("#nombre").val() || '').trim(),
            apellido: ($("#apellido").val() || '').trim(),
            telefono: ($("#telefono").val() || '').trim(),
            emergencia: ($("#telefono_emergencia").val() || '').trim(),
            cargo: String($("#cod_cargo").val() || '')
        };
    }

    function verificarCambiosEmpleado() {
        const originalesAttr = $('#formEmpleado').attr('data-originales');
        if (!originalesAttr) {
            hasChanged = false;
            return;
        }
        const originales = JSON.parse(originalesAttr);
        const actuales = obtenerEstadoActualEmpleado();
        hasChanged = JSON.stringify(originales) !== JSON.stringify(actuales);
    }

    function evaluarBotonModificar() {
        const validador = $('#formEmpleado').validate();
        const esValido = validador.checkForm();
        const btnEnviar = $('#btnSubmitModal');
        const solicitud = btnEnviar.attr('value');

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
            evaluarBotonModificar();
        });

        modalEmpleado.on('hidden.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
        });
    }

    $(tablaSelector + " tbody").on("click", ".btn-eliminar", function (event) {
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
            didOpen: () => { if (document.activeElement) document.activeElement.blur(); }
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxEnvioDatosGlobal(moduloActual, 'eliminar', ajaxConsultarEmpleado, dataTable, { cod_empleado: idEmpleado }, null, null);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "Eliminación cancelada.",
                    icon: "error",
                    didOpen: () => { if (document.activeElement) document.activeElement.blur(); }
                });
            }
        });
    });

    function ajaxConsultarEmpleado() {
        ajaxConsultarGlobal(moduloActual, function (response) {
            dataTable.clear();

            if (Array.isArray(response) && response.length > 0) {
                $.each(response, function (index, dato) {
                    const nombreCargo = dato.nombre_cargo
                        ? dato.nombre_cargo.charAt(0).toUpperCase() + dato.nombre_cargo.slice(1)
                        : "";

                    const fila = [
                        `<span class="ps-2 fw-medium">${dato.cedula}</span>`,
                        `<span class="fw-medium">${dato.nombre} ${dato.apellido}</span>`,
                        `<span class="text-secondary">${dato.telefono}</span>`,
                        `<span class="text-secondary">${dato.telefono_emergencia || '-'}</span>`,
                        `<span class="text-secondary">${nombreCargo}</span>`
                    ];

                    if (esAdmin) {
                        const botones = `
                            <div class="text-center d-flex justify-content-center align-items-center gap-2">
                                <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-editar"
                                    title="Editar" data-bs-toggle="modal" data-bs-target="#modalEmpleado"
                                    data-id="${dato.cod_empleado}"
                                    data-cedula="${dato.cedula}"
                                    data-nombre="${dato.nombre}"
                                    data-apellido="${dato.apellido}"
                                    data-telefono="${dato.telefono}"
                                    data-emergencia="${dato.telefono_emergencia || ''}"
                                    data-cargo="${dato.cod_cargo}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar"
                                    title="Eliminar" data-id="${dato.cod_empleado}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `;
                        fila.push(botones);
                    }

                    dataTable.row.add(fila);
                });
            }

            dataTable.draw();
        });
    }

    function accionModalEmpleado(boton) {
        if (document.activeElement) document.activeElement.blur();
        hasChanged = false;
        const tituloModal = $('#modalLabel');
        const btnSubmit = $('#btnSubmitModal');

        const validador = $('#formEmpleado').validate();
        validador.resetForm();
        $('#formEmpleado input, #formEmpleado select').removeClass('is-valid is-invalid');
        $('.mensaje-error').hide().text('');
        $('#formEmpleado').removeAttr('data-originales');

        if (boton && boton.attr('title') === "Registrar") {
            tituloModal.html('<i class="bi bi-person-plus"></i> Registro de Empleado');
            btnSubmit.val("registrar").html('<i class="bi bi-save"></i> Registrar');

            $("#id_empleado, #cedula, #nombre, #apellido, #telefono, #telefono_emergencia, #cod_cargo").val("");
            btnSubmit.prop('disabled', true);

        } else if (boton && boton.attr('title') === "Editar") {
            tituloModal.html('<i class="bi bi-pencil-square"></i> Modificar Empleado');
            btnSubmit.val("actualizar").html('<i class="bi bi-save"></i> Guardar');

            $("#id_empleado").val(boton.attr('data-id'));
            $("#cedula").val(boton.attr('data-cedula'));
            $("#nombre").val(boton.attr('data-nombre'));
            $("#apellido").val(boton.attr('data-apellido'));
            $("#telefono").val(boton.attr('data-telefono'));
            $("#telefono_emergencia").val(boton.attr('data-emergencia') || '');
            $("#cod_cargo").val(boton.attr('data-cargo'));

            $('#formEmpleado').attr('data-originales', JSON.stringify(obtenerEstadoActualEmpleado()));
            btnSubmit.prop('disabled', true);
        }
    }
});