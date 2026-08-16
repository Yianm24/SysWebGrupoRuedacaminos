document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('modalMetodoPago');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const encabezadoModal = modal.querySelector('h1#modalLabel');
            const boton = event.relatedTarget;
            const botonModal = document.querySelector('button[name="tipoSolicitud"]');



            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_metodo = boton.getAttribute('datos-cod-metodo');
            const nombre = boton.getAttribute('datos-nombre');
            const cod_moneda = boton.getAttribute('datos-cod-moneda');
            const estado = boton.getAttribute('datos-estado');

            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodMetodo = modal.querySelector('.modal-body #cod-metodo')
            const inputNombre = modal.querySelector('.modal-body #nombre')
            const inputCodMoneda = modal.querySelector('.modal-body #moneda')


            switch (boton.title) {
                case "Registrar":
                    encabezadoModal.innerHTML = '<i class="bi bi-coin"></i> Registro de Metodo de Pago';
                    botonModal.value = "registrar";
                    botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
                    inputCodMetodo.value = "";
                    inputNombre.value = "";
                    inputCodMoneda.value = "";
                    break;
                case "Actualizar":

                    encabezadoModal.innerHTML = '<i class="bi bi-coin"></i> Actualizacion de Metodo de Pago';
                    botonModal.value = "actualizar";
                    botonModal.innerHTML = '<i class="bi bi-pencil"></i> Actualizar';

                    if (cod_metodo != "" && estado == 1) {
                        // Asignar los valores obtenidos a los campos del formulario
                        inputCodMetodo.value = cod_metodo;
                        inputNombre.value = nombre;
                        inputCodMoneda.value = cod_moneda;
                    } else {
                        inputCodMetodo.value = "Error: Registro inactivo";
                        inputNombre.value = "Error: Registro inactivo";
                        inputCodMoneda.value = "Error: Registro inactivo";
                    }
                    break;
            }

            // Asignar los valores obtenidos a los campos del formulario

        })
    }




    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function (event) {
            event.preventDefault();
            let codmetodo = this.getAttribute('datos-cod-metodo');

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
                    form.action = '?url=metodopago';
                    form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_metodo" value="${codmetodo}">
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
                    text = "El método de pago ha sido registrado correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "El método de pago ha sido actualizado correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "El método de pago ha sido eliminado correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Método de pago existente!";
                    text = "El método de pago ya se encuentra registrado.";
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


