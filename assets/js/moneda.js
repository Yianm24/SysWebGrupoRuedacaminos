document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('modificarMoneda');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_moneda= boton.getAttribute('datos-cod-moneda');
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


});


