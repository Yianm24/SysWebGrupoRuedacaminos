document.addEventListener("DOMContentLoaded", function () {
    
    let montoBaseCalculo = 0; 
    let inputTasasJson = document.getElementById('tasas_backend_json');
    let tasasDelDia = { "VES": 1, "USD": 1 };
    
    if (inputTasasJson && inputTasasJson.value) {
        try { tasasDelDia = JSON.parse(inputTasasJson.value); } catch (error) { console.error("Error leyendo las tasas", error); }
    }
    let tasaDolar = tasasDelDia['USD'] || 1;

    function filtrarBancos() {
        const selectMetodo = document.getElementById('metodos');
        const selectBanco = document.getElementById('cuentas');
        const inputRef = document.getElementById('referencia');

        if (!selectMetodo || !selectBanco || selectMetodo.selectedIndex <= 0) return;

        let opcionMetodo = selectMetodo.options[selectMetodo.selectedIndex];
        let nombreMetodo = opcionMetodo.text.toLowerCase();

        if (inputRef) {
            if (nombreMetodo.includes('efectivo')) {
                inputRef.value = "EFECTIVO";
                inputRef.setAttribute('readonly', true);
                inputRef.classList.add('bg-light');
                $(inputRef).trigger('input');
            } else {
                inputRef.removeAttribute('readonly');
                inputRef.classList.remove('bg-light');
                if (inputRef.value === "EFECTIVO") {
                    inputRef.value = "";
                    $(inputRef).trigger('input');
                }
            }
        }

        for (let i = 0; i < selectBanco.options.length; i++) {
            let optBanco = selectBanco.options[i];
            if (optBanco.value === "") continue; 
            let nombreBanco = optBanco.text.toLowerCase();

            if (nombreMetodo.includes('efectivo')) {
                if (nombreBanco.includes('caja')) {
                    optBanco.disabled = false;
                    selectBanco.value = optBanco.value; 
                } else { optBanco.disabled = true; }
            } else {
                if (nombreBanco.includes('caja')) { optBanco.disabled = true; } 
                else { optBanco.disabled = false; }
                if (selectBanco.options[selectBanco.selectedIndex] && selectBanco.options[selectBanco.selectedIndex].disabled) {
                    selectBanco.value = "";
                }
            }
        }
    }

    function calcularRestante() {
        const inputMonto = document.getElementById('monto_ingresado');
        const selectMetodo = document.getElementById('metodos');
        const spanSimb = document.getElementById('simbolo_moneda_dinamico');
        const inputOculto = document.getElementById('monto_dolares_oculto');
        const spanRestUSD = document.getElementById('monto_restante_dinamico');
        const spanRestBS = document.getElementById('monto_restante_bs_dinamico');
        const divAlerta = document.getElementById('alerta_visual');
        const inputEstatus = document.getElementById('estatus_pago'); 
        const divEstatusVisual = document.getElementById('estatus_pago_visual'); 
        const tarjetaEstatus = document.getElementById('tarjeta_estatus'); 

        let montoIngresado = inputMonto && inputMonto.value ? parseFloat(inputMonto.value) : 0;
        let moneda = 'USD';
        
        if (selectMetodo && selectMetodo.selectedIndex >= 0) {
            let opcion = selectMetodo.options[selectMetodo.selectedIndex];
            if (opcion) moneda = opcion.getAttribute('data-moneda') || 'USD';
        }

        // Conversión a Dólares
        let dolaresCalculados = (moneda === 'USD') ? montoIngresado : (montoIngresado / tasaDolar);
        let abonadoUSD = Number(dolaresCalculados.toFixed(2));
        let deudaUSD = Number(montoBaseCalculo.toFixed(2));

        if (spanSimb) {
            if (moneda === 'VES') spanSimb.innerHTML = 'Bs';
            else if (moneda === 'EUR') spanSimb.innerHTML = '€';
            else spanSimb.innerHTML = '$';
        }

        if (inputOculto) inputOculto.value = abonadoUSD.toFixed(2);
        
        let restanteUSD = Number((deudaUSD - abonadoUSD).toFixed(2));
        let mostrarRestanteUSD = Math.max(0, restanteUSD);
        
        if (spanRestUSD) spanRestUSD.textContent = mostrarRestanteUSD.toFixed(2);
        if (spanRestBS) spanRestBS.textContent = (mostrarRestanteUSD * tasaDolar).toFixed(2);

        if (spanRestUSD) spanRestUSD.classList.remove('text-danger', 'text-success');
        if (spanRestBS) spanRestBS.classList.remove('text-danger', 'text-success');

        if (inputEstatus && divEstatusVisual && divAlerta && tarjetaEstatus) {
            
            //Validación para evitar montos nulos por conversión
            if (montoIngresado > 0 && abonadoUSD === 0) {
                divAlerta.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> El monto es muy bajo (equivale a $0.00).';
                divAlerta.className = 'mt-2 small text-danger fw-bold';
                inputEstatus.value = "0"; 
                divEstatusVisual.textContent = "Inválido";
                tarjetaEstatus.className = "alert alert-danger text-center shadow-sm mb-0 p-2 text-white";
                return;
            }

            // Validación de valor con 2 decimales.
            if (restanteUSD < 0) {
                divAlerta.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> ¡Atención! Se superó el monto total de la deuda.';
                divAlerta.className = 'mt-2 small text-danger fw-bold alerta-exceso';
                if (spanRestUSD) spanRestUSD.classList.add('text-danger');
                if (spanRestBS) spanRestBS.classList.add('text-danger');
                
                inputEstatus.value = "0"; 
                divEstatusVisual.textContent = "Excedido";
                tarjetaEstatus.className = "alert alert-danger text-center shadow-sm mb-0 p-2 text-white";

            } else if (restanteUSD === 0) {
                divAlerta.innerHTML = '<i class="bi bi-check-circle-fill"></i> ¡Excelente! Pago total del envío cubierto.';
                divAlerta.className = 'mt-2 small text-success fw-bold alerta-exceso';
                if (spanRestUSD) spanRestUSD.classList.add('text-success');
                if (spanRestBS) spanRestBS.classList.add('text-success');
                
                inputEstatus.value = "1"; 
                divEstatusVisual.textContent = "Completado";
                tarjetaEstatus.className = "alert alert-success text-center shadow-sm mb-0 p-2 text-dark";

            } else {
                divAlerta.innerHTML = '';
                divAlerta.className = 'mt-2 small alerta-exceso';
                
                inputEstatus.value = "0"; 
                divEstatusVisual.textContent = "Pendiente";
                tarjetaEstatus.className = "alert alert-warning text-center shadow-sm mb-0 p-2 text-dark";
            }
        }
    }

    function autocompletarMonto() {
        const inputMonto = document.getElementById('monto_ingresado');
        const selectMetodo = document.getElementById('metodos');
        
        let moneda = 'USD';
        if (selectMetodo && selectMetodo.selectedIndex >= 0) {
            let opcion = selectMetodo.options[selectMetodo.selectedIndex];
            if (opcion) moneda = opcion.getAttribute('data-moneda') || 'USD';
        }

        let valorAutocompletado = (moneda === 'USD') ? montoBaseCalculo : (montoBaseCalculo * tasaDolar);

        if (inputMonto) {
            inputMonto.value = valorAutocompletado.toFixed(2);
            $(inputMonto).trigger('input');
            calcularRestante();
        }
    }

    const btnAutocompletar = document.getElementById('btn_autocompletar');
    if (btnAutocompletar) btnAutocompletar.addEventListener('click', autocompletarMonto);

    document.body.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'monto_ingresado') calcularRestante();
    });

    document.body.addEventListener('change', function(e) {
        if (e.target && e.target.id === 'metodos') {
            filtrarBancos();
            calcularRestante();
            $('#monto_ingresado').trigger('input');
        }
        
        const btnSubmit = document.getElementById('btnSubmitModal');
        if (btnSubmit && btnSubmit.value === 'actualizar' && (e.target.tagName === 'SELECT' || e.target.type === 'date')) {
            $('#monto_ingresado').trigger('input'); 
        }
    });

    const modalPago = document.getElementById('modalPago');
    if (modalPago) {
        modalPago.addEventListener('show.bs.modal', function(event) {
            const botonTrig = event.relatedTarget;
            const tituloModal = modalPago.querySelector('#modalLabel');
            const btnSubmit = modalPago.querySelector('#btnSubmitModal');
            const divCodigo = modalPago.querySelector('#div_codigo_envio');
            const codMostrar = modalPago.querySelector('#codigo_envio_mostrar');
            const divAlerta = modalPago.querySelector('#alerta_visual');
            const inputs = {
                cod_pago: modalPago.querySelector('#cod_pago'),
                cod_envio: modalPago.querySelector('#cod_envio'),
                cod_detalle: modalPago.querySelector('#cod_detallepago'),
                monto: modalPago.querySelector('#monto_ingresado'),
                fecha: modalPago.querySelector('#fecha_pago'),
                metodo: modalPago.querySelector('#metodos'),
                banco: modalPago.querySelector('#cuentas'),
                referencia: modalPago.querySelector('#referencia'),
                estatus: modalPago.querySelector('#estatus_pago')
            };

            const inputsEvaluar = modalPago.querySelectorAll('.input-evaluar');
            inputsEvaluar.forEach(input => {
                $(input).removeClass('is-valid is-invalid');$(input).siblings('.mensaje-error').hide().text('');
            });

            if (botonTrig.title === "Registrar" || botonTrig.getAttribute('title') === 'Registrar') {
                tituloModal.innerHTML = '<i class="bi bi-wallet2"></i> Registro de Pago';
                divCodigo.style.display = 'block';
                codMostrar.textContent = botonTrig.getAttribute('data-envio');
                btnSubmit.value = "registrar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Registrar';
                
                montoBaseCalculo = parseFloat(botonTrig.getAttribute('data-montorestante')) || 0;
                
                inputs.cod_pago.value = "";
                inputs.cod_envio.value = botonTrig.getAttribute('data-envio');
                inputs.cod_detalle.value = "";
                inputs.monto.value = "";
                inputs.referencia.value = "";
                inputs.metodo.selectedIndex = 0;
                Array.from(inputs.banco.options).forEach(opt => opt.disabled = false);
                inputs.banco.selectedIndex = 0;
                
                if (divAlerta) divAlerta.innerHTML = '';
                
                filtrarBancos();
                calcularRestante();
                $(inputs.monto).trigger('input');
                
            } else if (botonTrig.title === "Editar" || botonTrig.getAttribute('title') === 'Editar') {
                tituloModal.innerHTML = '<i class="bi bi-pencil-square"></i> Editar Pago';
                divCodigo.style.display = 'none';
                btnSubmit.value = "actualizar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Actualizar';

                montoBaseCalculo = parseFloat(botonTrig.getAttribute('data-montobaseeditar')) || 0;

                inputs.cod_pago.value = botonTrig.getAttribute('data-id');
                inputs.cod_envio.value = botonTrig.getAttribute('data-envio');
                inputs.cod_detalle.value = botonTrig.getAttribute('data-detalle');
                inputs.fecha.value = botonTrig.getAttribute('data-fecha');
                
                let metodoGuardado = String(botonTrig.getAttribute('data-metodo') || '');
                inputs.metodo.value = metodoGuardado;
                
                if (inputs.metodo.value !== metodoGuardado && inputs.metodo.options.length > 0) {
                    inputs.metodo.selectedIndex = 0;
                }

                let moneda = 'USD';
                if (inputs.metodo.selectedIndex >= 0) {
                    let opcion = inputs.metodo.options[inputs.metodo.selectedIndex];
                    if (opcion) moneda = opcion.getAttribute('data-moneda') || 'USD';
                }

                let montoIngresadoBD = parseFloat(botonTrig.getAttribute('data-monto-original')) || 0;
                inputs.monto.value = montoIngresadoBD.toFixed(2);
                
                inputs.referencia.value = botonTrig.getAttribute('data-referencia');
                
                filtrarBancos();
                calcularRestante(); 

                inputs.banco.value = String(botonTrig.getAttribute('data-banco') || '');

                const originales = {
                    monto: inputs.monto.value,
                    referencia: inputs.referencia.value,
                    estatus: String(botonTrig.getAttribute('data-estatus')),
                    metodo: inputs.metodo.value,
                    banco: inputs.banco.value,
                    fecha: inputs.fecha.value
                };
                document.getElementById('formPago').setAttribute('data-originales', JSON.stringify(originales));
                
                inputsEvaluar.forEach(input => $(input).trigger('input'));
                btnSubmit.disabled = true;
            }
        });
    }

    const formPago = document.getElementById('formPago');
    if (formPago) {
        formPago.addEventListener('submit', function(event) {
            const btnSubmit = document.getElementById('btnSubmitModal');
            const alerta = document.getElementById('alerta_visual');

            if (alerta && alerta.classList.contains('text-danger')) {
                event.preventDefault();
                Swal.fire({ title: "Monto Excedido", text: "No puedes registrar un pago que supere el monto total de la deuda.", icon: "error" });
                return;
            }

            if (btnSubmit.value === "actualizar") {
                const originales = JSON.parse(this.getAttribute('data-originales'));
                const actuales = {
                    monto: document.getElementById('monto_ingresado').value,
                    referencia: document.getElementById('referencia').value,
                    estatus: document.getElementById('estatus_pago').value,
                    metodo: document.getElementById('metodos').value,
                    banco: document.getElementById('cuentas').value,
                    fecha: document.getElementById('fecha_pago').value
                };

                if (JSON.stringify(originales) === JSON.stringify(actuales)) {
                    event.preventDefault();
                    Swal.fire({ title: "Sin modificaciones", text: "Los datos ingresados son idénticos a los actuales. No se registraron cambios.", icon: "info" });
                }
            }
        });
    }

    //confirmacion de eliminar
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
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({ title: "Cancelado", text: "Eliminación del pago cancelada", icon: "error" });
                }
            });
        });
    });

    //mensajes de alerta
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