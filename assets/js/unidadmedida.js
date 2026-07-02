document.addEventListener("DOMContentLoaded", function () {

const modal = document.getElementById('actualizarUnidad');


  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;
      
      //Obtener los datos del vehículo desde los atributos datos- del botón
      const cod_unidad = boton.getAttribute('datos-cod-unidad');
      const nombre = boton.getAttribute('datos-nombre');
      const abreviatura = boton.getAttribute('datos-abreviatura');
      const tipo = boton.getAttribute('datos-tipo');
      
      // Obtener referencias a los campos del formulario dentro del modal
      const inputCodUnidad = modal.querySelector('.modal-body #cod-unidad')
      const inputAbreviatura = modal.querySelector('.modal-body #abreviatura')
      const inputNombre = modal.querySelector('.modal-body #nombre-unidad')
      const inputTipo = modal.querySelector('.modal-body #tipo-unidad')
      
      
      // Asignar los valores obtenidos a los campos del formulario
      inputCodUnidad.value = cod_unidad;
      inputAbreviatura.value = abreviatura;
      inputNombre.value = nombre;
      inputTipo.value = tipo;
    })
  }
});