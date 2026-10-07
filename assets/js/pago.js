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

    //Función para calcular el monto restante en tiempo real según la moneda seleccionada y el monto ingresado.
    function calcularRestante(modo) {
        const isRegistro = modo === 'registrar';
        const inputMonto = document.getElementById(isRegistro ? 'monto_abonado_input' : 'monto_editar');
        const select = document.getElementById(isRegistro ? 'metodos' : 'metodo_editar');
        const spanSimb = document.getElementById(isRegistro ? 'simbolo_moneda_dinamico' : 'simbolo_moneda_editar_dinamico');
        const inputOculto = document.getElementById(isRegistro ? 'monto_dolares_oculto' : 'monto_dolares_oculto_editar');
        const spanRest = document.getElementById(isRegistro ? 'monto_restante_dinamico' : 'monto_restante_editar_dinamico');
        const spanRestBs = document.getElementById(isRegistro ? 'monto_restante_bs_dinamico' : 'monto_restante_bs_editar_dinamico');
        
        const montoTotalEnvio = isRegistro ? montoTotalEnvioActual : montoTotalEnvioEditar;
        
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
        
        let restanteUSD = Math.max(0, montoTotalEnvio - abonadoEnDolares);
        
        if (spanRest) spanRest.textContent = restanteUSD.toFixed(2);
        if (spanRestBs) spanRestBs.textContent = (restanteUSD * tasaDolar).toFixed(2);
    }

    //Eventos de Input y Select para recalcular el restante en tiempo real.
    document.body.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'monto_abonado_input') calcularRestante('registrar');
        if (e.target && e.target.id === 'monto_editar') calcularRestante('editar');
    });

    document.body.addEventListener('change', function(e) {
        if (e.target && e.target.id === 'metodos') calcularRestante('registrar');
        if (e.target && e.target.id === 'metodo_editar') calcularRestante('editar');
    });

    //Modal de Registrar.
    const modalRegistrar = document.getElementById('registerPago');
    if (modalRegistrar) {
        modalRegistrar.addEventListener('show.bs.modal', function(event) {
            const boton = event.relatedTarget;
            const codEnvio = boton.getAttribute('data-envio');
            montoTotalEnvioActual = parseFloat(boton.getAttribute('data-montototal')) || 0;

            const codEnvioInput = document.getElementById('cod_envio_input');
            const codEnvioMostrar = document.getElementById('codigo_envio_mostrar');
            const inputMonto = document.getElementById('monto_abonado_input');
            const selectMetodo = document.getElementById('metodos');

            if(codEnvioInput) codEnvioInput.value = codEnvio;
            if(codEnvioMostrar) codEnvioMostrar.textContent = codEnvio;
            if(inputMonto) inputMonto.value = '';
            if(selectMetodo) selectMetodo.selectedIndex = 0; 

            calcularRestante('registrar');
        });
    }

    //Modal de Editar.
    const modalEditar = document.getElementById('modalEditarPago');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', function(event) {
            const boton = event.relatedTarget;
            const id = boton.getAttribute('data-id');
            const monto = boton.getAttribute('data-monto');
            const referencia = boton.getAttribute('data-referencia');
            const estatus = boton.getAttribute('data-estatus');
            const metodo = boton.getAttribute('data-metodo');
            const banco = boton.getAttribute('data-banco');
            const detalle = boton.getAttribute('data-detalle');
            
            montoTotalEnvioEditar = parseFloat(boton.getAttribute('data-montototal')) || 0;

            let codPagoEditar = document.getElementById('cod_pago_editar');
            let inputMontoEditar = document.getElementById('monto_editar');
            let refEditar = document.getElementById('referencia_editar');
            let estatusEditar = document.getElementById('estatus_pago_editar');
            let selectMetodoEditar = document.getElementById('metodo_editar');
            let bancoEditar = document.getElementById('banco_editar');
            let detalleEditar = document.getElementById('cod_detallepago_editar');

            if(codPagoEditar) codPagoEditar.value = id;
            if(inputMontoEditar) inputMontoEditar.value = monto; 
            if(refEditar) refEditar.value = referencia;
            if(estatusEditar) estatusEditar.value = estatus;
            if(selectMetodoEditar) selectMetodoEditar.value = metodo;
            if(bancoEditar) bancoEditar.value = banco;
            if(detalleEditar) detalleEditar.value = detalle;

            const form = document.getElementById('formEditarPago');
            if (form) {
                form.setAttribute('data-orig-monto', monto);
                form.setAttribute('data-orig-referencia', referencia);
                form.setAttribute('data-orig-estatus', estatus);
            }
            
            calcularRestante('editar');
        });
    }

    //Validación de campos obligatorios.
    const formPago = document.getElementById('formPago');
    if (formPago) {
        formPago.addEventListener('submit', function(event) {
            const inputMonto = document.getElementById('monto_abonado_input');
            const monto = inputMonto ? inputMonto.value.trim() : '';
            const refInput = document.getElementById('referencia');
            const referencia = refInput ? refInput.value.trim() : '';

            if (monto === "" || referencia === "") {
                event.preventDefault();
                Swal.fire({ title: "Error de validación", text: "Por favor, complete los campos obligatorios.", icon: "error" });
            }
        });
    }

    const formEditar = document.getElementById('formEditarPago');
    if (formEditar) {
        formEditar.addEventListener('submit', function(event) {
            const origMonto = this.getAttribute('data-orig-monto');
            const origRef = this.getAttribute('data-orig-referencia');
            const origEstatus = this.getAttribute('data-orig-estatus');
            
            const inputOculto = document.getElementById('monto_dolares_oculto_editar');
            const inputVisible = document.getElementById('monto_editar');
            const actMonto = inputOculto ? inputOculto.value.trim() : (inputVisible ? inputVisible.value.trim() : '');
            
            const refInput = document.getElementById('referencia_editar');
            const actRef = refInput ? refInput.value.trim() : '';
            const estatusInput = document.getElementById('estatus_pago_editar');
            const actEstatus = estatusInput ? estatusInput.value : '';

            if (origMonto === actMonto && origRef === actRef && origEstatus === actEstatus) {
                event.preventDefault();
                Swal.fire({ title: "Sin modificaciones", text: "Los datos ingresados son idénticos a los actuales. No se registraron cambios.", icon: "info" });
            }
        });
    }

    //Modal de Eliminar.
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
                    swalWithBootstrapButtons.fire({ title: "Cancelado", text: "Eliminación de pago cancelada", icon: "error" });
                }
            });
        });
    });

    //Mensajes de alerta.
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