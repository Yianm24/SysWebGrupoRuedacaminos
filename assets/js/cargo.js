document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('modificarCargo');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_cargo = boton.getAttribute('datos-cod-cargo');
            const nombre = boton.getAttribute('datos-nombre');
            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodCargo = modal.querySelector('.modal-body #cod-cargo')
            const inputNombre = modal.querySelector('.modal-body #nombre')


            // Asignar los valores obtenidos a los campos del formulario
            inputCodCargo.value = cod_cargo;
            inputNombre.value = nombre;

        })
    }

    // Lógica para mostrar alertas de estado (éxito, error, etc.)
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status) {
        // Usamos un pequeño retraso para asegurar que la página esté completamente cargada
        setTimeout(() => {
            let title, text, icon;

            switch (status) {
                case 'success':
                    title = "Registro exitoso!";
                    text = "El cargo ha sido registrado correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "El cargo ha sido modificado correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "El cargo ha sido eliminado correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Cargo existente!";
                    text = "El cargo ingresado ya existe en la base de datos.";
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
