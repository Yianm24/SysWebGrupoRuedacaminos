$(document).ready(function () {
  ajaxConsultar();
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

function ajaxConsultar() {
  iconoCargar("#tablaModelo tbody");
  $.ajax({
    url: "index.php?url=modelo",
    type: "POST",
    dataType: "json",
    data: {
      tipoSolicitud: "consultar"
    }
  })
    .done(function (response) {

      let tbody = $("#tablaModelo tbody");
      tbody.empty();

      let lista = Array.isArray(response) ? response : ['error al obtener los datos'];

      if (lista.length > 0) {
        let rowsHtml = "";

        $.each(lista, function (index, dato) {
          rowsHtml += `
            <tr>
              <td class="ps-4 fw-bold ">${dato.nombre}</td>
              <td class="ps-4 text-secondary ">${dato.nombre_marca}</td>
              <td class="text-start pe-4">
                <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-editar" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalModelo"
                    datos-cod-modelo="${dato.cod_modelo}"
                    datos-nombre="${dato.nombre}"
                    datos-marca="${dato.cod_marca}"
                    datos-estado="${dato.estado}">
                  <i class="bi bi-pencil"></i>
                </button>
                <a href="#" class="text-secondary btn-eliminar"
                    datos-cod-modelo="${dato.cod_modelo}">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          `;
        });

        tbody.html(rowsHtml);
      } else {
        tbody.html(`
    <tr>
      <td colspan="2" class="text-center text-muted py-3">
        No se encontraron registros.
      </td>
    </tr>
  `);
      }
    })
    .fail(function (xhr, status, error) {
      console.error("Error al cargar los datos:", error);
      console.log("Respuesta cruda del servidor:", xhr.responseText);
    })

}

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

function iconoCargar(selector) {
  const elementoHtml = $(`${selector}`);
  elementoHtml.html(`
    <tr>
      <td colspan="2" class="text-center text-muted py-3">
        <button class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Loading...
      </button>
      </td>
    </tr>
  `);
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