document.addEventListener("DOMContentLoaded", function () {
    console.log("Cliente.js cargado correctamente.");
    // Lógica para alternar campos de Persona Natural o Jurídica en el Módulo de Clientes
    const tipoPersona_remitente = document.querySelectorAll('input[name="tipo_persona_remitente"]');
    const remitente_natural = document.getElementById('remitente_natural-fields');
    const remitente_juridico = document.getElementById('remitente_juridico-fields');

    if (tipoPersona_remitente.length > 0 && remitente_natural && remitente_juridico) {
        tipoPersona_remitente.forEach(input => {
            input.addEventListener('change', function () {
                if (this.value === 'remitente_natural') {
                    remitente_natural.style.display = 'block';
                    remitente_juridico.style.display = 'none';
                } else if (this.value === 'remitente_juridico') {
                    remitente_natural.style.display = 'none';
                    remitente_juridico.style.display = 'block';
                }
            });
        });
    }

    const tipoPersona_destinatario = document.querySelectorAll('input[name="tipo_persona_destinatario"]');
    const destinatario_natural = document.getElementById('destinatario_natural-fields');
    const destinatario_juridico = document.getElementById('destinatario_juridico-fields');

    if (tipoPersona_destinatario.length > 0 && destinatario_natural && destinatario_juridico) {
        tipoPersona_destinatario.forEach(input => {
            input.addEventListener('change', function () {
                if (this.value === 'destinatario_natural') {
                    destinatario_natural.style.display = 'block';
                    destinatario_juridico.style.display = 'none';
                } else if (this.value === 'destinatario_juridico') {
                    destinatario_natural.style.display = 'none';
                    destinatario_juridico.style.display = 'block';
                }
            });
        });
    }
    const modalNatural = document.getElementById('editClienteNatural');

    if (modalNatural) {
        modalNatural.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_cliente = boton.getAttribute('datos-cod-cliente');
            const doc_identidad = boton.getAttribute('datos-doc-identidad');
            const razon_social = boton.getAttribute('datos-razon-social');
            const apellido = boton.getAttribute('datos-apellido');
            const telefono = boton.getAttribute('datos-telefono');
            const email = boton.getAttribute('datos-email');
            const tipo_documento = boton.getAttribute('datos-tipo-documento');

            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodCliente = modalNatural.querySelector('.modal-body #cod_cliente')
            const inputCedula = modalNatural.querySelector('.modal-body #cedula')
            const inputRazonSocial = modalNatural.querySelector('.modal-body #razon_social')
            const inputApellido = modalNatural.querySelector('.modal-body #apellido')
            const inputTelefono = modalNatural.querySelector('.modal-body #telefono')
            const inputEmail = modalNatural.querySelector('.modal-body #email')
            const inputTipoDocumento = modalNatural.querySelector('.modal-body #tipo_doc_natural')

            // Asignar los valores obtenidos a los campos del formulario
            inputCodCliente.value = cod_cliente;
            inputCedula.value = doc_identidad;
            inputRazonSocial.value = razon_social;
            inputApellido.value = apellido;
            inputTelefono.value = telefono;
            inputEmail.value = email;
            inputTipoDocumento.value = tipo_documento;

        })
    }


    const modalJuridico = document.getElementById('editClienteJuridico');

    if (modalJuridico) {
        modalJuridico.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_cliente = boton.getAttribute('datos-cod-cliente');
            const doc_identidad = boton.getAttribute('datos-doc-identidad');
            const razon_social = boton.getAttribute('datos-razon-social');

            const telefono = boton.getAttribute('datos-telefono');
            const email = boton.getAttribute('datos-email');
            const tipo_documento = boton.getAttribute('datos-tipo-documento');

            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodCliente = modalJuridico.querySelector('.modal-body #cod_cliente')
            const inputRif = modalJuridico.querySelector('.modal-body #rif')
            const inputRazonSocial = modalJuridico.querySelector('.modal-body #razon_social')

            const inputTelefono = modalJuridico.querySelector('.modal-body #telefono')
            const inputEmail = modalJuridico.querySelector('.modal-body #email')
            const inputTipoDocumento = modalJuridico.querySelector('.modal-body #tipo_doc_natural')

            // Asignar los valores obtenidos a los campos del formulario
            inputCodCliente.value = cod_cliente;

            inputRif.value = doc_identidad;
            inputRazonSocial.value = razon_social;

            inputTelefono.value = telefono;
            inputEmail.value = email;
            inputTipoDocumento.value = tipo_documento;

        })
    }

});