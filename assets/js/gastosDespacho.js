document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById('modalGastoDespacho');

  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      const encabezadoModal = modal.querySelector('h1#modalLabel');
      const botonModal = document.querySelector('button[name="tipoSolicitud"]');
      const boton = event.relatedTarget;

      const cod_gasto_despacho = boton.getAttribute('datos-cod-gasto-despacho');
      const cod_despacho = boton.getAttribute('datos-cod-despacho');
      const descripcion = boton.getAttribute('datos-descripcion');
      const monto = boton.getAttribute('datos-monto');
      const estado = boton.getAttribute('datos-estado');

      const inputCodGasto = modal.querySelector('.modal-body #cod-gasto-despacho');
      const inputCodDespacho = modal.querySelector('.modal-body #cod_despacho');
      const inputDescripcion = modal.querySelector('.modal-body #descripcion');
      const inputMonto = modal.querySelector('.modal-body #monto');

      switch (boton.title) {
        case "Registrar":
          encabezadoModal.innerHTML = '<i class="bi bi-cash-stack me-2"></i> Registro de Gasto de Despacho';
          botonModal.value = "registrar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
          inputCodGasto.value = "";
          inputCodDespacho.value = "";
          inputDescripcion.value = "";
          inputMonto.value = "";
          break;
        case "Actualizar":
          encabezadoModal.innerHTML = '<i class="bi bi-cash-stack me-2"></i> Actualización de Gasto de Despacho';
          botonModal.value = "actualizar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Actualizar';

          if (cod_gasto_despacho != "" && estado == 1) {
            inputCodGasto.value = cod_gasto_despacho;
            inputCodDespacho.value = cod_despacho;
            inputDescripcion.value = descripcion;
            inputMonto.value = monto;
          } else {
            inputCodGasto.value = "Error: Registro inactivo";
            inputCodDespacho.value = "";
            inputDescripcion.value = "Error: Registro inactivo";
            inputMonto.value = "";
          }
          break;
      }
    });
  }

  const botonesEliminar = document.querySelectorAll('.btn-eliminar');
  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', function (event) {
      event.preventDefault();
      let codGasto = this.getAttribute('datos-cod-gasto-despacho');

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
          form.action = '?url=gastoDespacho';
          form.innerHTML = `
            <input type="hidden" name="tipoSolicitud" value="eliminar">
            <input type="hidden" name="cod_gasto_despacho" value="${codGasto}">
          `;
          document.body.appendChild(form);
          form.submit();
        }
      });
    });
  });

  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  const mensaje = urlParams.get('msg');

  if (status) {
    setTimeout(() => {
      let title, text, icon;

      switch (status) {
        case 'success':
          title = "Registro exitoso!";
          text = "El Gasto de Despacho ha sido registrado correctamente.";
          icon = "success";
          break;
        case 'updated':
          title = "Actualización exitosa!";
          text = "El Gasto de Despacho ha sido actualizado correctamente.";
          icon = "success";
          break;
        case 'deleted':
          title = "Eliminación exitosa!";
          text = "El Gasto de Despacho ha sido eliminado correctamente.";
          icon = "success";
          break;
        case 'exists':
          title = "Registro existente!";
          text = "El registro ingresado ya existe en la base de datos.";
          icon = "warning";
          break;
        case 'empty':
          title = "Campos vacíos!";
          text = "Uno o más campos están vacíos.";
          icon = "warning";
          break;
        case 'error':
          title = "Error!";
          text = `Se produjo un error en el proceso de ${mensaje}.`;
          icon = "error";
          break;
        case 'exception':
          title = "Exception Retornada!";
          text = `El servidor devolvio el siguiente mensaje: ${mensaje}`;
          icon = "error";
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