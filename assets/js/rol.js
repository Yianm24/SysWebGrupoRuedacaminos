document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('actualizarRol');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_rol = boton.getAttribute('datos-cod-rol');
            const nombre = boton.getAttribute('datos-nombre');
            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodRol = modal.querySelector('.modal-body #cod-rol')
            const inputNombre = modal.querySelector('.modal-body #nombre')


            // Asignar los valores obtenidos a los campos del formulario
            inputCodRol.value = cod_rol;
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
                    text = "El rol ha sido registrado correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "El rol ha sido actualizado correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "El rol ha sido eliminado correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Rol existente!";
                    text = "El rol ingresado ya existe en la base de datos.";
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
