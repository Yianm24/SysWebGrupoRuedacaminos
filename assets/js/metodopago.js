document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('actualizarMetodoPago');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;


            // datos - cod - metodo="<?php echo $dato['cod_metodo']; ?>"
            // datos - nombre="<?php echo $dato['nombre']; ?>"
            // datos - cod - moneda="<?php echo $dato['cod_moneda']; ?>" >



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
});