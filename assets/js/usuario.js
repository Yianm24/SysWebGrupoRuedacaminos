document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('actualizarUsuario');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;


            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_usuario = boton.getAttribute('datos-cod-usuario');
            const nombre = boton.getAttribute('datos-nombre');
            const cedula = boton.getAttribute('datos-cedula');
            const password = boton.getAttribute('datos-password');
            const rol = boton.getAttribute('datos-cod-rol');
            
            
            
            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodUsuario = modal.querySelector('.modal-body #cod-usuario')
            const inputNombre = modal.querySelector('.modal-body #nombre')
            const inputCedula = modal.querySelector('.modal-body #cedula')
            const inputPassword = modal.querySelector('.modal-body #password')
            const inputRol = modal.querySelector('.modal-body #rol')


            // Asignar los valores obtenidos a los campos del formulario
            inputCodUsuario.value = cod_usuario;
            inputNombre.value = nombre;
            inputCedula.value = cedula;
            inputPassword.value = password;
            inputRol.value = rol;
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
                    text = "El usuario ha sido registrado correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "El usuario ha sido actualizado correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "El usuario ha sido eliminado correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Usuario existente!";
                    text = "El usuario ya se encuentra registrado.";
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


