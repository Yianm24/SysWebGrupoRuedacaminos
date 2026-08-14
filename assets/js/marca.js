document.addEventListener("DOMContentLoaded", function () {

  const modal = document.getElementById('modalMarca');


  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      const encabezadoModal = modal.querySelector('h1#modalLabel');
      const botonDeModal = document.querySelector('button[name="tipoSolicitud"]');

      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;

      //Obtener los datos del vehículo desde los atributos datos- del botón
      const cod_marca = boton.getAttribute('datos-cod-marca');
      const nombre = boton.getAttribute('datos-nombre');

      // Obtener referencias a los campos del formulario dentro del modal
      const inputCodMarca = modal.querySelector('.modal-body #cod-marca')
      const inputNombre = modal.querySelector('.modal-body #nombre_marca')

      switch (boton.title) {
        case "Registrar":

          encabezadoModal.innerHTML = '<i class="bi bi-ev-front me-2"></i> Registro de Marca';
          botonDeModal.value = "registrar";
          botonDeModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
          inputCodMarca.value = "";
          inputNombre.value = "";
          break
        case "Actualizar":
          encabezadoModal.innerHTML = '<i class="bi bi-ev-front me-2"></i> Actualizacion de Marca';
          botonDeModal.value = "Actualizar";
          botonDeModal.innerHTML = '<i class="bi bi-save"></i> Actualizar';

          // Asignar los valores obtenidos a los campos del formulario
          inputCodMarca.value = cod_marca;
          inputNombre.value = nombre;
          break
      }
    })
  }

  const botonesEliminar = document.querySelectorAll('.btn-eliminar');
  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', function (event) {
      event.preventDefault();
      let codmarca = this.getAttribute('datos-cod-marca');

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
          form.action = '?url=marca';
          form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_marca" value="${codmarca}">
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
          text = "La Marca ha sido registrada correctamente.";
          icon = "success";
          break;
        case 'updated':
          title = "Actualización exitosa!";
          text = "La Marca ha sido actualizada correctamente.";
          icon = "success";
          break;
        case 'deleted':
          title = "Eliminación exitosa!";
          text = "La Marca ha sido eliminada correctamente.";
          icon = "success";
          break;
        case 'exists':
          title = "Marca existente!";
          text = "La Marca ingresada ya existe en la base de datos.";
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