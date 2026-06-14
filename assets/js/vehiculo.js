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
      // Button that triggered the modal
      const boton = event.relatedTarget
      // Extract info from data-bs-* attributes
      //const recipient = button.getAttribute('data-bs-whatever')
      // If necessary, you could initiate an Ajax request here
      // and then do the updating in a callback.
      const placa = boton.getAttribute('datos-placa');
      const color = boton.getAttribute('datos-color');
      const ano = boton.getAttribute('datos-ano');
      //window.location.href = "&obtenercodigo=" + encodeURIComponent(codVehiculo);
      // Update the modal's content.
      const inputPlaca = modal.querySelector('.modal-body #placa')
      const inputColor = modal.querySelector('.modal-body #color')
      const inputAno = modal.querySelector('.modal-body #ano')

      inputPlaca.value = placa;
      inputColor.value = color;
      inputAno.value = ano;
    })
  }
});