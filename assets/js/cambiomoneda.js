let tasaInput;
let hasChanged = false;
let tablaCambioDt = null;

$(document).ready(function () {
    const $tablaElem = $('#tablaCambio');
    const esAdmin = $tablaElem.attr('data-es-admin') === '1';
    const modalCambio = $('#modalCambio');

    if (document.getElementById('tasa')) {
        $('#tasa').attr('autocomplete', 'off');
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

    const columnasConfig = [
        {
            data: 'fecha',
            className: 'ps-4 fw-medium',
            render: function (data) {
                if (!data) return '';
                const fechaObjeto = new Date(String(data).replace(' ', 'T'));
                if (isNaN(fechaObjeto.getTime())) return String(data);
                return fechaObjeto.toLocaleDateString('es-VE', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            }
        },
        {
            data: 'fecha',
            className: 'text-secondary',
            render: function (data) {
                if (!data) return '';
                const fechaObjeto = new Date(String(data).replace(' ', 'T'));
                if (isNaN(fechaObjeto.getTime())) return '';
                return fechaObjeto.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        },
        {
            data: 'abreviatura',
            className: 'text-secondary'
        },
        {
            data: 'tasa',
            className: 'fw-bold',
            render: function (data, type, row) {
                const actual = parseFloat(data) || 0;
                const anterior = (row.tasa_anterior !== null && row.tasa_anterior !== undefined)
                    ? (parseFloat(row.tasa_anterior) || actual)
                    : actual;

                let color = 'text-secondary';
                let icono = 'bi-dash';

                if (actual > anterior) {
                    color = 'text-success';
                    icono = 'bi-arrow-up';
                } else if (actual < anterior) {
                    color = 'text-danger';
                    icono = 'bi-arrow-down';
                }

                const tasaFormateada = actual.toLocaleString('es-VE', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                    useGrouping: true
                });

                const flechaHtml = icono !== 'bi-dash'
                    ? `<small class="${color} ms-1"><i class="bi ${icono}"></i></small>`
                    : '';

                return `${tasaFormateada} VES ${flechaHtml}`;
            }
        }
    ];

    if (esAdmin) {
        columnasConfig.push({
            data: null,
            orderable: false,
            className: 'pe-4 text-center',
            render: function (data, type, row) {
                return `
                    <div class="d-inline-flex align-items-center gap-2">
                        <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-editar"
                            title="Editar" data-bs-toggle="modal" data-bs-target="#modalCambio"
                            data-id="${row.cod_cambio}" data-moneda="${row.cod_moneda}" data-tasa="${parseFloat(row.tasa) || 0}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar"
                            title="Eliminar" data-id="${row.cod_cambio}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        });
    }

    if ($tablaElem.length) {
        tablaCambioDt = $tablaElem.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'index.php?url=cambiomoneda',
                type: 'POST',
                data: {
                    tipoSolicitud: 'consultar'
                },
                error: function (xhr, error, thrown) {
                    console.error('Error DataTables Server-Side:', error, thrown);
                    console.log('Respuesta cruda del servidor:', xhr.responseText);
                }
            },
            language: {
                url: 'assets/json/datatable.json'
            },
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 20, 30, -1], [10, 20, 30, 'Todos']],
            order: [[0, 'desc']],
            columns: columnasConfig
        });
    }

    if (modalCambio.length) {
        modalCambio.on('show.bs.modal', function (event) {
            const boton = $(event.relatedTarget);
            accionModalCambio(boton);
        });

        modalCambio.on('shown.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
            evaluarBotonModificar();
        });

        modalCambio.on('hidden.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
            if (tasaInput) tasaInput.set('');
        });
    }

    $.validator.addMethod("montoValido", function () {
        if (!tasaInput) return false;
        let num = tasaInput.getNumber();
        return num !== null && !isNaN(num) && Number(num) > 0;
    }, "Debe ser mayor a 0.");

    $('#formCambio').validate({
        onfocusout: false,
        onkeyup: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').attr('value') === 'actualizar') {
                verificarCambiosCambio();
            }
            evaluarBotonModificar();
        },
        onclick: function (element) {
            if (element.tagName === 'SELECT') {
                $(element).valid();
                if ($('#btnSubmitModal').attr('value') === 'actualizar') {
                    verificarCambiosCambio();
                }
                evaluarBotonModificar();
            }
        },
        rules: {
            moneda: {
                required: true
            },
            tasa: {
                required: true,
                montoValido: true
            }
        },
        messages: {
            moneda: {
                required: "Debe seleccionar una moneda."
            },
            tasa: {
                required: "Debe ingresar el valor de la tasa.",
                montoValido: "Monto inválido. Ingrese un valor mayor a 0."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            let spanError = element.siblings('.mensaje-error');
            if (!spanError.length) {
                spanError = element.closest('.mb-3').find('.mensaje-error');
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
                spanError = $(element).closest('.mb-3').find('.mensaje-error');
            }
            spanError.hide().text('');
        },
        submitHandler: function (form, event) {
            event.preventDefault();

            const btnEnviar = $('#btnSubmitModal');
            const solicitud = btnEnviar.attr('value');
            const tasaLimpia = tasaInput ? tasaInput.getNumber() : 0;

            if (solicitud === "actualizar") {
                verificarCambiosCambio();
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
                cod_cambio: $("#id_cambio").val(),
                moneda: $("#moneda").val(),
                tasa: (Number(tasaLimpia) || 0).toFixed(2)
            };

            const objModal = bootstrap.Modal.getInstance(modalCambio[0]);
            ajaxEnvioDatosGlobal('cambiomoneda', solicitud, null, tablaCambioDt, datos, objModal, btnEnviar);
        }
    });

    $('#tasa').on('keyup input autoNumeric:rawValueModified', function () {
        if ($('#btnSubmitModal').attr('value') === 'actualizar') {
            verificarCambiosCambio();
        }
        evaluarBotonModificar();
    });

    $('#btnSubmitModal').on('click', function (event) {
        event.preventDefault();
        $('#formCambio').trigger('submit');
    });

    $('#formCambio select').on('change', function () {
        $(this).valid();
        if ($('#btnSubmitModal').attr('value') === 'actualizar') {
            verificarCambiosCambio();
        }
        evaluarBotonModificar();
    });

    function verificarCambiosCambio() {
        const originalesAttr = $('#formCambio').attr('data-originales');
        if (!originalesAttr) {
            hasChanged = false;
            return;
        }
        const originales = JSON.parse(originalesAttr);
        const tasaOriginal = parseFloat(originales.tasa) || 0;
        const monedaOriginal = String(originales.moneda || '');
        const tasaActual = tasaInput ? (parseFloat(tasaInput.getNumber()) || 0) : 0;
        const monedaActual = String($("#moneda").val() || '');

        hasChanged = (tasaOriginal.toFixed(2) !== tasaActual.toFixed(2)) || (monedaOriginal !== monedaActual);
    }

    function evaluarBotonModificar() {
        const btnEnviar = $('#btnSubmitModal');
        const solicitud = btnEnviar.attr('value');
        const tasaNumerica = tasaInput ? tasaInput.getNumber() : 0;
        const monedaVal = $("#moneda").val();

        const monedaOk = monedaVal !== null && monedaVal !== "";
        const tasaOk = tasaNumerica !== null && !isNaN(tasaNumerica) && Number(tasaNumerica) > 0;
        const valValidos = monedaOk && tasaOk;

        if (solicitud === 'actualizar') {
            btnEnviar.prop('disabled', !(valValidos && hasChanged));
        } else {
            btnEnviar.prop('disabled', !valValidos);
        }
    }

    $("#tablaCambio tbody").on("click", ".btn-eliminar", function (event) {
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
            didOpen: () => { if (document.activeElement) document.activeElement.blur(); }
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxEnvioDatosGlobal('cambiomoneda', 'eliminar', null, tablaCambioDt, { cod_cambio: idCambio }, null, null);
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
});

function accionModalCambio(boton) {
    if (document.activeElement) document.activeElement.blur();
    hasChanged = false;
    const tituloModal = $('#modalLabel');
    const btnSubmit = $('#btnSubmitModal');

    let validador = $('#formCambio').validate();
    validador.resetForm();
    $('#formCambio input, #formCambio select').removeClass('is-valid is-invalid');
    $('.mensaje-error').hide().text('');
    $('#formCambio').removeAttr('data-originales');

    if (boton && boton.attr('title') === "Registrar") {
        tituloModal.html('<i class="bi bi-currency-exchange"></i> Registrar Cambio Moneda');
        btnSubmit.val("registrar").html('<i class="bi bi-save"></i> Registrar');

        $("#id_cambio, #moneda").val("");
        if (tasaInput) tasaInput.set('');
        btnSubmit.prop('disabled', true);

    } else if (boton && boton.attr('title') === "Editar") {
        tituloModal.html('<i class="bi bi-pencil-square"></i> Editar Tasa de Cambio');
        btnSubmit.val("actualizar").html('<i class="bi bi-save"></i> Guardar');

        $("#id_cambio").val(boton.attr('data-id'));
        $("#moneda").val(boton.attr('data-moneda'));

        if (tasaInput) tasaInput.set(boton.attr('data-tasa'));

        const datosOriginales = {
            moneda: String(boton.attr('data-moneda') || ''),
            tasa: parseFloat(boton.attr('data-tasa')) || 0
        };
        $('#formCambio').attr('data-originales', JSON.stringify(datosOriginales));
        btnSubmit.prop('disabled', true);
    }
}