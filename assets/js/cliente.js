document.addEventListener("DOMContentLoaded", function () {

    console.log("Cliente.js cargado correctamente.");

    // Lógica para alternar campos de Persona Natural o Jurídica en el Módulo de Clientes
    //const tipoPersona_remitente = document.querySelectorAll('input[name="tipo_persona_remitente"]');
    const radioClienteNatural = document.querySelector('form #persona_natural');
    const radioClienteJuridico = document.querySelector('form #persona_juridica');
    const remitente_natural = document.getElementById('remitente_natural-fields');
    const remitente_juridico = document.getElementById('remitente_juridico-fields');

    function alternarCamposRemitente() {
        // Evaluar la propiedad booleana .checked
        if (radioClienteNatural.checked) {
            remitente_natural.classList.remove('d-none');
            remitente_juridico.classList.add('d-none');
        } else if (radioClienteJuridico.checked) {
            remitente_natural.classList.add('d-none');
            remitente_juridico.classList.remove('d-none');
        }

    }

    //Logica relacionada a la funcion editar
    const modalEditarNatural = document.getElementById('editClienteNatural');


    if (modalEditarNatural) {
        modalEditarNatural.addEventListener('show.bs.modal', event => {

            // Obtener acceso al botón que disparó el modal
            const botonNatural = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_clienteNatural = botonNatural.getAttribute('datos-cod-cliente');
            const cedula = botonNatural.getAttribute('datos-doc-identidad');
            const nombre = botonNatural.getAttribute('datos-razon-social');
            const apellido = botonNatural.getAttribute('datos-apellido');
            const telefonoNatural = botonNatural.getAttribute('datos-telefono');
            const emailNatural = botonNatural.getAttribute('datos-email');
            const tipo_documentoNatural = botonNatural.getAttribute('datos-tipo-documento');
            const estadoNatural = botonNatural.getAttribute('datos-estado');

            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodCliente = modalEditarNatural.querySelector('.modal-body #cod_cliente')
            const inputCedula = modalEditarNatural.querySelector('.modal-body #cedula')
            const inputNombre = modalEditarNatural.querySelector('.modal-body #nombre')
            const inputApellido = modalEditarNatural.querySelector('.modal-body #apellido')
            const inputTelefonoNatural = modalEditarNatural.querySelector('.modal-body #telefono')
            const inputEmailNatural = modalEditarNatural.querySelector('.modal-body #correo')
            const inputTipoDocumentoNatural = modalEditarNatural.querySelector('.modal-body #tipo_doc_natural')

            if (botonNatural.title === "Editar") {

                if (cod_clienteNatural != "" && estadoNatural == 1) {
                    // Asignar los valores obtenidos a los campos del formulario
                    inputCodCliente.value = cod_clienteNatural;
                    inputCedula.value = cedula;
                    inputNombre.value = nombre;
                    inputApellido.value = apellido;
                    inputTelefonoNatural.value = telefonoNatural;
                    inputEmailNatural.value = emailNatural;
                    inputTipoDocumentoNatural.value = tipo_documentoNatural;
                } else {
                    inputCodCliente.value = "Error: Registro inactivo";
                    inputCedula.value = "Error: Registro inactivo";
                    inputNombre.value = "Error: Registro inactivo";
                    inputApellido.value = "Error: Registro inactivo";
                    inputTelefonoNatural.value = "Error: Registro inactivo";
                    inputEmailNatural.value = "Error: Registro inactivo";
                    inputTipoDocumentoNatural.value = '';


                }
            }
        });
    }
    const modalEditarJuridico = document.getElementById('editClienteJuridico');

    if (modalEditarJuridico) {
        modalEditarJuridico.addEventListener('show.bs.modal', event => {

            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_clienteJuridico = boton.getAttribute('datos-cod-cliente');
            const doc_identidad = boton.getAttribute('datos-doc-identidad');
            const razon_social = boton.getAttribute('datos-razon-social');
            const apellido = boton.getAttribute('datos-apellido');
            const telefono = boton.getAttribute('datos-telefono');
            const email = boton.getAttribute('datos-email');
            const tipo_documento = boton.getAttribute('datos-tipo-documento');
            const estado = boton.getAttribute('datos-estado');

            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodCliente = modalEditarJuridico.querySelector('.modal-body #cod_cliente')
            const inputRif = modalEditarJuridico.querySelector('.modal-body #rif')
            const inputRazonSocial = modalEditarJuridico.querySelector('.modal-body #razon_social')
            const inputTelefonoJuridico = modalEditarJuridico.querySelector('.modal-body #telefono')
            const inputEmailJuridico = modalEditarJuridico.querySelector('.modal-body #correo')
            const inputTipoDocumentoJuridico = modalEditarJuridico.querySelector('.modal-body #tipo_doc_juridico')

            if (boton.title === "Editar") {

                if (cod_clienteJuridico != "" && estado == 1) {
                    // Asignar los valores obtenidos a los campos del formulario
                    inputCodCliente.value = cod_clienteJuridico;
                    inputRif.value = doc_identidad;
                    inputRazonSocial.value = razon_social;
                    inputTelefonoJuridico.value = telefono;
                    inputEmailJuridico.value = email;
                    inputTipoDocumentoJuridico.value = tipo_documento;
                } else {
                    inputCodCliente.value = "Error: Registro inactivo";
                    inputRif.value = "Error: Registro inactivo";
                    inputRazonSocial.value = "Error: Registro inactivo";
                   inputTelefonoJuridico.value = "Error: Registro inactivo";
                    inputEmailJuridico.value = "Error: Registro inactivo";
                    inputTipoDocumentoJuridico.value = '';


                }
            }

        });
    }

    radioClienteNatural.addEventListener('change', alternarCamposRemitente);
    radioClienteJuridico.addEventListener('change', alternarCamposRemitente);

    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function (event) {
            event.preventDefault();
            let codcliente = this.getAttribute('datos-cod-cliente');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "¿Está seguro que desea eliminar este registro?",
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
                    form.action = '?url=cliente';
                    form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_cliente" value="${codcliente}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status) {
        // Usamos un pequeño retraso para asegurar que la página esté completamente cargada
        setTimeout(() => {
            let title, text, icon;

            switch (status) {
                case 'success':
                    title = "Registro exitoso!";
                    text = "El cliente ha sido registrado correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "El cliente ha sido editado correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "El cliente ha sido eliminado correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Cliente existente!";
                    text = "El cliente ya se encuentra registrado.";
                    icon = "warning";
                    break;
            }

            if (title && text && icon) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon
                });
            }
        }, 100);
    }

});