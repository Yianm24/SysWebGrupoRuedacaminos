document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('modificarMoneda');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_moneda = boton.getAttribute('datos-cod-moneda');
            const nombre = boton.getAttribute('datos-nombre');
            const abreviatura = boton.getAttribute('datos-abreviatura');
            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodMoneda = modal.querySelector('.modal-body #cod-moneda')
            const inputNombre = modal.querySelector('.modal-body #nombre')
            const inputAbreviatura = modal.querySelector('.modal-body #abreviatura')


            // Asignar los valores obtenidos a los campos del formulario
            inputCodMoneda.value = cod_moneda;
            inputNombre.value = nombre;
            inputAbreviatura.value = abreviatura;
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
                    text = "La moneda ha sido registrada correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "La moneda ha sido actualizada correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "La moneda ha sido eliminada correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Moneda existente!";
                    text = "La moneda ingresada ya existe en la base de datos.";
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
