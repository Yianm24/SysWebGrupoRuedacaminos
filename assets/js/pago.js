document.addEventListener("DOMContentLoaded", function () {
    
    let montoBaseCalculo = 0;
    let tasasDelDia = { "VES": 1, "USD": 1, "USDT": 1, "EUR": 1 };
    const inputTasasJson = document.getElementById('tasas_backend_json');

    if (inputTasasJson && inputTasasJson.value) {
        try {
            let tasasBackend = JSON.parse(inputTasasJson.value);
            tasasDelDia['VES'] = 1; 
            tasasDelDia['USD'] = tasasBackend['USD'] || 1;
            tasasDelDia['EUR'] = tasasBackend['EUR'] || 1;
            tasasDelDia['USDT'] = tasasBackend['USDT'] || 1;
        } catch (error) { console.error("Error leyendo las tasas", error); }
    }

    //funcion para asignar ' . ' si supera los 3 digitos y ' , ' al final con 2 digitos para evitar errores de ingreso de los montos
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
        if (isNaN(numero) || numero === 0) return "";
        return Number(numero).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    //funcion que forza que los inputs y selects sean validados antes de registrar o editar.
    function forzarSeguridad() {
        setTimeout(() => {
            const btnSubmit = document.getElementById('btnSubmitModal');
            const selectMetodo = document.getElementById('metodos');
            const selectCuenta = document.getElementById('cuentas');
            const estatusPago = document.getElementById('estatus_pago').value;
            const inputMonto = document.getElementById('monto_ingresado');
            const inputRef = document.getElementById('referencia');
            const inputFecha = document.getElementById('fecha_pago');
            const formPago = document.getElementById('formPago');
            const msjErrorSpan = $(inputMonto).siblings('.mensaje-error');

            if (!btnSubmit) return;

            let hayError = false;

            if (selectMetodo && selectMetodo.value === "") hayError = true;
            if (selectCuenta && selectCuenta.value === "") hayError = true;
            
            let montoPuro = parsearMonto(inputMonto.value);

            // 
            if (montoPuro > 999999.99) {
                hayError = true;
                $(inputMonto).removeClass('is-valid').addClass('is-invalid');
                msjErrorSpan.text("El monto excede el límite permitido 999.999,99").show();
            } else if (estatusPago === "0") {
                hayError = true;
                const visual = document.getElementById('estatus_pago_visual').textContent;
                if (visual === "Excedido") {
                    $(inputMonto).removeClass('is-valid').addClass('is-invalid');
                    msjErrorSpan.text("El monto supera la deuda.").show();
                } else if (visual === "Inválido") {
                    $(inputMonto).removeClass('is-valid').addClass('is-invalid');
                    msjErrorSpan.text("El monto es demasiado bajo.").show();
                }
            }

            let esEfectivo = selectMetodo && selectMetodo.selectedIndex > 0 && 
                selectMetodo.options[selectMetodo.selectedIndex].text.toLowerCase().includes('efectivo');
            
            if (esEfectivo && inputRef) {
                $(inputRef).removeClass('is-invalid').addClass('is-valid');
                $(inputRef).siblings('.mensaje-error').hide().text('');
            }

            const inputsRequeridos = Array.from(document.querySelectorAll('.input-evaluar:not(.opcional)'));
            const expRegFalla = inputsRequeridos.some(input => input.classList.contains('is-invalid') || input.value.trim() === '');

            if (expRegFalla || hayError) {
                btnSubmit.disabled = true;
                return;
            }

            if (btnSubmit.value === "actualizar" && formPago.hasAttribute('data-originales')) {
                const org = JSON.parse(formPago.getAttribute('data-originales'));
                const actualMonto = parsearMonto(inputMonto.value);
                const actualRef = inputRef ? inputRef.value.trim() : '';
                const actualMetodo = selectMetodo ? selectMetodo.value : '';
                const actualBanco = selectCuenta ? selectCuenta.value : '';
                const actualFecha = inputFecha ? inputFecha.value : '';

                if (org.monto === actualMonto && org.referencia === actualRef &&
                    org.metodo === actualMetodo && org.banco === actualBanco &&
                    org.fecha === actualFecha) {
                    btnSubmit.disabled = true;
                    return;
                }
            }

            btnSubmit.disabled = false;
        }, 50);
    }

    function filtrarBancos() {
        const selectMetodo = document.getElementById('metodos');
        const selectBanco = document.getElementById('cuentas');
        const inputRef = document.getElementById('referencia');
        
        if (!selectMetodo || !selectBanco || selectMetodo.selectedIndex <= 0) {
            forzarSeguridad();
            return;
        }

        //si el metodo de pago es efectivo se autoseleccionan los select y se llena el campo de refencia para evitar mensaje de error al no ser numerico.
        let esEfectivo = selectMetodo.options[selectMetodo.selectedIndex].text.toLowerCase().includes('efectivo');
        if (inputRef) {
            if (esEfectivo) {
                inputRef.value = "EFECTIVO";
                inputRef.readOnly = true;
                inputRef.classList.add('bg-light', 'is-valid');
                inputRef.classList.remove('solo-numeros', 'is-invalid'); 
                $(inputRef).siblings('.mensaje-error').hide().text('');
            } else {
                if (inputRef.value === "EFECTIVO") inputRef.value = "";
                inputRef.readOnly = false;
                inputRef.classList.remove('bg-light', 'is-valid');
                inputRef.classList.add('solo-numeros');
            }
            $(inputRef).trigger('input'); 
        }

        Array.from(selectBanco.options).forEach(opt => {
            if (opt.value === "") return;
            let esCaja = opt.text.toLowerCase().includes('caja');
            
            if (esEfectivo) {
                opt.disabled = !esCaja;
                if (esCaja) selectBanco.value = opt.value; 
            } else {
                opt.disabled = esCaja;
            }
        });

        if (selectBanco.options[selectBanco.selectedIndex]?.disabled) {
            selectBanco.value = "";
        }
        forzarSeguridad();
    }

    //funcion que calcula el restante y asigna las tarjetas de aviso: PENDIENTE, COMPLETADO o EXCEDIDO.
    function calcularRestante() {
        const inputMonto = document.getElementById('monto_ingresado');
        const selectMetodo = document.getElementById('metodos');
        
        let moneda = 'USD';
        if (selectMetodo && selectMetodo.selectedIndex >= 0) {
            let opcion = selectMetodo.options[selectMetodo.selectedIndex];
            if (opcion && !opcion.disabled) moneda = opcion.getAttribute('data-moneda') || 'USD';
        }

        let montoIngresado = parsearMonto(inputMonto.value);
        let dolaresCalculados = 0;
        let tasaUSD = tasasDelDia['USD'] || 1;
        if (moneda === 'USD') {
            dolaresCalculados = montoIngresado;
        } else if (moneda === 'VES') {
            dolaresCalculados = montoIngresado / tasaUSD;
        } else {
            let tasaMonedaExtranjera = tasasDelDia[moneda] || 1;
            dolaresCalculados = (montoIngresado * tasaMonedaExtranjera) / tasaUSD; 
        }

        let abonadoCents = Math.round(dolaresCalculados * 100);
        let deudaCents = Math.round(montoBaseCalculo * 100);
        let restanteCents = deudaCents - abonadoCents;
        let abonadoUSD = abonadoCents / 100;
        let mostrarRestanteUSD = Math.max(0, restanteCents / 100);
        const spans = {
            simb: document.getElementById('simbolo_moneda_dinamico'),
            oculto: document.getElementById('monto_dolares_oculto'),
            restUSD: document.getElementById('monto_restante_dinamico'),
            restBS: document.getElementById('monto_restante_bs_dinamico')
        };

        if (spans.simb) spans.simb.innerHTML = (moneda === 'VES') ? 'Bs' : (moneda === 'EUR' ? '€' : (moneda === 'USDT' ? 'USDT' : '$'));
        if (spans.oculto) spans.oculto.value = abonadoUSD.toFixed(2);
        if (spans.restUSD) {
            spans.restUSD.textContent = mostrarRestanteUSD.toFixed(2);
            spans.restUSD.className = 'input-group-text bg-white fw-bold';
        }
        if (spans.restBS) {
            spans.restBS.textContent = (mostrarRestanteUSD * tasaUSD).toFixed(2);
            spans.restBS.className = 'input-group-text bg-white fw-bold';
        }

        const el = {
            estatus: document.getElementById('estatus_pago'),
            visual: document.getElementById('estatus_pago_visual'),
            tarjeta: document.getElementById('tarjeta_estatus')
        };

        const setEstatus = (val, texto, clTarjeta) => {
            if (el.estatus) el.estatus.value = val;
            if (el.visual) el.visual.textContent = texto;
            if (el.tarjeta) el.tarjeta.className = `alert text-center shadow-sm mb-0 p-2 ${clTarjeta}`;
        };

        if (montoIngresado === 0) {
            setEstatus("0", "Pendiente", "alert-secondary text-dark");
        } else if (abonadoCents === 0) {
            setEstatus("0", "Inválido", "alert-danger text-white");
        } else if (restanteCents < 0 || montoIngresado > 999999.99) {
            setEstatus("0", "Excedido", "alert-danger text-white"); 
        } else {
            if (restanteCents === 0) {
                setEstatus("1", "Completado", "alert-success text-dark");
            } else {
                setEstatus("1", "Pendiente", "alert-warning text-dark"); 
            }
        }
        
        forzarSeguridad();
    }

    //funcion para autocompletar monto restante del envio.
    function autocompletarMonto() {
        const inputMonto = document.getElementById('monto_ingresado');
        const selectMetodo = document.getElementById('metodos');

        let moneda = 'USD';
        if (selectMetodo && selectMetodo.selectedIndex >= 0) {
            let opcion = selectMetodo.options[selectMetodo.selectedIndex];
            if (opcion && !opcion.disabled) moneda = opcion.getAttribute('data-moneda') || 'USD';
        }

        let tasaUSD = tasasDelDia['USD'] || 1;
        let baseUSD = Math.round(montoBaseCalculo * 100) / 100;
        let valorAutocompletado = 0;

        if (moneda === 'USD') {
            valorAutocompletado = baseUSD;
        } else if (moneda === 'VES') {
            valorAutocompletado = baseUSD * tasaUSD;
        } else {
            let tasaMonedaExtranjera = tasasDelDia[moneda] || 1;
            valorAutocompletado = (baseUSD * tasaUSD) / tasaMonedaExtranjera;
        }

        if (inputMonto) {
            inputMonto.value = formatearVisual(valorAutocompletado);
            $(inputMonto).trigger('input').trigger('change');
            calcularRestante();
            forzarSeguridad();
        }
    }

    document.getElementById('btn_autocompletar')?.addEventListener('click', autocompletarMonto);

    let isFormatting = false;
    document.body.addEventListener('input', function (e) {
        if (e.target && e.target.id === 'monto_ingresado') {
            if (isFormatting) return;
            isFormatting = true;
            
            let input = e.target;
            let valorPuro = input.value.replace(/\D/g, ''); 
            
            if (valorPuro !== '') {
                let num = parseInt(valorPuro, 10) / 100;
                input.value = formatearVisual(num);
            } else {
                input.value = "";
            }
            
            calcularRestante();
            isFormatting = false;
        }
        forzarSeguridad();
    });

    document.body.addEventListener('change', e => {
        if (['metodos', 'cuentas', 'fecha_pago', 'referencia', 'monto_ingresado'].includes(e.target?.id)) {
            if (e.target.id === 'metodos') filtrarBancos();
            calcularRestante(); 
            forzarSeguridad();
        }
    });

    const modalPago = document.getElementById('modalPago');
    if (modalPago) {
        modalPago.addEventListener('show.bs.modal', function (event) {
            const botonTrig = event.relatedTarget;
            const tituloModal = modalPago.querySelector('#modalLabel');
            const btnSubmit = modalPago.querySelector('#btnSubmitModal');
            const formPago = document.getElementById('formPago');

            if ((botonTrig.title === "Registrar" || botonTrig.getAttribute('title') === 'Registrar') && parseFloat(botonTrig.getAttribute('data-montorestante')) <= 0) {
                event.preventDefault();
                Swal.fire({ title: "Envío Solvente", text: "Este envío ya está pagado en su totalidad.", icon: "info" });
                return;
            }

            const inputs = {
                cod_pago: modalPago.querySelector('#cod_pago'),
                cod_envio: modalPago.querySelector('#cod_envio'),
                cod_detalle: modalPago.querySelector('#cod_detallepago'),
                monto: modalPago.querySelector('#monto_ingresado'),
                fecha: modalPago.querySelector('#fecha_pago'),
                metodo: modalPago.querySelector('#metodos'),
                banco: modalPago.querySelector('#cuentas'),
                referencia: modalPago.querySelector('#referencia')
            };

            inputs.referencia.classList.add('solo-numeros');
            inputs.referencia.readOnly = false;
            
            modalPago.querySelectorAll('.input-evaluar').forEach(inp => {
                $(inp).removeClass('is-valid is-invalid').siblings('.mensaje-error').hide().text('');
            });
            
            btnSubmit.disabled = true;

            if (botonTrig.title === "Registrar" || botonTrig.getAttribute('title') === 'Registrar') {
                tituloModal.innerHTML = '<i class="bi bi-wallet2"></i> Registro de Pago';
                modalPago.querySelector('#div_codigo_envio').style.display = 'block';
                modalPago.querySelector('#codigo_envio_mostrar').textContent = botonTrig.getAttribute('data-envio');
                btnSubmit.value = "registrar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Registrar';

                montoBaseCalculo = parsearMonto(botonTrig.getAttribute('data-montorestante'));

                inputs.cod_pago.value = "";
                inputs.cod_envio.value = botonTrig.getAttribute('data-envio');
                inputs.cod_detalle.value = "";
                inputs.monto.value = "";
                inputs.referencia.value = "";
                inputs.metodo.selectedIndex = 0;
                Array.from(inputs.banco.options).forEach(opt => opt.disabled = false);
                inputs.banco.selectedIndex = 0;
                
                const hoy = new Date();
                const dia = String(hoy.getDate()).padStart(2, '0');
                const mes = String(hoy.getMonth() + 1).padStart(2, '0');
                inputs.fecha.value = `${hoy.getFullYear()}-${mes}-${dia}`;

                formPago.removeAttribute('data-originales');
                filtrarBancos(); calcularRestante();
                
            } else if (botonTrig.title === "Editar" || botonTrig.getAttribute('title') === 'Editar') {
                tituloModal.innerHTML = '<i class="bi bi-pencil-square"></i> Editar Pago';
                modalPago.querySelector('#div_codigo_envio').style.display = 'none';
                btnSubmit.value = "actualizar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Actualizar';
                montoBaseCalculo = parsearMonto(botonTrig.getAttribute('data-montobaseeditar'));
                inputs.cod_pago.value = botonTrig.getAttribute('data-id');
                inputs.cod_envio.value = botonTrig.getAttribute('data-envio');
                inputs.cod_detalle.value = botonTrig.getAttribute('data-detalle');
                inputs.fecha.value = botonTrig.getAttribute('data-fecha');

                let metodoGuardado = String(botonTrig.getAttribute('data-metodo') || '');
                inputs.metodo.value = metodoGuardado;
                if (inputs.metodo.value !== metodoGuardado) inputs.metodo.selectedIndex = 0;

                let montoOriginal_BD = parseFloat(botonTrig.getAttribute('data-monto-original')) || 0;
                let montoUSD_BD = parseFloat(botonTrig.getAttribute('data-monto')) || 0;

                if(montoOriginal_BD > 0 && montoUSD_BD > 0 && montoOriginal_BD !== montoUSD_BD) {
                    formPago.setAttribute('data-tasa-historica', montoOriginal_BD / montoUSD_BD);
                } else {
                    formPago.setAttribute('data-tasa-historica', 1);
                }

                inputs.monto.value = formatearVisual(montoOriginal_BD);
                inputs.referencia.value = botonTrig.getAttribute('data-referencia');
                filtrarBancos();
                inputs.banco.value = String(botonTrig.getAttribute('data-banco') || '');

                const originales = {
                    monto: parsearMonto(inputs.monto.value),
                    referencia: inputs.referencia.value.trim(),
                    metodo: inputs.metodo.value,
                    banco: inputs.banco.value,
                    fecha: inputs.fecha.value
                };
                formPago.setAttribute('data-originales', JSON.stringify(originales));

                setTimeout(() => {
                    $(inputs.monto).trigger('input');
                    if (inputs.referencia.value !== 'EFECTIVO') {
                        $(inputs.referencia).trigger('input');
                    }
                    calcularRestante(); 
                    forzarSeguridad();
                }, 100);
            }
        });
    }

    const formPago = document.getElementById('formPago');
    if (formPago) {
        formPago.addEventListener('submit', function (event) {
            const btnSubmit = document.getElementById('btnSubmitModal');
            const inputMonto = document.getElementById('monto_ingresado');
            const estadoActual = document.getElementById('estatus_pago').value;

            if (estadoActual === "0") {
                event.preventDefault();
                Swal.fire({ title: "Acción Denegada", text: "Verifique los errores en el formulario antes de guardar.", icon: "error" });
                return;
            }

            let montoPuro = parsearMonto(inputMonto.value);

            if (btnSubmit.value === "actualizar") {
                const org = JSON.parse(this.getAttribute('data-originales'));
                if (org.monto === montoPuro && org.referencia === document.getElementById('referencia').value.trim() &&
                    org.metodo === document.getElementById('metodos').value && org.banco === document.getElementById('cuentas').value &&
                    org.fecha === document.getElementById('fecha_pago').value) {
                    event.preventDefault();
                    Swal.fire({ title: "Sin modificaciones", text: "No se registraron cambios.", icon: "info" });
                    return;
                }
            }
            inputMonto.value = montoPuro.toFixed(2);
        });
    }

    //Modal eliminar
    document.body.addEventListener('click', function(event) {
        let botonEliminar = event.target.closest('.btn-eliminar');
        if (botonEliminar) {
            event.preventDefault(); 
            let idPago = botonEliminar.getAttribute('data-id');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "¿Está seguro que desea eliminar este pago?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '?url=pago';
                    form.innerHTML = `<input type="hidden" name="tipoSolicitud" value="eliminar"><input type="hidden" name="cod_pago" value="${idPago}">`;
                    document.body.appendChild(form);
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelado",
                        text: "Eliminación del pago cancelada",
                        icon: "error"
                    });
                }
            });
        }
    });

    //mensajes de alerta
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const mensaje = urlParams.get('msg');

    if (status) {
        setTimeout(() => {
            let title, text, icon;
            switch (status) {
                case 'success':
                    title = "Registro exitoso!"; 
                    text = "El pago ha sido registrado correctamente."; 
                    icon = "success"; break;
                case 'updated':
                    title = "Actualización exitosa!"; 
                    text = "El pago ha sido modificado correctamente."; 
                    icon = "success"; break;
                case 'deleted':
                    title = "¡Eliminado!"; 
                    text = "El pago ha sido eliminado correctamente."; 
                    icon = "success"; break;
                case 'completed':
                    title = "¡Envío solvente!"; 
                    text = "El pago del envío ya fue completado previamente al 100%."; 
                    icon = "warning"; break;
                case 'exists_ref':
                    title = "¡Referencia existente!"; 
                    text = "Ya existe un pago registrado con la referencia bancaria ingresada."; 
                    icon = "warning"; break;
                case 'pending_error':
                    title = "Acción bloqueada"; 
                    text = "No se puede eliminar un pago que se encuentra en curso o pendiente."; 
                    icon = "error"; break;
                case 'empty': 
                    title = "Campos vacíos!"; 
                    text = "Uno o más campos están vacíos."; 
                    icon = "warning"; break;
                case 'error': 
                    title = "Error!"; 
                    text = `Se produjo un error en el proceso: ${mensaje || 'desconocido'}.`; 
                    icon = "error"; break;
                case 'exception': 
                    title = "Exception Retornada!"; 
                    text = `El servidor devolvió el siguiente mensaje: ${mensaje || 'desconocido'}`; 
                    icon = "error"; break;
            }
            if (title && text && icon) Swal.fire({ title: title, text: text, icon: icon });
        }, 100);
    }
});