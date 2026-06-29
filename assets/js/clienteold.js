document.addEventListener("DOMContentLoaded", function () {

    const modal = document.getElementById('editCliente');

    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
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
            const inputCodCliente = modal.querySelector('.modal-body #cod_cliente')
            const inputCedula = modal.querySelector('.modal-body #cedula')
            const inputRif = modal.querySelector('.modal-body #rif')
            const inputRazonSocial = modal.querySelector('.modal-body #razon_social')
            const inputApellido = modal.querySelector('.modal-body #apellido')
            const inputTelefono = modal.querySelector('.modal-body #telefono')
            const inputEmail = modal.querySelector('.modal-body #email')
            const inputTipoDocumento = modal.querySelector('.modal-body #tipo_doc_natural')

            // Asignar los valores obtenidos a los campos del formulario
            inputCodCliente.value = cod_cliente;
            inputCedula.value = doc_identidad;
            inputRif.value = doc_identidad;
            inputRazonSocial.value = razon_social;
            inputApellido.value = apellido;
            inputTelefono.value = telefono;
            inputEmail.value = email;
            inputTipoDocumento.value=tipo_documento;

        })
    }
});
