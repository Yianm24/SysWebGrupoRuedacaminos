$(document).ready(function () {
  const modal = $('#modalModelo');

  if (modal) {
    modal.on('show.bs.modal', event => {
      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;
      accionModal(boton);

    })
  }

  $("#tablaModelo tbody").on("click", ".btn-eliminar", function (event) {
    event.preventDefault();

    const codmodelo = this.getAttribute("datos-cod-modelo");
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success ms-2",
        cancelButton: "btn btn-danger"
      },
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

// Lógica para mostrar alertas de estado (éxito, error, etc.)
const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('status');
const mensaje = urlParams.get('msg');

if (status) {
  mostrarAlerta(status, mensaje);
}

});

function accionModal(boton) {
  const encabezadoModal = $('#modalLabel');
  const botonModal = $('button[name="tipoSolicitud"]');

  //Obtener los datos del vehículo desde los atributos datos- del botón
  const codmodelo = $(boton).attr('datos-cod-modelo');
  const nombre = $(boton).attr('datos-nombre');
  const codmarca = $(boton).attr('datos-marca');
  const estado = $(boton).attr('datos-estado');

  // Obtener referencias a los campos del formulario dentro del modal
  const inputCodModelo = $('#cod-modelo');
  const inputNombre = $('#nombre_modelo');
  const inputMarca = $('#marca');

  switch ($(boton).attr('title')) {
    case "Registrar":

      encabezadoModal.html('<i class="bi bi-car-front me-2"></i> Registro de Modelo');
      botonModal.val("registrar");
      botonModal.html('<i class="bi bi-save"></i> Registrar');
      inputCodModelo.val("");
      inputNombre.val("");
      inputMarca.val("");
      $('#marca').prop('selectedIndex', 0);

    break;
    case "Actualizar":
      encabezadoModal.html('<i class="bi bi-car-front me-2"></i> Actualizacion de Modelo');
      botonModal.val("actualizar");
      botonModal.html('<i class="bi bi-pencil"></i> Actualizar');

      if (codmarca != "" && estado == 1) {
        // Asignar los valores obtenidos a los campos del formulario
        inputCodModelo.val(codmodelo);
        inputNombre.val(nombre);
        inputMarca.val(codmarca);
      } else {
        inputCodModelo.val("Error: Registro inactivo");
        inputNombre.val("Error: Registro inactivo");
        inputMarca.val("Error: Registro inactivo");
      }
      break;
  }
}

function mostrarAlerta(status, mensaje) {
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