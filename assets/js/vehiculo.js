document.addEventListener("DOMContentLoaded", function () {
//const boton = document.querySelectorAll('.obtener-codigo');
//const codigo = document.querySelectorAll('.codigo_vehiculo');
const modal = document.getElementById('actualizarVehiculo');

/*boton.forEach(function(boton) {
    boton.addEventListener('click', function() {
        //console.log(codigo.value);
        console.log(this.value);
        
        //location.href = "?url=vehiculo&prueba=" + encodeURIComponent(this.value);
      
    });
});*/


  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;
      
      //Obtener los datos del vehículo desde los atributos datos- del botón
      const cod_vehiculo = boton.getAttribute('datos-cod-vehiculo');
      const placa = boton.getAttribute('datos-placa');
      const color = boton.getAttribute('datos-color');
      const ano = boton.getAttribute('datos-ano');
      
      // Obtener referencias a los campos del formulario dentro del modal
      const inputCodVehiculo = modal.querySelector('.modal-body #cod-vehiculo')
      const inputPlaca = modal.querySelector('.modal-body #placa')
      const inputColor = modal.querySelector('.modal-body #color')
      const inputAno = modal.querySelector('.modal-body #ano')
      
      
      // Asignar los valores obtenidos a los campos del formulario
      inputCodVehiculo.value = cod_vehiculo;
      inputPlaca.value = placa;
      inputColor.value = color;
      inputAno.value = ano;
    })
  }
});