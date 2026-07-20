document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('actualizarMetodoPago');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;



            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_metodo = boton.getAttribute('datos-cod-metodo');
            const nombre = boton.getAttribute('datos-nombre');
            const cod_moneda = boton.getAttribute('datos-cod-moneda');
            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodMetodo = modal.querySelector('.modal-body #cod-metodo')
            const inputNombre = modal.querySelector('.modal-body #nombre')
            const inputCodMoneda = modal.querySelector('.modal-body #moneda')


            // Asignar los valores obtenidos a los campos del formulario
            inputCodMetodo.value = cod_metodo;
            inputNombre.value = nombre;
            inputCodMoneda.value = cod_moneda;
        })
    }

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


