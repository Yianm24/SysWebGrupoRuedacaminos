let montoInput;
let hasChanged = false;

$(document).ready(function () {
    ajaxConsultarPago();
    const modalPago = $('#modalPago');
    let montoBaseCalculo = 0;
    let tasasDelDia = { "VES": 1, "USD": 1, "USDT": 1, "EUR": 1 };
    
    const $inputTasasJson = $('#tasas_backend_json');
    if ($inputTasasJson.length && $inputTasasJson.val()) {
        try {
            let tasasBackend = JSON.parse($inputTasasJson.val());
            tasasDelDia['VES'] = 1; 
            tasasDelDia['USD'] = tasasBackend['USD'] || 1;
            tasasDelDia['EUR'] = tasasBackend['EUR'] || 1;
            tasasDelDia['USDT'] = tasasBackend['USDT'] || 1;
        } catch (error) { console.error("Error leyendo las tasas", error); }
    }

    if ($('#monto_ingresado').length) {
        $('#monto_ingresado').attr('autocomplete', 'off');
    }

    function inicializarAutoNumeric() {
        if (!montoInput && $('#monto_ingresado').length) {
            montoInput = new AutoNumeric('#monto_ingresado', {
                digitGroupSeparator: '.',
                decimalCharacter: ',',
                decimalPlaces: 2,
                maximumValue: '999999.99',
                minimumValue: '0',
                decimalPlacesShownOnFocus: 2,
                allowDecimalPadding: true,
                emptyInputBehavior: 'zero',
                unformatOnSubmit: true,
                modifyValueOnWheel: false,
                modifyValueOnUpDownArrow: false 
            });
            
            $('#monto_ingresado').on('autoNumeric:rawValueModified', function() {
                $(this).valid();
                calcularRestante(); 
                evaluarBotonModificar();
            });
        }
    }

    inicializarAutoNumeric();

    function parsearMonto(valor) {
        if (!valor) return 0;
        let numStr = String(valor).trim();
        if (numStr.includes('.') && numStr.includes(',')) {
            let ultimoPunto = numStr.lastIndexOf('.');
            let ultimaComa = numStr.lastIndexOf(',');
            if (ultimaComa > ultimoPunto) {
                numStr = numStr.replace(/\./g, '').replace(',', '.'); 
            } else {
                numStr = numStr.replace(/,/g, ''); 
            }
        } else if (numStr.includes(',') && !numStr.includes('.')) {
            numStr = numStr.replace(',', '.');
        }
        return parseFloat(numStr) || 0;
    }

    function formatearVisual(numero) {
        if (isNaN(numero) || numero === 0) return "0,00";
        return Number(numero).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    $.validator.addMethod("montoValido", function() {
        if (!montoInput) return false;
        let num = montoInput.getNumber();
        let estatusPago = $('#estatus_pago').val();
        let visual = $('#estatus_pago_visual').text();
        
        if (num === null || num <= 0 || num > 999999.99) return false;
        if (estatusPago === "0" && (visual === "Excedido" || visual === "Inválido")) return false;
        
        return true;
    }, "Monto inválido, excede el límite o supera la deuda.");

    $('#formPago').validate({
        onkeyup: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').val() === 'actualizar') hasChanged = true;
            evaluarBotonModificar();
        },
        onfocusout: function (element) {
            $(element).valid();
            if ($('#btnSubmitModal').val() === 'actualizar') hasChanged = true;
            evaluarBotonModificar(); 
        },
        onclick: function(element) {
            if (element.tagName === 'SELECT') {
                $(element).valid();
                if ($('#btnSubmitModal').val() === 'actualizar') hasChanged = true;
                setTimeout(() => { evaluarBotonModificar(); }, 0);
            }
        },
        rules: {
            monto_ingresado: { 
                required: true, 
                montoValido: true 
            },
            fecha_pago: { 
                required: true 
            },
            metodos: { 
                required: true 
            },
            cuentas: {
                required: true 
            },
            referencia: { 
                required: true 
            }
        },
        messages: {
            monto_ingresado: { 
                required: "Debe ingresar el monto abonado.", 
                montoValido: "Monto inválido o supera la deuda permitida." 
            },
            fecha_pago: { 
                required: "Seleccione una fecha." 
            },
            metodos: { 
                required: "Seleccione un método de pago." }
                ,
            cuentas: { 
                required: "Seleccione una cuenta destino." 
            },
            referencia: { 
                required: "Ingrese la referencia bancaria." 
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            let spanError = element.siblings('.mensaje-error');
            if(spanError.length) { spanError.text(error.text()).show(); } else { error.insertAfter(element); }
        },
        highlight: function (element) { $(element).addClass('is-invalid').removeClass('is-valid'); },
        unhighlight: function (element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
            let spanError = $(element).siblings('.mensaje-error');
            if(spanError.length) spanError.hide().text('');
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            
            const $btnSubmit = $('#btnSubmitModal');
            let solicitud = $btnSubmit.val();
            let montoPuro = montoInput ? montoInput.getNumber() : 0;
            $('#monto_ingresado').val(montoPuro.toFixed(2));

            if (solicitud === "actualizar" && $(form).attr('data-originales')) {
                const org = JSON.parse($(form).attr('data-originales'));
                const actualMonto = montoPuro;
                const actualRef = $('#referencia').val().trim();
                const actualMetodo = $('#metodos').val();
                const actualBanco = $('#cuentas').val();
                const actualFecha = $('#fecha_pago').val();

                if (org.monto === actualMonto && org.referencia === actualRef && org.metodo === actualMetodo && org.banco === actualBanco && org.fecha === actualFecha) {
                    Swal.fire({ 
                        title: "Sin modificaciones", 
                        text: "Los datos ingresados son iguales a los actuales.", 
                        icon: "info" });
                    return false;
                }
            }

            const datosObj = {
                cod_pago: $("#cod_pago").val(),
                cod_envio: $("#cod_envio").val(),
                cod_detallepago: $("#cod_detallepago").val(),
                fecha_pago: $("#fecha_pago").val(),
                monto: $("#monto_dolares_oculto").val(),
                monto_ingresado: montoPuro.toFixed(2),
                referencia: $("#referencia").val().trim(),
                metodos: $("#metodos").val(),
                cuentas: $("#cuentas").val()
            };

            ajaxEnvioDatosPago(solicitud, modalPago, $btnSubmit, { tipoSolicitud: solicitud, datos: datosObj });
        }
    });

    function evaluarBotonModificar() {
        setTimeout(() => {
            let validador = $('#formPago').validate();
            let esValido = validador.checkForm();
            let $btnSubmit = $('#btnSubmitModal');
            let solicitud = $btnSubmit.val();

            if (solicitud === 'actualizar') { $btnSubmit.prop('disabled', !(esValido && hasChanged)); } 
            else { $btnSubmit.prop('disabled', !esValido); }
        }, 50);
    }

    function filtrarBancos() {
        const $selectMetodo = $('#metodos');
        const $selectBanco = $('#cuentas');
        const $inputRef = $('#referencia');
        
        if (!$selectMetodo.length || !$selectBanco.length || $selectMetodo.prop('selectedIndex') <= 0) {
            evaluarBotonModificar(); return;
        }

        let esEfectivo = $selectMetodo.find('option:selected').text().toLowerCase().includes('efectivo');
        if ($inputRef.length) {
            if (esEfectivo) {
                $inputRef.val("EFECTIVO").prop('readonly', true).addClass('bg-light is-valid').removeClass('solo-numeros is-invalid'); 
                $inputRef.siblings('.mensaje-error').hide().text('');
            } else {
                if ($inputRef.val() === "EFECTIVO") $inputRef.val("");
                $inputRef.prop('readonly', false).removeClass('bg-light is-valid').addClass('solo-numeros');
            }
            $inputRef.trigger('input'); 
        }

        $selectBanco.find('option').each(function() {
            if ($(this).val() === "") return;
            let esCaja = $(this).text().toLowerCase().includes('caja');
            if (esEfectivo) {
                $(this).prop('disabled', !esCaja);
                if (esCaja) $selectBanco.val($(this).val()); 
            } else {
                $(this).prop('disabled', esCaja);
            }
        });
        if ($selectBanco.find('option:selected').prop('disabled')) { $selectBanco.val(""); }
        evaluarBotonModificar();
    }

    function calcularRestante() {
        let montoIngresado = montoInput ? montoInput.getNumber() : 0;
        const $selectMetodo = $('#metodos');
        
        let moneda = 'USD';
        if ($selectMetodo.length && $selectMetodo.prop('selectedIndex') >= 0) {
            let $opcion = $selectMetodo.find('option:selected');
            if ($opcion.length && !$opcion.prop('disabled')) moneda = $opcion.attr('data-moneda') || 'USD';
        }

        let dolaresCalculados = 0;
        let tasaUSD = tasasDelDia['USD'] || 1;
        if (moneda === 'USD') { dolaresCalculados = montoIngresado;
        } else if (moneda === 'VES') { dolaresCalculados = montoIngresado / tasaUSD;
        } else {
            let tasaMonedaExtranjera = tasasDelDia[moneda] || 1;
            dolaresCalculados = (montoIngresado * tasaMonedaExtranjera) / tasaUSD; 
        }

        let abonadoCents = Math.round(dolaresCalculados * 100);
        let deudaCents = Math.round(montoBaseCalculo * 100);
        let restanteCents = deudaCents - abonadoCents;
        let abonadoUSD = abonadoCents / 100;
        let mostrarRestanteUSD = Math.max(0, restanteCents / 100);
        
        const $simb = $('#simbolo_moneda_dinamico');
        const $oculto = $('#monto_dolares_oculto');
        const $restUSD = $('#monto_restante_dinamico');
        const $restBS = $('#monto_restante_bs_dinamico');

        if ($simb.length) $simb.html((moneda === 'VES') ? 'Bs' : (moneda === 'EUR' ? '€' : (moneda === 'USDT' ? 'USDT' : '$')));
        if ($oculto.length) $oculto.val(abonadoUSD.toFixed(2));
        if ($restUSD.length) { $restUSD.text(formatearVisual(mostrarRestanteUSD)).attr('class', 'input-group-text bg-white fw-bold'); }
        if ($restBS.length) { $restBS.text(formatearVisual(mostrarRestanteUSD * tasaUSD)).attr('class', 'input-group-text bg-white fw-bold'); }

        const $estatus = $('#estatus_pago');
        const $visual = $('#estatus_pago_visual');
        const $tarjeta = $('#tarjeta_estatus');

        const setEstatus = (val, texto, clTarjeta) => {
            if ($estatus.length) $estatus.val(val);
            if ($visual.length) $visual.text(texto);
            if ($tarjeta.length) $tarjeta.attr('class', `alert text-center shadow-sm mb-0 p-2 ${clTarjeta}`);
        };

        if (montoIngresado === 0 || montoIngresado === null) {
            setEstatus("0", "Pendiente", "alert-secondary text-dark");
        } else if (abonadoCents === 0) {
            setEstatus("0", "Inválido", "alert-danger text-white");
        } else if (restanteCents < 0 || montoIngresado > 999999.99) {
            setEstatus("0", "Excedido", "alert-danger text-white"); 
        } else {
            if (restanteCents === 0) { setEstatus("1", "Completado", "alert-success text-dark"); } 
            else { setEstatus("1", "Pendiente", "alert-warning text-dark"); }
        }
    }

    function autocompletarMonto() {
        const $selectMetodo = $('#metodos');
        let moneda = 'USD';
        if ($selectMetodo.length && $selectMetodo.prop('selectedIndex') >= 0) {
            let $opcion = $selectMetodo.find('option:selected');
            if ($opcion.length && !$opcion.prop('disabled')) moneda = $opcion.attr('data-moneda') || 'USD';
        }

        let tasaUSD = tasasDelDia['USD'] || 1;
        let baseUSD = Math.round(montoBaseCalculo * 100) / 100;
        let valorAutocompletado = 0;

        if (moneda === 'USD') { valorAutocompletado = baseUSD;
        } else if (moneda === 'VES') { valorAutocompletado = baseUSD * tasaUSD;
        } else {
            let tasaMonedaExtranjera = tasasDelDia[moneda] || 1;
            valorAutocompletado = (baseUSD * tasaUSD) / tasaMonedaExtranjera;
        }

        if (montoInput) {
            montoInput.set(valorAutocompletado);
            calcularRestante();
            evaluarBotonModificar();
        }
    }

    $('#btn_autocompletar').on('click', autocompletarMonto);

    $(document).on('change', '#metodos, #cuentas, #fecha_pago, #referencia', function () {
        if ($(this).attr('id') === 'metodos') {
            filtrarBancos();
            let curMonto = montoInput ? montoInput.getNumber() : 0;
            if(curMonto === 0 || curMonto === null) autocompletarMonto(); 
        }
        calcularRestante(); 
        evaluarBotonModificar();
    });

    if (modalPago.length) {
        modalPago.on('show.bs.modal', function (event) {
            inicializarAutoNumeric();

            const botonTrig = $(event.relatedTarget);
            const $tituloModal = $('#modalLabel');
            const $btnSubmit = $('#btnSubmitModal');
            const $formPago = $('#formPago');

            let validador = $formPago.validate();
            validador.resetForm();
            $formPago.find('input, select').removeClass('is-valid is-invalid');
            $('.mensaje-error').hide().text('');
            hasChanged = false;

            if (botonTrig.attr('title') === "Registrar" && parseFloat(botonTrig.attr('data-montorestante')) <= 0) {
                event.preventDefault();
                Swal.fire({ 
                    title: "Envío Solvente", 
                    text: "Este envío ya está pagado en su totalidad.", 
                    icon: "info" });
                return;
            }

            const $cod_pago = $('#cod_pago');
            const $cod_envio = $('#cod_envio');
            const $cod_detalle = $('#cod_detallepago');
            const $fecha = $('#fecha_pago');
            const $metodo = $('#metodos');
            const $banco = $('#cuentas');
            const $referencia = $('#referencia');

            $referencia.addClass('solo-numeros').prop('readonly', false);
            $btnSubmit.prop('disabled', true);

            if (botonTrig.attr('title') === "Registrar") {
                $tituloModal.html('<i class="bi bi-wallet2"></i> Registro de Pago');
                $('#div_codigo_envio').show();
                $('#codigo_envio_mostrar').text(botonTrig.attr('data-envio'));
                $btnSubmit.val("registrar").html('<i class="bi bi-save"></i> Registrar');

                montoBaseCalculo = parsearMonto(botonTrig.attr('data-montorestante'));
                $cod_pago.val("");
                $cod_envio.val(botonTrig.attr('data-envio'));
                $cod_detalle.val("");
                
                if(montoInput) montoInput.set(''); 

                $referencia.val("");
                $metodo.prop('selectedIndex', 0);
                $banco.find('option').prop('disabled', false);
                $banco.prop('selectedIndex', 0);
                
                const hoy = new Date();
                const dia = String(hoy.getDate()).padStart(2, '0');
                const mes = String(hoy.getMonth() + 1).padStart(2, '0');
                $fecha.val(`${hoy.getFullYear()}-${mes}-${dia}`);

                $formPago.removeAttr('data-originales');
                filtrarBancos(); calcularRestante();
                
            } else if (botonTrig.attr('title') === "Editar") {
                $tituloModal.html('<i class="bi bi-pencil-square"></i> Editar Pago');
                $('#div_codigo_envio').hide();
                $btnSubmit.val("actualizar").html('<i class="bi bi-save"></i> Actualizar');
                
                montoBaseCalculo = parsearMonto(botonTrig.attr('data-montobaseeditar'));
                $cod_pago.val(botonTrig.attr('data-id'));
                $cod_envio.val(botonTrig.attr('data-envio'));
                $cod_detalle.val(botonTrig.attr('data-detalle'));
                $fecha.val(botonTrig.attr('data-fecha'));

                let metodoGuardado = String(botonTrig.attr('data-metodo') || '');
                $metodo.val(metodoGuardado);
                if ($metodo.val() !== metodoGuardado) $metodo.prop('selectedIndex', 0);

                let montoOriginal_BD = parseFloat(botonTrig.attr('data-monto-original')) || 0;
                let montoUSD_BD = parseFloat(botonTrig.attr('data-monto')) || 0;

                if(montoOriginal_BD > 0 && montoUSD_BD > 0 && montoOriginal_BD !== montoUSD_BD) {
                    $formPago.attr('data-tasa-historica', montoOriginal_BD / montoUSD_BD);
                } else {
                    $formPago.attr('data-tasa-historica', 1);
                }

                if(montoInput) montoInput.set(montoOriginal_BD); 

                $referencia.val(botonTrig.attr('data-referencia'));
                filtrarBancos();
                $banco.val(String(botonTrig.attr('data-banco') || ''));

                const originales = {
                    monto: montoInput ? montoInput.getNumber() : montoOriginal_BD,
                    referencia: $referencia.val().trim(),
                    metodo: $metodo.val(),
                    banco: $banco.val(),
                    fecha: $fecha.val()
                };
                $formPago.attr('data-originales', JSON.stringify(originales));

                setTimeout(() => {
                    if ($referencia.val() !== 'EFECTIVO') { $referencia.trigger('input'); }
                    calcularRestante(); 
                    evaluarBotonModificar();
                }, 100);
            }
        });

        modalPago.on('hidden.bs.modal', function () {
            if (document.activeElement) document.activeElement.blur();
            if(montoInput) montoInput.set(''); 
        });
    }

    // Modal Anular / Eliminar Pago
    $("table tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        const idPago = $(this).attr("data-id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Está seguro que desea anular este pago?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxEnvioDatosPago("eliminar", null, null, { tipoSolicitud: 'eliminar', datos: { cod_pago: idPago } });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({ 
                        title: "Cancelado", 
                        text: "Anulación de pago cancelada", 
                        icon: "error" });
            }
        });
    });
});

function ajaxEnvioDatosPago(solicitud, modal, btnEnviar, datosForm) {
    const startTime = Date.now();
    $.ajax({
        url: "index.php?url=pago",
        type: "POST",
        dataType: "json",
        data: datosForm,
        beforeSend: function () {
            if (modal) { modal.modal('hide'); }
            if (btnEnviar) { $(btnEnviar).prop("disabled", true); }
            Swal.fire({ 
                title: 'Procesando...', text: 'Por favor espere un momento.', 
                allowOutsideClick: false, 
                didOpen: () => { if(document.activeElement) document.activeElement.blur(); Swal.showLoading(); } 
            });
        }
    })
    .done(function (response) {
        const elapsedTime = Date.now() - startTime;
        const delay = Math.max(0, 500 - elapsedTime);
        setTimeout(() => {
            mostrarAlerta(response.status, response.message);
            ajaxConsultarPago();
        }, delay);
    })
    .fail(function (xhr, status, error) {
        console.error("Error AJAX:", error);
        console.log("Respuesta cruda del servidor:", xhr.responseText);
        Swal.fire({ title: "Error de Servidor", text: "Ocurrió un problema de conexión al procesar la solicitud.", icon: "error" });
    })
    .always(function () {
        if (btnEnviar) { $(btnEnviar).prop("disabled", false); }
    });
}

function ajaxConsultarPago() {
    $.ajax({
        url: "index.php?url=pago", 
        type: "POST", 
        dataType: "json", 
        data: { tipoSolicitud: "consultar" } 
    }).done(function (response) { 
        let tbody = $("table tbody");
        tbody.empty();

        if (Array.isArray(response) && response.length > 0) {
            let rowsHtml = "";
            $.each(response, function (index, dato) {
                let badgeEstatus = dato.estado_envio == 1 ? '<span class="badge bg-success">Completado</span>' : '<span class="badge bg-warning text-dark">Pendiente</span>';
                
                let formatearNum = (num) => Number(num).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                
                let restante = parseFloat(dato.monto_total) - parseFloat(dato.total_abonado_envio);
                restante = restante < 0 ? 0 : restante;

                rowsHtml += `
                    <tr>
                        <td class="ps-4 fw-bold text-dark">${dato.cod_envio}</td>
                        <td>${badgeEstatus}</td>
                        <td class="text-secondary fw-medium">$${formatearNum(dato.monto_total)}</td>
                        <td class="text-secondary">$${formatearNum(dato.monto_abonado_usd)}</td>
                        <td class="text-secondary">$${formatearNum(restante)}</td>
                        <td>
                            <button type="button" class="btn btn-outline-secondary btn-sm" title="Registrar" data-bs-toggle="modal" data-bs-target="#modalPago"
                                data-envio="${dato.cod_envio}" data-montorestante="${restante}">
                                <i class="bi bi-folder-plus"></i> Añadir
                            </button>
                        </td>
                        <td class="text-end pe-4">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline me-3 btn-editar" title="Editar" data-bs-toggle="modal" data-bs-target="#modalPago"
                                data-id="${dato.cod_pago}" data-envio="${dato.cod_envio}" data-detalle="${dato.cod_detallepago}" data-fecha="${dato.fecha}" 
                                data-metodo="${dato.cod_metodopago}" data-banco="${dato.cod_banco}" data-monto="${dato.monto_abonado_usd}" data-monto-original="${dato.monto_ingresado_original}" data-referencia="${dato.referencia}" data-montobaseeditar="${parseFloat(dato.monto_total) - (parseFloat(dato.total_abonado_envio) - parseFloat(dato.monto_abonado_usd))}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar" title="Eliminar" data-id="${dato.cod_pago}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            tbody.html(rowsHtml);
        } else {
            tbody.html('<tr><td colspan="7" class="text-center text-muted py-4">No hay pagos registrados.</td></tr>');
        }
    })
    .fail(function (xhr, status, error) { 
        console.error(`Error AJAX al cargar pagos:`, error); 
        console.log("Respuesta cruda del servidor:", xhr.responseText);
        Swal.fire({ title: "Error de Servidor", text: "Ocurrió un problema de conexión al procesar la solicitud.", icon: "error" });
    });
}

// Mensajes y alertas
function mostrarAlerta(status, mensaje = "") {
    let title, text, icon;
    switch (status) {
        case 'success':
            title = "Registro exitoso!"; 
            text = mensaje !== "" ? mensaje : "El pago ha sido registrado correctamente."; 
            icon = "success"; break;
        case 'updated':
            title = "Actualización exitosa!"; 
            text = mensaje !== "" ? mensaje : "El pago ha sido modificado correctamente."; 
            icon = "success"; break;
        case 'deleted':
            title = "¡Anulado!"; 
            text = mensaje !== "" ? mensaje : "El pago ha sido anulado correctamente."; 
            icon = "success"; break;
        case 'completed':
            title = "¡Envío solvente!"; 
            text = mensaje !== "" ? mensaje : "El pago del envío ya fue completado previamente al 100%."; 
            icon = "warning"; break;
        case 'exists_ref':
            title = "¡Referencia existente!"; 
            text = mensaje !== "" ? mensaje : "Ya existe un pago registrado con la referencia bancaria ingresada."; 
            icon = "warning"; break;
        case 'pending_error':
            title = "Acción bloqueada"; 
            text = mensaje !== "" ? mensaje : "No se puede anular un pago de un envío que aún no ha sido ANULADO."; 
            icon = "error"; break;
        case 'empty': 
            title = "Campos vacíos!"; 
            text = mensaje !== "" ? mensaje : "Uno o más campos están vacíos."; 
            icon = "warning"; break;
        case 'error': 
            title = "Error!"; 
            text = mensaje !== "" ? mensaje : `Se produjo un error en el proceso.`; 
            icon = "error"; break;
        case 'exception': 
            title = "Exception Retornada!"; 
            text = mensaje !== "" ? mensaje : `El servidor devolvió una excepción.`; 
            icon = "error"; break;
    }
    if (title && text && icon) {
        Swal.fire({ 
            title: title, text: text, icon: icon, 
            didOpen: () => { if(document.activeElement) document.activeElement.blur(); },
            willClose: () => { if(document.activeElement) document.activeElement.blur(); }
        });
    }
}