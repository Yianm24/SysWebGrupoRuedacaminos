document.addEventListener("DOMContentLoaded", function () {

  const modal = document.getElementById('modalModelo');


  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      const encabezadoModal = modal.querySelector('h1#modalLabel');
      const botonModal = document.querySelector('button[name="tipoSolicitud"]');

      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;

      //Obtener los datos del vehículo desde los atributos datos- del botón
      const codmodelo = boton.getAttribute('datos-cod-modelo');
      const nombre = boton.getAttribute('datos-nombre');
      const codmarca = boton.getAttribute('datos-marca');
      const estado = boton.getAttribute('datos-estado');

      // Obtener referencias a los campos del formulario dentro del modal
      const inputCodModelo = modal.querySelector('.modal-body #cod-modelo');
      const inputNombre = modal.querySelector('.modal-body #nombre_modelo');
      const inputMarca = modal.querySelector('.modal-body #marca');

      switch (boton.title) {
        case "Registrar":
          const selectMarca = document.querySelector('.modal-body #marca');

          encabezadoModal.innerHTML = '<i class="bi bi-car-front me-2"></i> Registro de Modelo';
          botonModal.value = "registrar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
          inputCodModelo.value = "";
          inputNombre.value = "";
          inputMarca.value = "";
          selectMarca.selectedIndex = 0;


          break;

        case "Actualizar":
          encabezadoModal.innerHTML = '<i class="bi bi-car-front me-2"></i> Actualizacion de Modelo';
          botonModal.value = "actualizar";
          botonModal.innerHTML = '<i class="bi bi-pencil"></i> Actualizar';

          if (codmarca != "" && estado == 1) {
            // Asignar los valores obtenidos a los campos del formulario
            inputCodModelo.value = codmodelo;
            inputNombre.value = nombre;
            inputMarca.value = codmarca;
          } else {
            inputCodModelo.value = "Error: Registro inactivo";
            inputNombre.value = "Error: Registro inactivo";
            inputMarca.value = "Error: Registro inactivo";
          }

          break;
      }

    })
  }

  const botonesEliminar = document.querySelectorAll('.btn-eliminar');
  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', function (event) {
      event.preventDefault();
      let codmodelo = this.getAttribute('datos-cod-modelo');

      const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
        buttonsStyling: false
      });

      swalWithBootstrapButtons.fire({
        title: "¿Está seguro que desea eliminar este registro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          let form = document.createElement('form');
          form.method = 'POST';
          form.action = '?url=modelo';
          form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_modelo" value="${codmodelo}">
                    `;
          document.body.appendChild(form);
          form.submit();
        }
      });
    });
  });

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
          text = "El Modelo ha sido registrada correctamente.";
          icon = "success";
          break;
        case 'updated':
          title = "Actualización exitosa!";
          text = "El Modelo ha sido actualizada correctamente.";
          icon = "success";
          break;
        case 'deleted':
          title = "Eliminación exitosa!";
          text = "El Modelo ha sido eliminada correctamente.";
          icon = "success";
          break;
        case 'exists':
          title = "Modelo existente!";
          text = "El Modelo ingresada ya existe en la base de datos.";
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