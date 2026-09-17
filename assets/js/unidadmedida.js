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

  const botonesEliminar = document.querySelectorAll('.btn-eliminar');
  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', function (event) {
      event.preventDefault();
      let codunidad = this.getAttribute('data-id');

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
          form.action = '?url=unidadesmedida';
          form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_unidad" value="${codunidad}">
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
          text = "La unidad de medida ha sido registrada correctamente.";
          icon = "success";
          break;
        case 'updated':
          title = "Actualización exitosa!";
          text = "La unidad de medida ha sido actualizada correctamente.";
          icon = "success";
          break;
        case 'deleted':
          title = "Eliminación exitosa!";
          text = "La unidad de medida ha sido eliminada correctamente.";
          icon = "success";
          break;
        case 'exists':
          title = "Unidad de medida existente!";
          text = "La unidad de medida ingresada ya existe en la base de datos.";
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