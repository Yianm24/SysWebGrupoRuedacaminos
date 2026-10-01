document.addEventListener("DOMContentLoaded", function () {
 
  const modal = document.getElementById('modalDespacho');


  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      const encabezadoModal = modal.querySelector('h1#modalLabel');
      const botonModal = document.querySelector('button[name="tipoSolicitud"]');
      console.log(botonModal);

      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;

      switch (boton.title) {
        case "Registrar":

          encabezadoModal.innerHTML = '<i class="bi bi-boxes me-2"> Registro Despacho';
          botonModal.value = "registrar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
          break
      };
    });
  };

});