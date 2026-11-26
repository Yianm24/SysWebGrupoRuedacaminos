$(document).ready(function () {
    const moduloActual = "cargo";
    const tablaSelector = "#tablaCargo";

    $.fn.dataTable.ext.type.order['estado-cargo-pre'] = function (data) {
        const texto = String(data || '').replace(/<[^>]*>/g, '').trim().toLowerCase();
        return texto === 'activo' ? 1 : 0;
    };

    const dataTable = instanciarDatatableGlobal('table#tablaCargo', {
        order: [],
        columnDefs: [
            { targets: 1, type: 'estado-cargo' },
            { targets: 2, orderable: false }
        ]
    });

    ajaxConsultarCargo();
    const modalCargo = $('#modalCargo');
    let hasChanged = false;

    $.validator.addMethod("soloLetrasCargo", function (value, element) {
        return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value.trim());
    }, "Solo se permiten letras y espacios.");

    $('#formCargo').validate({
        onfocusout: false,
        onkeyup: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').val() === 'modificar') {
                verificarCambiosCargo();
            }
            evaluarBoton();
        },
        rules: {
            nombre: {
                required: true,
                minlength: 3,
                maxlength: 15,
                soloLetrasCargo: true
            }
        },
        messages: {
            nombre: {
                required: "Debes ingresar el nombre del cargo.",
                minlength: "El cargo debe tener al menos 3 letras.",
                maxlength: "El cargo no puede superar las 15 letras.",
                soloLetrasCargo: "El cargo solo puede contener letras."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            element.siblings('.mensaje-error').text(error.text()).show();
        },
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass('is-valid').removeClass('is-invalid').siblings('.mensaje-error').hide().text('');
        },
        submitHandler: function (form, event) {
            if (event) event.preventDefault();

            const btnEnviar = $('#btnSubmitModal');
            const solicitud = btnEnviar.val();
            verificarCambiosCargo();

            if (solicitud === "modificar" && !hasChanged) {
                Swal.fire({
                    title: "Sin modificaciones",
                    text: "No se detectaron cambios en el cargo.",
                    icon: "info"
                });
                return false;
            }

            const datos = {
                cod_cargo: $("#cod_cargo").val(),
                nombre: $("#nombre").val().trim(),
                estado: solicitud === "registrar" ? 1 : getEstadoSwitchCargo()
            };
            const objModal = bootstrap.Modal.getInstance(modalCargo[0]);

            ajaxEnvioDatosGlobal('cargo', solicitud, ajaxConsultarCargo, dataTable, datos, objModal, btnEnviar);
            return false;
        }
    });

    function getEstadoSwitchCargo() {
        return $('#estado_cargo').is(':checked') ? 1 : 0;
    }

    function verificarCambiosCargo() {
        const original = ($('#formCargo').attr('data-nombre-original') || '').trim();
        const actual = ($('#nombre').val() || '').trim();
        const estadoOriginal = String($('#formCargo').attr('data-estado-original') ?? '1');
        const estadoActual = String(getEstadoSwitchCargo());
        hasChanged = (original !== actual) || (estadoOriginal !== estadoActual);
    }

    function evaluarBoton() {
        const esValido = $('#formCargo').validate().checkForm();
        const btnEnviar = $('#btnSubmitModal');
        btnEnviar.prop('disabled', btnEnviar.val() === 'modificar' ? !(esValido && hasChanged) : !esValido);
    }

    $("#estado_cargo").on("change", function () {
        if ($(this).is(":checked")) {
            $(this).prop("disabled", true);
            $("#label_estado_cargo").text("Activo");
        } else {
            $("#label_estado_cargo").text("Inactivo");
        }
        if ($('#btnSubmitModal').val() === 'modificar') {
            verificarCambiosCargo();
        }
        evaluarBoton();
    });

    $('#formCargo').on('submit', function (event) {
        event.preventDefault();
        if (!$(this).valid()) {
            evaluarBoton();
        }
    });

    $('#btnSubmitModal').on('click', function (event) {
        event.preventDefault();
        $('#formCargo').trigger('submit');
    });

    $('#nombre').on('input', function () {
        if ($('#btnSubmitModal').val() === 'modificar') {
            verificarCambiosCargo();
        }
        evaluarBoton();
    });

    if (modalCargo.length) {
        modalCargo.on('show.bs.modal', function (event) {
            accionModalCargo($(event.relatedTarget));
        });
        modalCargo.on('shown.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
            evaluarBoton();
        });
    }

    $(tablaSelector + " tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        const codCargo = $(this).attr("data-id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success ms-2",
                cancelButton: "btn btn-danger"
            },
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
            didOpen: () => {
                if (document.activeElement) document.activeElement.blur();
            }
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxEnvioDatosGlobal('cargo', 'eliminar', ajaxConsultarCargo, dataTable, { cod_cargo: codCargo }, null, null);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "Eliminación del cargo cancelada.",
                    icon: "error"
                });
            }
        });
    });

    function ajaxConsultarCargo() {
        ajaxConsultarGlobal(moduloActual, function (response) {
            dataTable.clear();

            if (Array.isArray(response) && response.length > 0) {
                $.each(response, function (index, dato) {
                    const estaActivo = String(dato.estado) === '1';
                    const badgeEstado = estaActivo
                        ? `<div class="text-center"><span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                <i class="bi bi-check-circle-fill me-1"></i>Activo
                            </span></div>`
                        : `<div class="text-center"><span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">
                                <i class="bi bi-x-circle-fill me-1"></i>Inactivo
                            </span></div>`;

                    const button = `
                        <div class="text-center d-flex justify-content-center align-items-center gap-2">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Modificar"
                                data-bs-toggle="modal" data-bs-target="#modalCargo"
                                datos-cod-cargo="${dato.cod_cargo}"
                                datos-nombre="${dato.nombre}"
                                datos-estado="${dato.estado}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar"
                                title="Eliminar" data-id="${dato.cod_cargo}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;

                    dataTable.row.add([
                        dato.nombre,
                        badgeEstado,
                        button
                    ]);
                });
            }

            dataTable.draw();
        });
    }

    function accionModalCargo(boton) {
        hasChanged = false;
        $('#formCargo').validate().resetForm();
        $('#nombre').removeClass('is-valid is-invalid').val("").siblings('.mensaje-error').hide().text('');
        $('#cod_cargo').val("");
        $('#formCargo').removeAttr('data-nombre-original data-estado-original');

        if (boton && boton.attr('title') === "Registrar") {
            $('#modalLabel').html('<i class="bi bi-person-badge"></i> Registrar Nuevo Cargo');
            $('#div_estado_cargo').hide();
            $('#estado_cargo').prop('checked', true).prop('disabled', true);
            $('#label_estado_cargo').text("Activo");
            $('#btnSubmitModal').val("registrar").html('<i class="bi bi-save"></i> Registrar').prop('disabled', true);
        } else if (boton && boton.attr('title') === "Modificar") {
            const estadoActual = String(boton.attr('datos-estado') ?? '1');
            $('#modalLabel').html('<i class="bi bi-pencil-square"></i> Modificar Cargo');
            $('#cod_cargo').val(boton.attr('datos-cod-cargo'));
            $('#nombre').val(boton.attr('datos-nombre'));
            $('#div_estado_cargo').css('display', 'flex');

            if (estadoActual === '0') {
                $('#estado_cargo').prop('checked', false).prop('disabled', false);
                $('#label_estado_cargo').text("Inactivo");
            } else {
                $('#estado_cargo').prop('checked', true).prop('disabled', true);
                $('#label_estado_cargo').text("Activo");
            }

            $('#formCargo')
                .attr('data-nombre-original', $('#nombre').val())
                .attr('data-estado-original', estadoActual === '1' ? '1' : '0');
            $('#btnSubmitModal').val("modificar").html('<i class="bi bi-save"></i> Guardar').prop('disabled', true);
        }
    }
});