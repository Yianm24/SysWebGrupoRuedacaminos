let montoInput = null;
let hasChanged = false;
let modoModalActual = null;

$(document).ready(function () {
    const moduloActual = "pago";
    const tablaSelector = "#tablaPagos";
    const modalPago = $('#modalPago');
    const $formPago = $('#formPago');
    const $btnSubmit = $('#btnSubmitModal');
    const esAdmin = $(tablaSelector).attr('data-es-admin') === '1';

    let montoBaseCalculo = 0;
    let totalAbonadoModal = 0;
    let montoTotalEnvioModal = 0;
    let pagosEnvioEditarCache = [];
    let pagoEditandoActual = null;
    let tasasDelDia = { "VES": 1 };

    function bloquearFechaPago(valorFecha) {
        const $f = $('#fecha_pago');
        if (valorFecha !== undefined) $f.val(valorFecha);
        $f.prop('readonly', true).attr('tabindex', '-1').addClass('bg-light');
    }

    bloquearFechaPago();

    const $inputTasasJson = $('#tasas_backend_json');
    if ($inputTasasJson.length && $inputTasasJson.val()) {
        try {
            const tasasBackend = JSON.parse($inputTasasJson.val());
            Object.keys(tasasBackend).forEach(function (abrev) {
                const clave = String(abrev).toUpperCase().trim();
                const valor = parseFloat(tasasBackend[abrev]);
                if (valor > 0) tasasDelDia[clave] = valor;
            });
            tasasDelDia['VES'] = 1;
        } catch (error) {
            console.error("Error leyendo las tasas desde la BD", error);
        }
    }

    const opcionesMonto = {
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
    };

    function inicializarAutoNumeric(selector) {
        const elemento = $(selector);
        if (!elemento.length) return null;
        elemento.attr('autocomplete', 'off');
        return AutoNumeric.getAutoNumericElement(elemento[0]) || new AutoNumeric(selector, opcionesMonto);
    }

    montoInput = inicializarAutoNumeric('#monto_ingresado');

    const getMontoNum = () => (montoInput ? (parseFloat(montoInput.getNumber()) || 0) : 0);
    const simboloMoneda = (mon) => {
        const m = (mon || 'USD').toUpperCase();
        return m === 'VES' ? 'Bs' : (m === 'EUR' ? '€' : (m === 'USDT' ? 'USDT' : '$'));
    };

    function monedaSeleccionada() {
        const $opt = $('#metodos').find('option:selected');
        return ($opt.length && !$opt.prop('disabled')) ? ($opt.attr('data-moneda') || 'USD').toUpperCase() : 'USD';
    }

    function esMetodoEfectivo() {
        const $sel = $('#metodos');
        if (!$sel.length || $sel.prop('selectedIndex') <= 0) return false;
        return (($sel.find('option:selected').text() || '').toLowerCase().includes('efectivo'));
    }

    function toggleCamposPagoNoEfectivo(habilitar) {
        const $banco = $('#cuentas');
        const $ref = $('#referencia');

        if ($ref.length) {
            if (!habilitar) $ref.val('');
            $ref.prop('disabled', !habilitar).prop('readonly', !habilitar).attr('tabindex', habilitar ? '0' : '-1')
                .css({ 'pointer-events': habilitar ? '' : 'none', 'user-select': habilitar ? '' : 'none' })
                .toggleClass('solo-numeros', habilitar).toggleClass('bg-light', !habilitar);
            if (!habilitar) {
                $ref.removeClass('is-invalid is-valid').blur().closest('.col-md-4').find('.mensaje-error').hide().text('');
            }
        }
        if ($banco.length) {
            if (!habilitar) $banco.prop('selectedIndex', 0);
            $banco.prop('disabled', !habilitar).attr('tabindex', habilitar ? '0' : '-1')
                .css({ 'pointer-events': habilitar ? '' : 'none', 'user-select': habilitar ? '' : 'none' });
            if (!habilitar) {
                $banco.removeClass('is-invalid is-valid').blur().closest('.col-md-4').find('.mensaje-error').hide().text('');
            }
        }
    }

    function parsearMonto(valor) {
        if (valor === null || valor === undefined || valor === '') return 0;
        if (typeof valor === 'number') return isNaN(valor) ? 0 : valor;
        let numStr = String(valor).trim();
        if (numStr.includes('.') && numStr.includes(',')) {
            numStr = (numStr.lastIndexOf(',') > numStr.lastIndexOf('.'))
                ? numStr.replace(/\./g, '').replace(',', '.')
                : numStr.replace(/,/g, '');
        } else if (numStr.includes(',') && !numStr.includes('.')) {
            numStr = numStr.replace(',', '.');
        }
        return parseFloat(numStr) || 0;
    }

    function formatearVisual(numero) {
        if (isNaN(numero) || numero === 0) return "0,00";
        return Number(numero).toLocaleString('es-VE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
            useGrouping: true
        });
    }

    function formatearCantidadPagos(cantidad) {
        const n = parseInt(cantidad, 10) || 0;
        if (n <= 0) return '<span class="text-muted small">0 pagos</span>';
        return `<span class="badge bg-light text-dark border">${n} ${n === 1 ? 'pago' : 'pagos'}</span>`;
    }

    function formatearFechaHoraHistorial(fecha, hora) {
        const fechaLimpia = (fecha && String(fecha).trim() !== '' && String(fecha).trim() !== '0000-00-00')
            ? String(fecha).trim()
            : '-';

        let horaLimpia = '';
        if (hora !== null && hora !== undefined) {
            const strHora = String(hora).trim();
            if (
                strHora !== '' &&
                strHora !== '00:00:00' &&
                strHora !== '0000-00-00 00:00:00' &&
                strHora.toLowerCase() !== 'null'
            ) {
                const matchHora = strHora.match(/(\d{2}:\d{2}(?::\d{2})?)/);
                if (matchHora) {
                    horaLimpia = matchHora[1];
                }
            }
        }

        return horaLimpia
            ? `${fechaLimpia} <span class="badge bg-light text-secondary border ms-1">${horaLimpia}</span>`
            : `${fechaLimpia} <small class="text-muted ms-1">Sin hora</small>`;
    }

    function formatearTasaConFechaHora(pago) {
        const moneda = (pago.moneda_metodo || 'USD').toUpperCase();
        if (moneda === 'USD') return '<span class="text-muted small">Directo USD (1,00)</span>';
        const tasa = parseFloat(pago.tasa_referencia) || 1;
        const unidad = pago.unidad_tasa || 'VES';
        const fechaTasaRaw = pago.fecha_tasa || '';
        let fechaHoraTasaHtml = '';
        if (fechaTasaRaw && !String(fechaTasaRaw).startsWith('0000-00-00')) {
            const partes = String(fechaTasaRaw).trim().split(' ');
            fechaHoraTasaHtml = `<div class="small text-muted">${partes[0] || ''}${partes[1] ? ' ' + partes[1] : ''}</div>`;
        }
        return `<span class="fw-medium text-secondary">${formatearVisual(tasa)} <small>${unidad}</small></span>${fechaHoraTasaHtml}`;
    }

    function obtenerTasasEfectivasParaCalculo(moneda) {
        const mon = (moneda || 'USD').toUpperCase();
        let tasaUsd = parseFloat(tasasDelDia['USD']) || 0;
        let tasaMoneda = mon === 'VES' ? 1 : (parseFloat(tasasDelDia[mon]) || 0);

        if (modoModalActual === 'actualizar' && pagoEditandoActual) {
            const fechaActualForm = ($('#fecha_pago').val() || '').trim();
            const fechaOriginalPago = String(pagoEditandoActual.fecha || '').trim();
            const monedaOriginalPago = String(pagoEditandoActual.moneda_metodo || '').toUpperCase();

            if (!fechaActualForm || fechaActualForm === fechaOriginalPago) {
                if (parseFloat(pagoEditandoActual.tasa_usd_dia) > 0) tasaUsd = parseFloat(pagoEditandoActual.tasa_usd_dia);
                if (mon === monedaOriginalPago && parseFloat(pagoEditandoActual.tasa_referencia) > 0) {
                    tasaMoneda = parseFloat(pagoEditandoActual.tasa_referencia);
                }
            }
        }
        return { tasaUsd, tasaMoneda };
    }

    function calcularUsdDesdeMoneda(montoIngresado, moneda) {
        const mon = (moneda || 'USD').toUpperCase();
        const { tasaUsd, tasaMoneda } = obtenerTasasEfectivasParaCalculo(mon);

        if (mon === 'USD') return { dolares: montoIngresado, tasaUsada: 1, textoTasa: '' };
        if (tasaUsd <= 0 || (mon !== 'VES' && tasaMoneda <= 0)) {
            return { dolares: 0, tasaUsada: 0, textoTasa: `(Sin tasa activa en BD para ${mon}/USD)` };
        }
        if (mon === 'VES') {
            return { dolares: montoIngresado / tasaUsd, tasaUsada: tasaUsd, textoTasa: `(Tasa: ${formatearVisual(tasaUsd)} VES/USD)` };
        }
        return {
            dolares: (montoIngresado * tasaMoneda) / tasaUsd,
            tasaUsada: tasaMoneda,
            textoTasa: `(Tasa ${mon}: ${formatearVisual(tasaMoneda)} VES | USD: ${formatearVisual(tasaUsd)} VES)`
        };
    }

    function obtenerTextoEstatusEnvio(dato) {
        if (dato && dato.estatus_calculado) return String(dato.estatus_calculado);
        const cantidadPagos = parseInt(dato.cantidad_pagos, 10) || 0;
        const tienePago = cantidadPagos > 0 || !!(dato.ultimo_cod_pago);
        const montoTotal = parseFloat(dato.monto_total) || 0;
        const totalAbonado = parseFloat(dato.total_abonado_envio) || 0;
        const restante = Math.max(0, Math.round((montoTotal - totalAbonado) * 100) / 100);
        const envioAnulado = (String(dato.estado_envio) === '0') || (String(dato.estatus_envio || '').toUpperCase() === 'ANULADO');

        if (envioAnulado) return "Anulado";
        if (tienePago && restante <= 0) return "Completado";
        if (tienePago || totalAbonado > 0) return "Pendiente";
        return "Sin pagos";
    }

    const columnasPago = [
        { data: 'cod_envio', className: 'ps-4 fw-bold text-dark', render: (d) => `#${d}` },
        {
            data: 'estatus_calculado',
            className: 'text-center',
            render: function (data, type, dato) {
                const texto = obtenerTextoEstatusEnvio(dato);
                if (type === 'filter' || type === 'sort') return texto;
                const mapBadge = {
                    'Anulado': '<span class="badge bg-danger">Anulado</span>',
                    'Completado': '<span class="badge bg-success">Completado</span>',
                    'Pendiente': '<span class="badge bg-warning text-dark">Pendiente</span>'
                };
                return mapBadge[texto] || '<span class="badge bg-secondary">Sin pagos</span>';
            }
        },
        { data: 'monto_total', className: 'text-secondary fw-medium', render: (d) => `$${formatearVisual(parseFloat(d) || 0)}` },
        { data: 'total_abonado_envio', className: 'text-secondary fw-medium', render: (d) => `$${formatearVisual(parseFloat(d) || 0)}` },
        {
            data: 'cantidad_pagos',
            className: 'text-center',
            render: function (data, type, dato) {
                const totalAbonado = parseFloat(dato.total_abonado_envio) || 0;
                const cant = parseInt(data, 10) || 0;
                if (cant === 0 && totalAbonado < 0) {
                    return '<span class="badge bg-danger-subtle text-danger border">Reembolsado</span>';
                }
                return formatearCantidadPagos(cant);
            }
        },
        {
            data: null,
            className: 'text-secondary',
            render: (data, type, dato) => `$${formatearVisual(Math.max(0, Math.round(((parseFloat(dato.monto_total) || 0) - (parseFloat(dato.total_abonado_envio) || 0)) * 100) / 100))}`
        },
        {
            data: null,
            className: 'text-center',
            render: function (data, type, dato) {
                const est = dato.estado_registro_pago;
                if (est === null || est === undefined || String(est) === '') return '<span class="text-muted small">-</span>';
                return String(est) === '1'
                    ? '<span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i>Activo</span>'
                    : '<span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2"><i class="bi bi-x-circle-fill me-1"></i>Inactivo</span>';
            }
        },
        {
            data: null,
            orderable: false,
            className: 'pe-4 text-center',
            render: function (data, type, dato) {
                const cantidadPagos = parseInt(dato.cantidad_pagos, 10) || 0;
                const tienePago = cantidadPagos > 0 || !!(dato.ultimo_cod_pago);
                const montoTotal = parseFloat(dato.monto_total) || 0;
                const totalAbonado = parseFloat(dato.total_abonado_envio) || 0;
                const ultimoAbonoUsd = parseFloat(dato.ultimo_monto_usd) || 0;
                const restante = Math.max(0, Math.round((montoTotal - totalAbonado) * 100) / 100);
                const montoBaseEditar = Math.max(0, Math.round((montoTotal - (totalAbonado - ultimoAbonoUsd)) * 100) / 100);
                const envioAnulado = (String(dato.estado_envio) === '0') || (String(dato.estatus_envio || '').toUpperCase() === 'ANULADO');
                const esCompletado = !envioAnulado && tienePago && (restante <= 0);

                let btnPrincipalHtml = '';
                const ultimoInactivo = String(dato.estado_registro_pago) === '0';

                if (envioAnulado) {
                    if (esAdmin && totalAbonado > 0 && !ultimoInactivo) {
                        btnPrincipalHtml = `<button type="button" class="btn btn-link text-danger p-0 m-0 align-baseline btn-reembolsar" title="Reembolsar saldo abonado" data-accion="Reembolsar" data-envio="${dato.cod_envio}" data-totalabonado="${totalAbonado}"><i class="bi bi-arrow-counterclockwise"></i></button>`;
                    }
                } else if (!esCompletado && restante > 0) {
                    btnPrincipalHtml = `<button type="button" class="btn btn-link text-success p-0 m-0 align-baseline btn-anadir-pago" title="Registrar pago o cuota" data-accion="Registrar" data-envio="${dato.cod_envio}" data-montorestante="${restante}" data-totalabonado="${totalAbonado}"><i class="bi bi-plus-circle"></i></button>`;
                }

                const btnLupitaHtml = `<button type="button" class="btn btn-link text-primary p-0 m-0 align-baseline btn-historial" title="Ver detalle e historial de pagos" data-bs-toggle="modal" data-bs-target="#modalHistorialPago" data-envio="${dato.cod_envio}"><i class="bi bi-search"></i></button>`;

                let crudAdminHtml = '';
                if (esAdmin && tienePago) {
                    if (!envioAnulado && dato.ultimo_cod_pago) {
                        crudAdminHtml += `<button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-editar" title="Editar pagos del envío" data-accion="Editar" data-id="${dato.ultimo_cod_pago}" data-envio="${dato.cod_envio}" data-montototal="${montoTotal}" data-detalle="${dato.cod_detallepago || ''}" data-fecha="${dato.fecha || ''}" data-metodo="${dato.cod_metodopago || ''}" data-banco="${dato.cod_banco || ''}" data-monto="${ultimoAbonoUsd}" data-monto-original="${parseFloat(dato.monto_ingresado_original) || 0}" data-referencia="${dato.referencia || ''}" data-montobaseeditar="${montoBaseEditar}" data-totalabonado="${totalAbonado}"><i class="bi bi-pencil"></i></button>`;
                    }
                    const puedeEliminarPago = envioAnulado && (totalAbonado <= 0) && dato.ultimo_cod_pago;
                    crudAdminHtml += `<button type="button" class="btn btn-link ${puedeEliminarPago ? 'text-danger' : 'text-secondary opacity-50'} p-0 m-0 align-baseline btn-eliminar" title="${puedeEliminarPago ? 'Anular registro de pago' : 'Requiere envío anulado y saldo reembolsado'}" data-id="${dato.ultimo_cod_pago || ''}" data-puede-eliminar="${puedeEliminarPago ? '1' : '0'}"><i class="bi bi-trash"></i></button>`;
                }

                return `<div class="pe-4 d-inline-flex align-items-center justify-content-center gap-2">${btnPrincipalHtml}${btnLupitaHtml}${crudAdminHtml}</div>`;
            }
        }
    ];

    const dataTable = datatableServer(tablaSelector, moduloActual, columnasPago);
    dataTable.order([0, 'desc']).draw();
    
    function prepararYMostrarModal(modo, botonTrig) {
        if (!modalPago.length) return;
        montoInput = inicializarAutoNumeric('#monto_ingresado');
        $formPago.validate().resetForm();
        $formPago.find('input, select').removeClass('is-valid is-invalid');
        $('.mensaje-error').hide().text('');
        hasChanged = false;
        establecerModoModal(modo, botonTrig);
        bootstrap.Modal.getOrCreateInstance(modalPago[0]).show();
    }

    $(tablaSelector + " tbody").on("click", ".btn-anadir-pago, .btn-reembolsar, .btn-editar", function (e) {
        e.preventDefault();
        if ($(this).prop("disabled")) return;
        if ($(this).hasClass("btn-anadir-pago")) prepararYMostrarModal("registrar", $(this));
        else if (esAdmin && $(this).hasClass("btn-reembolsar")) prepararYMostrarModal("reembolsar", $(this));
        else if (esAdmin && $(this).hasClass("btn-editar")) prepararYMostrarModal("actualizar", $(this));
    });

    $.validator.addMethod("montoValido", function () {
        const num = getMontoNum();
        const visual = $('#estatus_pago_visual').text();
        if (isNaN(num) || num <= 0 || num > 999999.99) return false;
        if (modoModalActual !== "reembolsar" && $('#estatus_pago').val() === "0" && (visual === "Excedido" || visual === "Inválido")) return false;
        if (modoModalActual === "reembolsar") {
            const usdCalc = parseFloat($('#monto_dolares_oculto').val()) || 0;
            if (usdCalc <= 0 || Math.round(usdCalc * 100) > Math.round(totalAbonadoModal * 100)) return false;
        }
        return true;
    }, "Monto inválido, excede el límite o supera lo permitido.");

    $.validator.addMethod("cuentaRequerida", (v) => esMetodoEfectivo() || (v !== null && String(v).trim() !== ''), "Seleccione una cuenta destino.");
    $.validator.addMethod("referenciaRequerida", (v) => esMetodoEfectivo() || (/^\d+$/.test((v || '').trim())), "La referencia solo debe contener números.");

    $formPago.validate({
        onfocusout: false,
        onkeyup: function (element) {
            $(element).valid();
            if ($btnSubmit.val() === 'actualizar') verificarCambiosPago();
            evaluarBotonModificar();
        },
        onclick: function (element) {
            if (element.tagName === 'SELECT') {
                $(element).valid();
                if ($btnSubmit.val() === 'actualizar') verificarCambiosPago();
                evaluarBotonModificar();
            }
        },
        rules: {
            monto_ingresado: { required: true, montoValido: true },
            fecha_pago: { required: true },
            metodos: { required: true },
            cuentas: { cuentaRequerida: true },
            referencia: { referenciaRequerida: true }
        },
        messages: {
            monto_ingresado: { required: "Debe ingresar el monto.", montoValido: "Monto inválido o supera el límite permitido." },
            fecha_pago: { required: "La fecha es obligatoria." },
            metodos: { required: "Seleccione un método de pago." },
            cuentas: { cuentaRequerida: "Seleccione una cuenta destino." },
            referencia: { referenciaRequerida: "Ingrese la referencia bancaria (solo números)." }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            const spanError = element.closest('.col-md-4, .col-md-6').find('.mensaje-error');
            spanError.length ? spanError.text(error.text()).show() : error.insertAfter(element);
        },
        highlight: (el) => $(el).addClass('is-invalid').removeClass('is-valid'),
        unhighlight: function (el) {
            $(el).addClass('is-valid').removeClass('is-invalid');
            const spanError = $(el).closest('.col-md-4, .col-md-6').find('.mensaje-error');
            if (spanError.length) spanError.hide().text('');
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            const solicitud = $btnSubmit.val();
            const efectivoActivo = esMetodoEfectivo();

            if (solicitud === "actualizar") {
                verificarCambiosPago();
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

            const fechaAEnviar = (solicitud === "actualizar" && pagoEditandoActual && pagoEditandoActual.fecha)
                ? String(pagoEditandoActual.fecha)
                : $("#fecha_pago").val();

            const datosObj = {
                cod_pago: $("#cod_pago").val() || '0',
                cod_envio: $("#cod_envio").val(),
                cod_detallepago: $("#cod_detallepago").val() || '0',
                hora_original: $("#hora_original").val() || '',
                fecha_pago: fechaAEnviar,
                monto: $("#monto_dolares_oculto").val(),
                monto_ingresado: getMontoNum().toFixed(2),
                referencia: efectivoActivo ? '' : (($("#referencia").val() || '').trim()),
                metodos: $("#metodos").val(),
                cuentas: efectivoActivo ? '' : ($("#cuentas").val() || '')
            };

            const objModal = bootstrap.Modal.getInstance(modalPago[0]) || new bootstrap.Modal(modalPago[0]);
            ajaxEnvioDatosGlobal(moduloActual, solicitud, null, dataTable, datosObj, objModal, $btnSubmit);
        }
    });

    $('#monto_ingresado').on('keyup input autoNumeric:rawValueModified', function () {
        calcularRestante();
        $(this).valid();
        if ($btnSubmit.val() === 'actualizar') verificarCambiosPago();
        evaluarBotonModificar();
    });

    $btnSubmit.on('click', function (e) {
        e.preventDefault();
        $formPago.trigger('submit');
    });

    function verificarCambiosPago() {
        const originalesAttr = $formPago.attr('data-originales');
        if (!originalesAttr) { hasChanged = false; return; }
        const org = JSON.parse(originalesAttr);
        const efectivoActivo = esMetodoEfectivo();
        hasChanged = (
            parseFloat(org.monto).toFixed(2) !== getMontoNum().toFixed(2) ||
            (org.referencia || '') !== (efectivoActivo ? '' : ($('#referencia').val() || '').trim()) ||
            String(org.metodo) !== String($('#metodos').val() || '') ||
            String(org.banco || '') !== String(efectivoActivo ? '' : ($('#cuentas').val() || ''))
        );
    }

    function evaluarBotonModificar() {
        const esValido = $formPago.validate().checkForm();
        $btnSubmit.prop('disabled', $btnSubmit.val() === 'actualizar' ? !(esValido && hasChanged) : !esValido);
    }

    function filtrarBancos() {
        const $selectMetodo = $('#metodos');
        if (!$selectMetodo.length || !$('#cuentas').length) return;
        toggleCamposPagoNoEfectivo($selectMetodo.prop('selectedIndex') <= 0 || !esMetodoEfectivo());
        evaluarBotonModificar();
    }

    function calcularRestante() {
        const montoIngresado = getMontoNum();
        const moneda = monedaSeleccionada();
        const calcUsd = calcularUsdDesdeMoneda(montoIngresado, moneda);
        const abonadoCents = Math.round(calcUsd.dolares * 100);
        const abonadoUSD = abonadoCents / 100;

        const $divEquiv = $('#div_equivalente_moneda_usd');
        if (moneda !== 'USD') {
            $divEquiv.show();
            $('#monto_equivalente_usd_badge').text(`$${formatearVisual(abonadoUSD)}`);
            $('#texto_tasa_referencia_modal').text(calcUsd.textoTasa);
        } else {
            $divEquiv.hide();
            $('#monto_equivalente_usd_badge').text('$0,00');
            $('#texto_tasa_referencia_modal').text('');
        }

        $('#simbolo_moneda_dinamico').html(simboloMoneda(moneda));
        $('#monto_dolares_oculto').val(abonadoUSD.toFixed(2));

        if (modoModalActual === "reembolsar") {
            const restanteReembolsoUSD = Math.max(0, (Math.round(totalAbonadoModal * 100) - abonadoCents) / 100);
            $('#monto_restante_dinamico').text(`$${formatearVisual(restanteReembolsoUSD)}`);
            return;
        }

        const deudaCents = Math.round(montoBaseCalculo * 100);
        const restanteCents = deudaCents - abonadoCents;
        $('#monto_restante_dinamico').text(`$${formatearVisual(Math.max(0, restanteCents / 100))}`);

        const setEstatus = (val, texto, clTarjeta) => {
            $('#estatus_pago').val(val);
            $('#estatus_pago_visual').text(texto);
            $('#tarjeta_estatus').attr('class', `alert text-center shadow-sm mb-0 py-1 px-2 ${clTarjeta}`);
        };

        if (montoIngresado === 0) setEstatus("0", "Pendiente", "alert-secondary text-dark");
        else if (abonadoCents === 0) setEstatus("0", "Inválido", "alert-danger text-white");
        else if (restanteCents < 0 || montoIngresado > 999999.99) setEstatus("0", "Excedido", "alert-danger text-white");
        else setEstatus("1", restanteCents === 0 ? "Completado" : "Pendiente", restanteCents === 0 ? "alert-success text-dark" : "alert-warning text-dark");
    }

    function autocompletarMonto() {
        const moneda = monedaSeleccionada();
        const { tasaUsd, tasaMoneda } = obtenerTasasEfectivasParaCalculo(moneda);
        const baseUSD = Math.round((modoModalActual === "reembolsar" ? totalAbonadoModal : montoBaseCalculo) * 100) / 100;

        let valorAutocompletado = 0;
        if (moneda === 'USD') valorAutocompletado = baseUSD;
        else if (moneda === 'VES' && tasaUsd > 0) valorAutocompletado = baseUSD * tasaUsd;
        else if (tasaUsd > 0 && tasaMoneda > 0) valorAutocompletado = (baseUSD * tasaUsd) / tasaMoneda;

        if (montoInput) {
            montoInput.set(valorAutocompletado);
            calcularRestante();
            $('#monto_ingresado').valid();
            if ($btnSubmit.val() === 'actualizar') verificarCambiosPago();
            evaluarBotonModificar();
        }
    }

    $('#btn_autocompletar').on('click', autocompletarMonto);

    $(document).on('change keyup input', '#metodos, #cuentas, #referencia', function () {
        if ($(this).attr('id') === 'metodos') {
            filtrarBancos();
            autocompletarMonto();
            $(this).valid();
            return;
        }
        calcularRestante();
        if ($btnSubmit.val() === 'actualizar') verificarCambiosPago();
        evaluarBotonModificar();
    });

    function cargarPagoEnFormularioEditar(pagoItem) {
        if (!pagoItem) return;
        pagoEditandoActual = pagoItem;

        const montoUsdPago = parseFloat(pagoItem.monto_abonado_usd) || 0;
        const montoOrigPago = parseFloat(pagoItem.monto_ingresado_original) || 0;
        const abonadoOtrosPagos = Math.max(0, Math.round((totalAbonadoModal - montoUsdPago) * 100) / 100);
        montoBaseCalculo = Math.max(0, Math.round((montoTotalEnvioModal - abonadoOtrosPagos) * 100) / 100);

        $('#cod_pago').val(pagoItem.cod_pago);
        $('#cod_detallepago').val(pagoItem.cod_detallepago || '');
        $('#hora_original').val(pagoItem.hora || '');
        bloquearFechaPago(pagoItem.fecha || '');

        const metodoGuardado = String(pagoItem.cod_metodopago || '');
        $('#metodos').val(metodoGuardado);
        if ($('#metodos').val() !== metodoGuardado) $('#metodos').prop('selectedIndex', 0);

        if (montoInput) montoInput.set(montoOrigPago);
        $('#referencia').val(pagoItem.referencia || '');

        filtrarBancos();
        if (!esMetodoEfectivo()) $('#cuentas').val(String(pagoItem.cod_banco || ''));

        hasChanged = false;
        $formPago.attr('data-originales', JSON.stringify({
            monto: getMontoNum(),
            referencia: esMetodoEfectivo() ? '' : ($('#referencia').val() || '').trim(),
            metodo: $('#metodos').val() || '',
            banco: esMetodoEfectivo() ? '' : ($('#cuentas').val() || '')
        }));

        $('.fila-pago-editar').removeClass('table-primary');
        $(`.fila-pago-editar[data-cod-pago="${pagoItem.cod_pago}"]`).addClass('table-primary');
        $(`input[name="radio_pago_editar"][value="${pagoItem.cod_pago}"]`).prop('checked', true);

        calcularRestante();
        $('#monto_ingresado').valid();
        verificarCambiosPago();
        evaluarBotonModificar();
    }

    function cargarListaPagosParaEditar(codEnvio, codPagoInicial) {
        $('#editar_cod_envio_label').text(codEnvio);
        $('#tbodyPagosEditar').html('<tr><td colspan="6" class="text-center text-muted py-2">Cargando pagos del envío...</td></tr>');
        pagosEnvioEditarCache = [];

        $.ajax({
            url: `index.php?url=${moduloActual}`,
            type: "POST",
            dataType: "json",
            data: { tipoSolicitud: "consultar_historial", datos: { cod_envio: codEnvio } }
        }).done(function (res) {
            if (res && res.envio) {
                montoTotalEnvioModal = parseFloat(res.envio.monto_total) || montoTotalEnvioModal;
                totalAbonadoModal = parseFloat(res.envio.total_abonado_envio) || totalAbonadoModal;
            }
            const pagosEditables = (res && Array.isArray(res.pagos) ? res.pagos : []).filter(
                (p) => String(p.estado_registro_pago) === '1' && (parseFloat(p.monto_abonado_usd) || 0) > 0
            );
            pagosEnvioEditarCache = pagosEditables;
            $('#editar_total_pagos_badge').text(`${pagosEditables.length} ${pagosEditables.length === 1 ? 'pago' : 'pagos'}`);

            if (!pagosEditables.length) {
                $('#tbodyPagosEditar').html('<tr><td colspan="6" class="text-center text-muted py-2">No hay pagos activos para editar en este envío.</td></tr>');
                return;
            }

            const html = pagosEditables.map((p, idx) => {
                const moneda = (p.moneda_metodo || 'USD').toUpperCase();
                return `<tr class="fila-pago-editar" style="cursor:pointer;" data-cod-pago="${p.cod_pago}">
                    <td class="ps-2 text-center"><input class="form-check-input radio-pago-editar" type="radio" name="radio_pago_editar" value="${p.cod_pago}"></td>
                    <td><span class="badge bg-light text-dark border">#${idx + 1}</span></td>
                    <td>${p.fecha || '-'}</td>
                    <td>${p.metodo_pago || '-'} <small class="text-muted">(${moneda})</small></td>
                    <td>${simboloMoneda(moneda)} ${formatearVisual(parseFloat(p.monto_ingresado_original) || 0)}</td>
                    <td class="pe-2"><span class="font-monospace">${p.referencia || '-'}</span></td>
                </tr>`;
            }).join('');

            $('#tbodyPagosEditar').html(html);
            const seleccionado = pagosEditables.find((p) => String(p.cod_pago) === String(codPagoInicial)) || pagosEditables[pagosEditables.length - 1];
            cargarPagoEnFormularioEditar(seleccionado);
        });
    }

    $(document).on('click', '.fila-pago-editar', function () {
        const encontrado = pagosEnvioEditarCache.find((p) => String(p.cod_pago) === String($(this).attr('data-cod-pago')));
        if (encontrado) cargarPagoEnFormularioEditar(encontrado);
    });

    function resetearCamposComunesModal(fechaHoy) {
        $('#cod_pago, #cod_detallepago, #hora_original, #referencia').val('');
        if (montoInput) montoInput.set('');
        $('#metodos').prop('selectedIndex', 0);
        $('#cuentas').find('option').prop('disabled', false);
        $('#cuentas').prop('selectedIndex', 0);
        bloquearFechaPago(fechaHoy);
        $formPago.removeAttr('data-originales');
    }

    function establecerModoModal(modo, botonTrig) {
        modoModalActual = modo;
        pagoEditandoActual = null;
        const hoy = new Date();
        const fechaHoy = `${hoy.getFullYear()}-${String(hoy.getMonth() + 1).padStart(2, '0')}-${String(hoy.getDate()).padStart(2, '0')}`;

        toggleCamposPagoNoEfectivo(true);
        $btnSubmit.prop('disabled', true);

        if (modo === "registrar" || modo === "reembolsar") {
            const esReemb = modo === "reembolsar";
            $('#selectorPagoEditarWrapper').hide();
            $('#modalLabel').html(esReemb ? '<i class="bi bi-arrow-counterclockwise"></i> Reembolso de Pago' : '<i class="bi bi-wallet2"></i> Registro de Pago');
            $('#div_codigo_envio').show();
            $('#div_total_abonado_modal').toggle(esReemb);
            $('#div_tarjeta_estatus').toggle(!esReemb);
            $('#label_monto_ingresado').text(esReemb ? 'Monto a Reembolsar:' : 'Monto Abonado:');
            $('#label_restante_modal').text(esReemb ? 'Saldo a Reembolsar en Dólares:' : 'Restante en Dólares:');
            $('#label_cuenta_destino').text(esReemb ? 'Cuenta de Origen:' : 'Cuenta Destino:');
            $('#codigo_envio_mostrar').text(botonTrig.attr('data-envio'));
            $btnSubmit.val(modo).html(esReemb ? '<i class="bi bi-arrow-counterclockwise"></i> Reembolsar' : '<i class="bi bi-save"></i> Registrar');

            totalAbonadoModal = parsearMonto(botonTrig.attr('data-totalabonado'));
            montoBaseCalculo = esReemb ? totalAbonadoModal : parsearMonto(botonTrig.attr('data-montorestante'));
            if (esReemb) $('#total_abonado_mostrar').text(`$${formatearVisual(totalAbonadoModal)}`);

            $('#cod_envio').val(botonTrig.attr('data-envio'));
            resetearCamposComunesModal(fechaHoy);
            filtrarBancos();
            calcularRestante();
        } else if (modo === "actualizar") {
            $('#selectorPagoEditarWrapper').show();
            $('#modalLabel').html('<i class="bi bi-pencil-square"></i> Editar Pago');
            $('#div_codigo_envio, #div_total_abonado_modal').hide();
            $('#div_tarjeta_estatus').show();
            $('#label_monto_ingresado').text('Monto Abonado:');
            $('#label_cuenta_destino').text('Cuenta Destino:');
            $('#label_restante_modal').text('Restante en Dólares:');
            $btnSubmit.val("actualizar").html('<i class="bi bi-save"></i> Guardar');

            const codEnvio = botonTrig.attr('data-envio');
            const codPagoDefault = botonTrig.attr('data-id');
            montoTotalEnvioModal = parsearMonto(botonTrig.attr('data-montototal'));
            montoBaseCalculo = parsearMonto(botonTrig.attr('data-montobaseeditar'));
            totalAbonadoModal = parsearMonto(botonTrig.attr('data-totalabonado'));

            $('#cod_envio').val(codEnvio);
            cargarPagoEnFormularioEditar({
                cod_pago: codPagoDefault,
                cod_detallepago: botonTrig.attr('data-detalle') || '',
                fecha: botonTrig.attr('data-fecha') || '',
                hora: '',
                cod_metodopago: botonTrig.attr('data-metodo') || '',
                cod_banco: botonTrig.attr('data-banco') || '',
                monto_abonado_usd: parseFloat(botonTrig.attr('data-monto')) || 0,
                monto_ingresado_original: parseFloat(botonTrig.attr('data-monto-original')) || 0,
                referencia: botonTrig.attr('data-referencia') || ''
            });
            cargarListaPagosParaEditar(codEnvio, codPagoDefault);
        }
    }

    if (modalPago.length) {
        modalPago.on('hidden.bs.modal', function () {
            modoModalActual = null;
            pagoEditandoActual = null;
            $('#selectorPagoEditarWrapper').hide();
            if (document.activeElement) document.activeElement.blur();
            if (montoInput) montoInput.set('');
        });
    }

    $(tablaSelector + " tbody").on("click", ".btn-historial", function () {
        const codEnvio = $(this).attr("data-envio");
        $('#hist_cod_envio').text(codEnvio);
        $('#hist_remitente_nombre, #hist_remitente_doc, #hist_remitente_tel, #hist_remitente_email').text('-');
        $('#tbodyHistorialPagos').html('<tr><td colspan="10" class="text-center text-muted py-4">Cargando historial...</td></tr>');

        $.ajax({
            url: `index.php?url=${moduloActual}`,
            type: "POST",
            dataType: "json",
            data: { tipoSolicitud: "consultar_historial", datos: { cod_envio: codEnvio } }
        }).done(function (res) {
            const env = res && res.envio ? res.envio : null;
            const rem = res && res.remitente ? res.remitente : null;
            const pagos = res && Array.isArray(res.pagos) ? res.pagos : [];

            if (env) {
                $('#hist_fecha_envio').text(env.fecha_envio || '-');
                const esAnulado = (String(env.estado_envio) === '0') || (String(env.estatus_envio || '').toUpperCase() === 'ANULADO');
                $('#hist_estatus_envio').text(esAnulado ? 'ANULADO' : (env.estatus_envio || 'ACTIVO'));
                $('#hist_monto_total').text(`$${formatearVisual(parseFloat(env.monto_total) || 0)}`);
                $('#hist_total_abonado').text(`$${formatearVisual(parseFloat(env.total_abonado_envio) || 0)}`);
            }

            if (rem) {
                $('#hist_remitente_nombre').text(`${rem.razon_social || ''} ${rem.apellido || ''}`.trim() || '-');
                $('#hist_remitente_doc').text(rem.doc_identidad ? `${rem.tipo_documento ? rem.tipo_documento + '-' : ''}${rem.doc_identidad}` : '-');
                $('#hist_remitente_tel').text(rem.telefono || '-');
                $('#hist_remitente_email').text(rem.email && String(rem.email).trim() !== '' ? rem.email : 'No registrado');
            }

            if (!pagos.length) {
                $('#tbodyHistorialPagos').html('<tr><td colspan="10" class="text-center text-muted py-4">No hay pagos registrados para este envío.</td></tr>');
                return;
            }

            let contadorActivos = 0;
            const htmlFilas = pagos.map((p) => {
                const montoUsd = parseFloat(p.monto_abonado_usd) || 0;
                const esActivo = String(p.estado_registro_pago) === '1';

                let celdaCantidad = '<span class="text-muted small">0 pagos</span>';
                if (!esActivo) celdaCantidad = '<span class="badge bg-danger-subtle text-dark border">Anulado</span>';
                else if (montoUsd < 0) celdaCantidad = '<span class="badge bg-danger-subtle text-dark border">Reembolso</span>';
                else {
                    contadorActivos++;
                    celdaCantidad = `<span class="badge bg-light text-dark border">${contadorActivos} ${contadorActivos === 1 ? 'pago' : 'pagos'}</span>`;
                }

                const moneda = (p.moneda_metodo || 'USD').toUpperCase();
                let estadoBadge = '<span class="badge bg-danger-subtle text-dark border">Anulado</span>';
                if (esActivo) {
                    if (montoUsd < 0) {
                        estadoBadge = '<span class="badge bg-danger-subtle text-dark border">Reembolsado</span>';
                    } else if (String(p.estado_pago) === '1') {
                        estadoBadge = '<span class="badge bg-success-subtle text-dark border">Completado</span>';
                    } else {
                        estadoBadge = '<span class="badge bg-warning-subtle text-dark border">Pendiente</span>';
                    }
                }

                return `<tr>
                    <td class="ps-3">${celdaCantidad}</td>
                    <td>${formatearFechaHoraHistorial(p.fecha, p.hora)}</td>
                    <td>${p.metodo_pago || '-'} <small class="text-muted">(${moneda})</small></td>
                    <td>${p.banco_nombre || '-'}</td>
                    <td><span class="font-monospace">${p.referencia || '-'}</span></td>
                    <td>${simboloMoneda(moneda)} ${formatearVisual(parseFloat(p.monto_ingresado_original) || 0)}</td>
                    <td>${formatearTasaConFechaHora(p)}</td>
                    <td class="fw-semibold text-dark">$${formatearVisual(montoUsd)}</td>
                    <td class="fw-semibold text-primary">$${formatearVisual(parseFloat(p.saldo_restante_tras_pago) || 0)}</td>
                    <td class="pe-3 text-center">${estadoBadge}</td>
                </tr>`;
            }).join('');

            $('#tbodyHistorialPagos').html(htmlFilas);
        });
    });

    $(tablaSelector + " tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        if (!esAdmin) return;

        if ($(this).attr("data-puede-eliminar") !== "1") {
            Swal.fire({
                title: "Acción no permitida",
                text: "Solo puedes anular este registro cuando el envío esté anulado y ya se haya reembolsado el saldo abonado.",
                icon: "warning",
                didOpen: () => { if (document.activeElement) document.activeElement.blur(); }
            });
            return;
        }

        const idPago = $(this).attr("data-id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Está seguro que desea anular este registro de pago?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
            didOpen: () => { if (document.activeElement) document.activeElement.blur(); }
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxEnvioDatosGlobal(moduloActual, 'eliminar', null, dataTable, { cod_pago: idPago }, null, null);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "Anulación cancelada",
                    icon: "error",
                    didOpen: () => { if (document.activeElement) document.activeElement.blur(); }
                });
            }
        });
    });
});