const boton = document.getElementById('obtener-codigo');
//const codigo = document.getElementsById('codigo_vehiculo');
if(boton) {
    boton.addEventListener('click', function() {
        //console.log(codigo.value);
        alert("Hola mundo");
        //window.location.href = "?url=vehiculo&obtenercodigo=" + encodeURIComponent(codigo.value);
    });
}
/*
if (modal) {
  modal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    //const recipient = button.getAttribute('data-bs-whatever')
    // If necessary, you could initiate an Ajax request here
    // and then do the updating in a callback.
    let codVehiculo = button.value;
    window.location.href = "&obtenercodigo=" + encodeURIComponent(codVehiculo);
    // Update the modal's content.
    const modalTitle = modal.querySelector('.modal-title')
    const modalBodyInput = modal.querySelector('.modal-body input')

    modalTitle.textContent = `New message to ${recipient}`
    modalBodyInput.value = recipient
  })
}*/