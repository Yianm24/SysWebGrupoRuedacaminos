document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById('modalCuenta');

  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      const botonDeModal = document.querySelector('button[name="tipoSolicitud"]');
      //let botonActualizar = document.querySelector('button[name="tipoSolicitud"][value="actualizar"].d-none');

      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;

      const cod_cuenta = boton.getAttribute('datos-cod-cuenta');
      const nombre_propietario = boton.getAttribute('datos-nombre-propietario');
      const numero_cuenta = boton.getAttribute('datos-numero-cuenta');
      const cod_banco = boton.getAttribute('datos-cod-banco');
      const etiqueta = boton.getAttribute('datos-etiqueta');
      const estado = boton.getAttribute('datos-estado');

      const inputCodCuenta = modal.querySelector('.modal-body #cod-cuenta')
      const inputEstadoRegistro = modal.querySelector('.modal-body #estado')
      const inputNombrePropietario = modal.querySelector('.modal-body #nombre-propietario')
      const inputNumeroCuenta = modal.querySelector('.modal-body #numero-cuenta')
      const inputNombreBanco = modal.querySelector('.modal-body #nombre-banco')
      const inputEtiqueta = modal.querySelector('.modal-body #etiqueta-cuenta')

      switch (boton.title) {
        case "Registrar":
          
          botonDeModal.value = "registrar";
          botonDeModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
          //console.log("Se ha abierto el modal para registrar una nueva cuenta bancaria.");

          inputCodCuenta.value = "";
          inputNombrePropietario.value = "";
          inputNumeroCuenta.value = "";
          inputNombreBanco.value = "";
          inputEtiqueta.value = "";

        break;
        case "Actualizar":

          botonDeModal.value = "actualizar";
          botonDeModal.innerHTML = '<i class="bi bi-pencil"></i> Actualizar';
          
          if (cod_cuenta != "" && estado == 1) {
            //Inserta valores dentro de los inputs del formulario para actualizar
            inputCodCuenta.value = cod_cuenta;
            inputNombrePropietario.value = nombre_propietario;
            inputNumeroCuenta.value = numero_cuenta;
            inputNombreBanco.value = cod_banco;
            inputEtiqueta.value = etiqueta;

          } else {
            inputNombrePropietario.value = "Error: Registro inactivo";
            inputNumeroCuenta.value = "Error: Registro inactivo";
            inputNombreBanco.value = "Error: Registro inactivo";
            inputEtiqueta.value = "Error: Registro inactivo";
            console.log("No se puede editar el registro, ya que está inactivo.");
          }

        break;
      }
    })
  }

  const botonesEliminar = document.querySelectorAll('.btn-eliminar');
  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', function (event) {
      event.preventDefault();
      let codcuenta = this.getAttribute('data-id');

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
          form.action = '?url=cuenta';
          form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_cuenta" value="${codcuenta}">
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
          text = "La cuenta bancaria ha sido registrada correctamente.";
          icon = "success";
          break;
        case 'updated':
          title = "Actualización exitosa!";
          text = "La cuenta bancaria ha sido actualizada correctamente.";
          icon = "success";
          break;
        case 'deleted':
          title = "Eliminación exitosa!";
          text = "La cuenta bancaria ha sido eliminada correctamente.";
          icon = "success";
          break;
        case 'exists':
          title = "Cuenta bancaria existente!";
          text = "La cuenta bancaria ingresada ya existe en la base de datos.";
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