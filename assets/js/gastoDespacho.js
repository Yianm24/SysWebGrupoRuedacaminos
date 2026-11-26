document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById('modalGastoDespacho');

  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      const encabezadoModal = modal.querySelector('h1#modalLabel');
      const botonModal = modal.querySelector('button[name="tipoSolicitud"]');
      const boton = event.relatedTarget;

      if (!boton) return;

      const codGasto = boton.getAttribute('datos-cod-gasto');
      const codDespacho = boton.getAttribute('datos-cod-despacho');
      const descripcion = boton.getAttribute('datos-descripcion');
      const monto = boton.getAttribute('datos-monto');
      const estado = boton.getAttribute('datos-estado');

      const inputCodGasto = modal.querySelector('#cod_gasto_despacho');
      const inputCodDespacho = modal.querySelector('#cod_despacho');
      const inputDescripcion = modal.querySelector('#descripcion');
      const inputMonto = modal.querySelector('#monto');

      switch (boton.title) {
        case "Registrar":
          encabezadoModal.innerHTML = '<i class="bi bi-cash-stack me-2"></i> Registro de Gasto de Despacho';
          botonModal.value = "registrar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
          botonModal.disabled = true;
          inputCodGasto.value = "";
          inputCodDespacho.value = "";
          inputDescripcion.value = "";
          inputMonto.value = "";
          break;

        case "Actualizar":
          encabezadoModal.innerHTML = '<i class="bi bi-cash-stack me-2"></i> Actualización de Gasto de Despacho';
          botonModal.value = "actualizar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Actualizar';

          if (codGasto !== "" && estado == 1) {
            inputCodGasto.value = codGasto;
            inputCodDespacho.value = codDespacho;
            inputDescripcion.value = descripcion;
            inputMonto.value = monto;

            [inputCodDespacho, inputDescripcion, inputMonto].forEach(el => {
              if (el) {
                el.dispatchEvent(new Event('input', { bubbles: true }));
              }
            });
          } else {
            inputCodGasto.value = "";
            inputCodDespacho.value = "";
            inputDescripcion.value = "Error: Registro inactivo";
            inputMonto.value = "";
            botonModal.disabled = true;
          }
          break;
      }
    });
  }

  const botonesEliminar = document.querySelectorAll('.btn-eliminar');
  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', function (event) {
      event.preventDefault();
      const codGasto = this.getAttribute('datos-cod-gasto');

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
          const form = document.createElement('form');
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
          title = "¡Registro exitoso!";
          text = "El gasto de despacho ha sido registrado correctamente.";
          icon = "success";
          break;
        case 'updated':
          title = "¡Actualización exitosa!";
          text = "El gasto de despacho ha sido actualizado correctamente.";
          icon = "success";
          break;
        case 'deleted':
          title = "¡Eliminación exitosa!";
          text = "El gasto de despacho ha sido eliminado correctamente.";
          icon = "success";
          break;
        case 'exists':
          title = "Gasto duplicado";
          text = "Ya existe un gasto con esa descripción para este código de despacho.";
          icon = "warning";
          break;
        case 'empty':
          title = "¡Campos vacíos!";
          text = "Uno o más campos están vacíos.";
          icon = "warning";
          break;
        case 'error':
          title = "¡Error!";
          text = mensaje === 'DespachoNoExiste'
            ? "El código de despacho ingresado no existe en la tabla de despachos."
            : `Se produjo un error en el proceso de ${mensaje}.`;
          icon = "error";
          break;
        case 'exception':
          title = "¡Excepción retornada!";
          text = `El servidor devolvió el siguiente mensaje: ${mensaje}`;
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