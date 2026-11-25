$(document).ready(function () {
    const moduloActual = "cargo";
    const tablaSelector = "#tablaCargo";

    const dataTable = instanciarDatatableGlobal('table#tablaCargo');
    ajaxConsultarCargo();
    const modalCargo = $('#modalCargo');
    let hasChanged = false;

    $.validator.addMethod("soloLetrasCargo", function (value, element) {
        return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value.trim());
    }, "Solo se permiten letras y espacios.");

    $('#formCargo').validate({
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
        onkeyup: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').val() === 'modificar') {
                verificarCambiosCargo();
            }
            evaluarBoton();
        },
        onfocusout: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').val() === 'modificar') {
                verificarCambiosCargo();
            }
            evaluarBoton();
        }
    });

    function verificarCambiosCargo() {
        const original = ($('#formCargo').attr('data-nombre-original') || '').trim();
        const actual = ($('#nombre').val() || '').trim();
        hasChanged = original !== actual;
    }

    function evaluarBoton() {
        const esValido = $('#formCargo').validate().checkForm();
        const btnEnviar = $('#btnSubmitModal');
        btnEnviar.prop('disabled', btnEnviar.val() === 'modificar' ? !(esValido && hasChanged) : !esValido);
    }

    $('#btnSubmitModal').on('click', function (event) {
        event.preventDefault();

        if ($('#formCargo').valid()) {
            const btnEnviar = $(this);
            const solicitud = btnEnviar.val();
            verificarCambiosCargo();

            if (solicitud === "modificar" && !hasChanged) {
                Swal.fire({
                    title: "Sin modificaciones",
                    text: "El nombre ingresado es igual al actual.",
                    icon: "info"
                });
                return false;
            }

            const datos = {
                cod_cargo: $("#cod_cargo").val(),
                nombre: $("#nombre").val().trim()
            };
            const objModal = bootstrap.Modal.getInstance(modalCargo[0]);

            ajaxEnvioDatosGlobal('cargo', solicitud, ajaxConsultarCargo, dataTable, datos, objModal, btnEnviar);
        } else {
            evaluarBoton();
        }
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
                    const button = `
                        <div class="text-center d-flex justify-content-center align-items-center gap-2">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Modificar"
                                data-bs-toggle="modal" data-bs-target="#modalCargo"
                                datos-cod-cargo="${dato.cod_cargo}" datos-nombre="${dato.nombre}">
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
        $('#formCargo').removeAttr('data-nombre-original');

        if (boton && boton.attr('title') === "Registrar") {
            $('#modalLabel').html('<i class="bi bi-person-badge"></i> Registrar Nuevo Cargo');
            $('#btnSubmitModal').val("registrar").html('<i class="bi bi-save"></i> Registrar').prop('disabled', true);
        } else if (boton && boton.attr('title') === "Modificar") {
            $('#modalLabel').html('<i class="bi bi-pencil-square"></i> Modificar Cargo');
            $('#cod_cargo').val(boton.attr('datos-cod-cargo'));
            $('#nombre').val(boton.attr('datos-nombre'));
            $('#formCargo').attr('data-nombre-original', $('#nombre').val());
            $('#btnSubmitModal').val("modificar").html('<i class="bi bi-save"></i> Guardar').prop('disabled', true);
        }
    }
});