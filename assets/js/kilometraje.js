let kmInput = null;
let precioInput = null;
let hasChanged = false;

$(document).ready(function () {
    const moduloActual = "kilometraje";
    const tablaSelector = "#tablaPrecios";
    const modalKilometraje = $('#modalKilometraje');

    const dataTable = instanciarDatatableGlobal(`table${tablaSelector}`);
    ajaxConsultarKilometraje();

    $('#inputBusqueda').on('keyup input', function () {
        dataTable.search($(this).val()).draw();
    });

    const opcionesDecimal = {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        decimalPlaces: 2,
        maximumValue: '99999.99',
        minimumValue: '0',
        decimalPlacesShownOnFocus: 2,
        allowDecimalPadding: true,
        emptyInputBehavior: 'zero',
        unformatOnSubmit: true,
        modifyValueOnWheel: false,
        modifyValueOnUpDownArrow: false
    };

    function inicializarAutoNumeric(selector) {
        const elemento = $(selector);
        if (!elemento.length) return null;
        elemento.attr('autocomplete', 'off');
        return new AutoNumeric(selector, opcionesDecimal);
    }

    kmInput = inicializarAutoNumeric('#kilometraje_input');
    precioInput = inicializarAutoNumeric('#precio_kilometraje');

    $.validator.addMethod("rangoKilometraje", function (value, element) {
        if (!kmInput) return false;
        const num = kmInput.getNumber();
        return num !== null && !isNaN(num) && Number(num) >= 1 && Number(num) <= 99999.99;
    }, "El kilometraje debe estar entre 1,00 y 99.999,99");

    $.validator.addMethod("rangoPrecio", function (value, element) {
        if (!precioInput) return false;
        const num = precioInput.getNumber();
        return num !== null && !isNaN(num) && Number(num) > 0 && Number(num) <= 99999.99;
    }, "El precio debe ser mayor a 0,00 y no superar 99.999,99");

    $('#formKilometraje').validate({
        onfocusout: false,
        onkeyup: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').attr('value') === 'actualizar') {
                verificarCambiosKilometraje();
            }
            evaluarBotonModificar();
        },
        rules: {
            kilometraje: {
                required: true,
                rangoKilometraje: true
            },
            precio_kilometraje: {
                required: true,
                rangoPrecio: true
            }
        },
        messages: {
            kilometraje: {
                required: "Debe ingresar el kilometraje.",
                rangoKilometraje: "El kilometraje debe estar entre 1,00 y 99.999,99"
            },
            precio_kilometraje: {
                required: "Debe ingresar el precio.",
                rangoPrecio: "El precio debe ser mayor a 0,00 y no superar 99.999,99"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            let spanError = element.siblings('.mensaje-error');
            if (!spanError.length) {
                spanError = element.closest('.col-md-12, .mb-3').find('.mensaje-error');
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
                spanError = $(element).closest('.col-md-12, .mb-3').find('.mensaje-error');
            }
            spanError.hide().text('');
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const btnEnviar = $('#btnSubmitModal');
            const solicitud = btnEnviar.attr('value');
            const kmLimpio = kmInput ? (parseFloat(kmInput.getNumber()) || 0) : 0;
            const precioLimpio = precioInput ? (parseFloat(precioInput.getNumber()) || 0) : 0;

            if (solicitud === "actualizar") {
                verificarCambiosKilometraje();
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
                cod_preciokilometraje: $("#id_tarifa").val(),
                kilometraje: kmLimpio.toFixed(2),
                precio_kilometraje: precioLimpio.toFixed(2)
            };

            const objModal = bootstrap.Modal.getInstance(modalKilometraje[0]) || new bootstrap.Modal(modalKilometraje[0]);
            ajaxEnvioDatosGlobal(moduloActual, solicitud, ajaxConsultarKilometraje, dataTable, datos, objModal, btnEnviar);
        }
    });

    $('#kilometraje_input, #precio_kilometraje').on('keyup input autoNumeric:rawValueModified', function () {
        if ($('#btnSubmitModal').attr('value') === 'actualizar') {
            verificarCambiosKilometraje();
        }
        evaluarBotonModificar();
    });

    $('#btnSubmitModal').on('click', function (event) {
        event.preventDefault();
        $('#formKilometraje').trigger('submit');
    });

    function verificarCambiosKilometraje() {
        const originalesAttr = $('#formKilometraje').attr('data-originales');
        if (!originalesAttr) {
            hasChanged = false;
            return;
        }
        const originales = JSON.parse(originalesAttr);
        const kmOriginal = parseFloat(originales.km) || 0;
        const precioOriginal = parseFloat(originales.precio) || 0;
        const kmActual = kmInput ? (parseFloat(kmInput.getNumber()) || 0) : 0;
        const precioActual = precioInput ? (parseFloat(precioInput.getNumber()) || 0) : 0;

        hasChanged = (kmOriginal.toFixed(2) !== kmActual.toFixed(2)) || (precioOriginal.toFixed(2) !== precioActual.toFixed(2));
    }

    function evaluarBotonModificar() {
        const btnEnviar = $('#btnSubmitModal');
        const solicitud = btnEnviar.attr('value');
        const kmNum = kmInput ? (parseFloat(kmInput.getNumber()) || 0) : 0;
        const precioNum = precioInput ? (parseFloat(precioInput.getNumber()) || 0) : 0;
        const valValidos = kmNum >= 1 && kmNum <= 99999.99 && precioNum > 0 && precioNum <= 99999.99;

        if (solicitud === 'actualizar') {
            btnEnviar.prop('disabled', !(valValidos && hasChanged));
        } else {
            btnEnviar.prop('disabled', !valValidos);
        }
    }

    if (modalKilometraje.length) {
        modalKilometraje.on('show.bs.modal', function (event) {
            const boton = $(event.relatedTarget);
            accionModalKilometraje(boton);
        });

        modalKilometraje.on('shown.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
            evaluarBotonModificar();
        });

        modalKilometraje.on('hidden.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
            if (kmInput) kmInput.set('');
            if (precioInput) precioInput.set('');
        });
    }

    $(tablaSelector + " tbody").on("click", ".btn-eliminar", function (event) {
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
            didOpen: () => { if (document.activeElement) document.activeElement.blur(); }
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxEnvioDatosGlobal(moduloActual, 'eliminar', ajaxConsultarKilometraje, dataTable, { cod_preciokilometraje: idTarifa }, null, null);
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

    function ajaxConsultarKilometraje() {
        ajaxConsultarGlobal(moduloActual, function (response) {
            dataTable.clear();

            if (Array.isArray(response) && response.length > 0) {
                $.each(response, function (index, dato) {
                    const kmNum = parseFloat(dato.kilometraje) || 0;
                    const precioNum = parseFloat(dato.monto_tarifa) || 0;

                    const kmFormateado = kmNum.toLocaleString('es-VE', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                        useGrouping: true
                    });

                    const precioFormateado = precioNum.toLocaleString('es-VE', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                        useGrouping: true
                    });

                    const botones = `
                        <div class="d-inline-flex align-items-center gap-2">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline me-3 btn-editar"
                                title="Editar" data-bs-toggle="modal" data-bs-target="#modalKilometraje"
                                data-id="${dato.cod_preciokilometraje}"
                                data-kilometraje="${kmNum}"
                                data-precio="${precioNum}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar"
                                title="Eliminar" data-id="${dato.cod_preciokilometraje}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;

                    dataTable.row.add([
                        `<span class="ps-4 fw-medium">T-${dato.cod_preciokilometraje}</span>`,
                        `<span class="text-secondary">${kmFormateado} KM</span>`,
                        `<span class="text-secondary">$ ${precioFormateado}</span>`,
                        `<div class="pe-4 text-center">${botones}</div>`
                    ]);
                });
            }

            dataTable.draw();
        });
    }

    function accionModalKilometraje(boton) {
        if (document.activeElement) document.activeElement.blur();
        hasChanged = false;
        const tituloModal = $('#modalLabel');
        const btnSubmit = $('#btnSubmitModal');

        const validador = $('#formKilometraje').validate();
        validador.resetForm();
        $('#formKilometraje input, #formKilometraje select').removeClass('is-valid is-invalid');
        $('.mensaje-error').hide().text('');
        $('#formKilometraje').removeAttr('data-originales');

        if (boton && boton.attr('title') === "Registrar") {
            tituloModal.html('<i class="bi bi-currency-dollar"></i> Registrar Precio de Kilometraje');
            btnSubmit.val("registrar").html('<i class="bi bi-save"></i> Registrar');

            $("#id_tarifa").val("");
            if (kmInput) kmInput.set('');
            if (precioInput) precioInput.set('');
            btnSubmit.prop('disabled', true);

        } else if (boton && boton.attr('title') === "Editar") {
            tituloModal.html('<i class="bi bi-pencil-square"></i> Editar Precio de Kilometraje');
            btnSubmit.val("actualizar").html('<i class="bi bi-save"></i> Guardar');

            const kmVal = parseFloat(boton.attr('data-kilometraje')) || 0;
            const precioVal = parseFloat(boton.attr('data-precio')) || 0;

            $("#id_tarifa").val(boton.attr('data-id'));
            if (kmInput) kmInput.set(kmVal);
            if (precioInput) precioInput.set(precioVal);

            $('#formKilometraje').attr('data-originales', JSON.stringify({
                km: kmVal,
                precio: precioVal
            }));
            btnSubmit.prop('disabled', true);
        }
    }
});