document.addEventListener("DOMContentLoaded", function () {
    
    let montoTotalEnvioActual = 0; 
    let montoTotalEnvioEditar = 0;
    let inputTasasJson = document.getElementById('tasas_backend_json');
    let tasasDelDia = { "VES": 1, "USD": 1 };
    
    if (inputTasasJson && inputTasasJson.value) {
        try {
            tasasDelDia = JSON.parse(inputTasasJson.value);
        } catch (error) {
            console.error("Error leyendo las tasas:", error);
        }
    }
    
    let tasaDolar = tasasDelDia['USD'] || 1;

    function filtrarBancos(modo) {
        const isRegistro = modo === 'registrar';
        const selectMetodo = document.getElementById(isRegistro ? 'metodos' : 'metodo_editar');
        const selectBanco = document.getElementById(isRegistro ? 'cuentas_registrar' : 'cuentas_editar');
        const inputRef = document.getElementById(isRegistro ? 'referencia' : 'referencia_editar');

        if (!selectMetodo || !selectBanco || selectMetodo.selectedIndex <= 0) return;

        let opcionMetodo = selectMetodo.options[selectMetodo.selectedIndex];
        let nombreMetodo = opcionMetodo.text.toLowerCase();

        // Control de Referencia para Efectivo
        if (inputRef) {
            if (nombreMetodo.includes('efectivo')) {
                inputRef.value = "EFECTIVO";
                inputRef.setAttribute('readonly', true);
                inputRef.classList.add('bg-light');
            } else {
                inputRef.removeAttribute('readonly');
                inputRef.classList.remove('bg-light');
                if (inputRef.value === "EFECTIVO") {
                    inputRef.value = "";
                }
            }
        }

        // Control de Bancos
        for (let i = 0; i < selectBanco.options.length; i++) {
            let optBanco = selectBanco.options[i];
            if (optBanco.value === "") continue; 

            let nombreBanco = optBanco.text.toLowerCase();

            if (nombreMetodo.includes('efectivo')) {
                if (nombreBanco.includes('caja')) {
                    optBanco.disabled = false;
                    selectBanco.value = optBanco.value; 
                } else {
                    optBanco.disabled = true; 
                }
            } else {
                if (nombreBanco.includes('caja')) {
                    optBanco.disabled = true; 
                } else {
                    optBanco.disabled = false; 
                }
                
                if (selectBanco.options[selectBanco.selectedIndex] && selectBanco.options[selectBanco.selectedIndex].disabled) {
                    selectBanco.value = "";
                }
            }
        }
    }

    // Calculo de monto restante y status
    function calcularRestante(modo) {
        const isRegistro = modo === 'registrar';
        const inputMonto = document.getElementById(isRegistro ? 'monto_abonado_input' : 'monto_editar');
        const select = document.getElementById(isRegistro ? 'metodos' : 'metodo_editar');
        const spanSimb = document.getElementById(isRegistro ? 'simbolo_moneda_dinamico' : 'simbolo_moneda_editar_dinamico');
        const inputOculto = document.getElementById(isRegistro ? 'monto_dolares_oculto' : 'monto_dolares_oculto_editar');
        const spanRest = document.getElementById(isRegistro ? 'monto_restante_dinamico' : 'monto_restante_editar_dinamico');
        const spanRestBs = document.getElementById(isRegistro ? 'monto_restante_bs_dinamico' : 'monto_restante_bs_editar_dinamico');
        const estatusSelect = document.getElementById(isRegistro ? 'estatus_pago' : 'estatus_pago_editar');
        
        const montoBaseCalculo = isRegistro ? montoTotalEnvioActual : montoTotalEnvioEditar;
        
        let abonadoIngresado = inputMonto ? (parseFloat(inputMonto.value) || 0) : 0;
        let monedaSeleccionada = 'USD';
        
        if (select && select.selectedIndex >= 0) {
            let opcion = select.options[select.selectedIndex];
            if (opcion) monedaSeleccionada = opcion.getAttribute('data-moneda') || 'USD';
        }

        let tasaMonedaOrigen = tasasDelDia[monedaSeleccionada] || 1;
        let abonadoEnBs = abonadoIngresado * tasaMonedaOrigen;
        let abonadoEnDolares = abonadoEnBs / tasaDolar;

        if (spanSimb) {
            if (monedaSeleccionada === 'VES') spanSimb.innerHTML = 'Bs';
            else if (monedaSeleccionada === 'EUR') spanSimb.innerHTML = '€';
            else spanSimb.innerHTML = '$';
        }

        if (inputOculto) inputOculto.value = abonadoEnDolares.toFixed(2);
        
        let restanteMatematicoUSD = montoBaseCalculo - abonadoEnDolares;
        let restanteParaMostrar = Math.max(0, restanteMatematicoUSD);
        
        if (spanRest) spanRest.textContent = restanteParaMostrar.toFixed(2);
        if (spanRestBs) spanRestBs.textContent = (restanteParaMostrar * tasaDolar).toFixed(2);

        let inputGroup = inputMonto ? inputMonto.closest('.col-md-6') : null;
        let divAlerta = document.getElementById(isRegistro ? 'alerta_visual_reg' : 'alerta_visual_edit');
        
        if (inputGroup && !divAlerta) {
            divAlerta = document.createElement('div');
            divAlerta.id = isRegistro ? 'alerta_visual_reg' : 'alerta_visual_edit';
            divAlerta.className = 'mt-2 small';
            inputGroup.appendChild(divAlerta);
        }

        if (spanRest) spanRest.classList.remove('text-danger', 'text-success');
        if (spanRestBs) spanRestBs.classList.remove('text-danger', 'text-success');

        if (estatusSelect && divAlerta) {
            let optCompletado = estatusSelect.querySelector('option[value="1"]');
            
            if (restanteMatematicoUSD < -0.05) {
                divAlerta.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> ¡Atención! Se superó el monto total de la deuda.';
                divAlerta.className = 'mt-2 small text-danger fw-bold alerta-exceso';
                if (spanRest) spanRest.classList.add('text-danger');
                if (spanRestBs) spanRestBs.classList.add('text-danger');
                if (optCompletado) optCompletado.disabled = true;
                estatusSelect.value = "0"; 

            } else if (Math.abs(restanteMatematicoUSD) <= 0.05) {
                divAlerta.innerHTML = '<i class="bi bi-check-circle-fill"></i> ¡Excelente! Pago total del envío cubierto.';
                divAlerta.className = 'mt-2 small text-success fw-bold alerta-exceso';
                if (spanRest) spanRest.classList.add('text-success');
                if (spanRestBs) spanRestBs.classList.add('text-success');
                if (optCompletado) optCompletado.disabled = false;
                estatusSelect.value = "1"; 

            } else {
                divAlerta.innerHTML = '';
                divAlerta.className = 'mt-2 small alerta-exceso';
                if (optCompletado) optCompletado.disabled = true;
                estatusSelect.value = "0"; 
            }
        }
    }

    // Función de autocompletar con botón "Añadir"
    function autocompletarMonto(modo) {
        const isRegistro = modo === 'registrar';
        const inputMonto = document.getElementById(isRegistro ? 'monto_abonado_input' : 'monto_editar');
        const select = document.getElementById(isRegistro ? 'metodos' : 'metodo_editar');
        const montoBaseCalculo = isRegistro ? montoTotalEnvioActual : montoTotalEnvioEditar;
        
        let monedaSeleccionada = 'USD';
        if (select && select.selectedIndex >= 0) {
            let opcion = select.options[select.selectedIndex];
            if (opcion) monedaSeleccionada = opcion.getAttribute('data-moneda') || 'USD';
        }

        let tasaMonedaDestino = tasasDelDia[monedaSeleccionada] || 1;
        let valorAutocompletado = (montoBaseCalculo * tasaDolar) / tasaMonedaDestino;

        if (inputMonto) {
            inputMonto.value = valorAutocompletado.toFixed(2);
            calcularRestante(modo);
        }
    }

    const btnAddRegistrar = document.getElementById('button-addon1');
    if (btnAddRegistrar) btnAddRegistrar.addEventListener('click', () => autocompletarMonto('registrar'));

    const btnAddEditar = document.getElementById('btn_añadir_editar');
    if (btnAddEditar) btnAddEditar.addEventListener('click', () => autocompletarMonto('editar'));

    // Delegación de Eventos
    document.body.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'monto_abonado_input') calcularRestante('registrar');
        if (e.target && e.target.id === 'monto_editar') calcularRestante('editar');
    });

    document.body.addEventListener('change', function(e) {
        if (e.target && e.target.id === 'metodos') {
            calcularRestante('registrar');
            filtrarBancos('registrar');
        } else if (e.target && e.target.id === 'metodo_editar') {
            calcularRestante('editar');
            filtrarBancos('editar');
        }
    });

    // Modal Registrar
    const modalRegistrar = document.getElementById('registerPago');
    if (modalRegistrar) {
        modalRegistrar.addEventListener('show.bs.modal', function(event) {
            const boton = event.relatedTarget;
            const codEnvio = boton.getAttribute('data-envio');
            
            montoTotalEnvioActual = parseFloat(boton.getAttribute('data-montorestante')) || 0;

            const codEnvioInput = document.getElementById('cod_envio_input');
            const codEnvioMostrar = document.getElementById('codigo_envio_mostrar');
            const inputMonto = document.getElementById('monto_abonado_input');
            const selectMetodo = document.getElementById('metodos');
            const selectBanco = document.getElementById('cuentas_registrar');

            if(codEnvioInput) codEnvioInput.value = codEnvio;
            if(codEnvioMostrar) codEnvioMostrar.textContent = codEnvio;
            if(inputMonto) inputMonto.value = '';
            
            if(selectMetodo) selectMetodo.selectedIndex = 0; 
            if(selectBanco) {
                Array.from(selectBanco.options).forEach(opt => opt.disabled = false);
                selectBanco.selectedIndex = 0; 
            }

            let divAlerta = document.getElementById('alerta_visual_reg');
            if(divAlerta) divAlerta.innerHTML = '';

            calcularRestante('registrar');
        });
    }

    // Modal Editar
    const modalEditar = document.getElementById('modalEditarPago');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', function(event) {
            const boton = event.relatedTarget;
            const id = boton.getAttribute('data-id');
            const codEnvio = boton.getAttribute('data-envio');
            const detalle = boton.getAttribute('data-detalle'); 
            const monto = boton.getAttribute('data-monto');
            const referencia = boton.getAttribute('data-referencia');
            const estatus = boton.getAttribute('data-estatus');
            const metodo = boton.getAttribute('data-metodo');
            const banco = boton.getAttribute('data-banco');
            
            montoTotalEnvioEditar = parseFloat(boton.getAttribute('data-montobaseeditar')) || 0;

            let codPagoEditar = document.getElementById('cod_pago_editar');
            let codEnvioEditar = document.getElementById('cod_envio_editar');
            let codDetalleEditar = document.getElementById('cod_detallepago_editar'); 
            let inputMontoEditar = document.getElementById('monto_editar');
            let refEditar = document.getElementById('referencia_editar');
            let estatusEditar = document.getElementById('estatus_pago_editar');
            let selectMetodoEditar = document.getElementById('metodo_editar'); 
            let bancoEditar = document.getElementById('cuentas_editar');

            if(codPagoEditar) codPagoEditar.value = id;
            if(codEnvioEditar) codEnvioEditar.value = codEnvio;
            if(codDetalleEditar) codDetalleEditar.value = detalle; 
            if(inputMontoEditar) inputMontoEditar.value = monto;  
            if(refEditar) refEditar.value = referencia;
            if(selectMetodoEditar) selectMetodoEditar.value = metodo;
            filtrarBancos('editar');
            if(bancoEditar) bancoEditar.value = banco;
            if(estatusEditar) {
                let optCompletado = estatusEditar.querySelector('option[value="1"]');
                if (optCompletado) optCompletado.disabled = false;
                estatusEditar.value = estatus; 
            }

            const form = document.getElementById('formEditarPago');
            if (form) {
                form.setAttribute('data-orig-monto', monto);
                form.setAttribute('data-orig-referencia', referencia);
                form.setAttribute('data-orig-estatus', estatus);
                form.setAttribute('data-orig-metodo', metodo);
                form.setAttribute('data-orig-banco', banco);
            }
            
            calcularRestante('editar');
        });
    }

    // Formulario Registrar
    const formPago = document.getElementById('formPago');
    if (formPago) {
        formPago.addEventListener('submit', function(event) {
            const inputMonto = document.getElementById('monto_abonado_input');
            const monto = inputMonto ? inputMonto.value.trim() : '';
            const refInput = document.getElementById('referencia');
            const referencia = refInput ? refInput.value.trim() : '';
            const alerta = document.getElementById('alerta_visual_reg');

            if (monto === "" || referencia === "") {
                event.preventDefault();
                Swal.fire({ title: "Error de validación", text: "Por favor, complete los campos obligatorios.", icon: "error" });
                return;
            }

            if (alerta && alerta.classList.contains('text-danger')) {
                event.preventDefault();
                Swal.fire({ title: "Monto Excedido", text: "No puedes registrar un pago que supere el monto restante de la deuda.", icon: "error" });
                return;
            }
        });
    }

    // Formulario Editar
    const formEditar = document.getElementById('formEditarPago');
    if (formEditar) {
        formEditar.addEventListener('submit', function(event) {
            const origMonto = this.getAttribute('data-orig-monto');
            const origRef = this.getAttribute('data-orig-referencia');
            const origEstatus = this.getAttribute('data-orig-estatus');
            const origMetodo = this.getAttribute('data-orig-metodo') || '';
            const origBanco = this.getAttribute('data-orig-banco') || '';
            
            const inputOculto = document.getElementById('monto_dolares_oculto_editar');
            const inputVisible = document.getElementById('monto_editar');
            const actMonto = inputOculto ? inputOculto.value.trim() : (inputVisible ? inputVisible.value.trim() : '');
            
            const refInput = document.getElementById('referencia_editar');
            const actRef = refInput ? refInput.value.trim() : '';
            
            const estatusInput = document.getElementById('estatus_pago_editar');
            const actEstatus = estatusInput ? estatusInput.value : '';
            
            const metodoInput = document.getElementById('metodo_editar');
            const actMetodo = metodoInput ? metodoInput.value : '';
            
            const bancoInput = document.getElementById('cuentas_editar');
            const actBanco = bancoInput ? bancoInput.value : '';

            const alerta = document.getElementById('alerta_visual_edit');

            if (alerta && alerta.classList.contains('text-danger')) {
                event.preventDefault();
                Swal.fire({ title: "Monto Excedido", text: "La modificación supera el límite del pago total del envío.", icon: "error" });
                return;
            }

            if (origMonto === actMonto && origRef === actRef && origEstatus === actEstatus && origMetodo === actMetodo && origBanco === actBanco) {
                event.preventDefault();
                Swal.fire({ title: "Sin modificaciones", text: "Los datos ingresados son idénticos a los actuales. No se registraron cambios.", icon: "info" });
            }
        });
    }

    // Modal eliminar
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function(event) {
            event.preventDefault(); 
            let idPago = this.getAttribute('data-id');

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
                }
            });
        });
    });

    // Mensajes de alerta
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

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
            }
            if (title && text && icon) {
                Swal.fire({ title: title, text: text, icon: icon });
            }
        }, 100);
    }
});