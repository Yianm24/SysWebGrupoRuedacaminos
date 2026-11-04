$(document).ready(function () {
  ajaxConsultar();

  const modal = $('#modalMarca');

  if (modal) {
    modal.on('show.bs.modal', event => {
      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;
      AccionModal(boton, modal);

    });
    $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
      event.preventDefault();
      const cod_marca = $("#cod-marca").val();
      const nombre_marca = $("#nombre_marca").val();
      const btnEnviar = this;
      const objmodal = bootstrap.Modal.getInstance(modal) ?? '';
      ajaxEnvioDatos(objmodal, btnEnviar, cod_marca, nombre_marca);
    });

  };

  $("#tablaMarca tbody").on("click", ".btn-eliminar", function (event) {
    event.preventDefault();

    const codmarca = this.getAttribute("datos-cod-marca");

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

function ajaxConsultar() {
  iconoCargar("#tablaMarca tbody");
  $.ajax({
    url: "index.php?url=marca",
    type: "POST",
    dataType: "json",
    data: {
      tipoSolicitud: "consultar"
    }
  })
    .done(function (response) {

      let tbody = $("#tablaMarca tbody");
      tbody.empty();

      let lista = Array.isArray(response) ? response : ['error al obtener los datos'];

      if (lista.length > 0) {
        let rowsHtml = "";

        $.each(lista, function (index, dato) {
          rowsHtml += `
            <tr>
              <td class="ps-4 text-center fw-bold text-secondary">${dato.nombre}</td>
              <td class="text-start pe-4">
                <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-editar" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalMarca"
                    datos-cod-marca="${dato.cod_marca}"
                    datos-nombre="${dato.nombre}"
                    datos-estado="${dato.estado}">
                  <i class="bi bi-pencil"></i>
                </button>
                <a href="#" class="text-secondary btn-eliminar"
                    datos-cod-marca="${dato.cod_marca}">
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

function ajaxEnvioDatos(modal, btnEnviar, cod_marca, nombre_marca) {

  let tipoSolicitud = "";
  if ($(btnEnviar).val() === "registrar" && $(btnEnviar).attr('name') === "tipoSolicitud") {
    tipoSolicitud = "registrar";
  } else if ($(btnEnviar).val() === "actualizar" && $(btnEnviar).attr('name') === "tipoSolicitud") {
    tipoSolicitud = "actualizar";
  }
  iconoCargar("#tablaMarca tbody");
  $.ajax({
    url: "index.php?url=marca",
    type: "POST",
    dataType: "json",
    data: {
      tipoSolicitud: tipoSolicitud,
      cod_marca: cod_marca,
      nombre_marca: nombre_marca
    },
    beforeSend: function () {
      modal.hide();
      $(btnEnviar).attr("disabled", true);

    }
  })
    .done(function (response) {
      console.log("Respuesta del servidor:", response);

      mostrarAlerta(response.status, response.message);
    })
    .fail(function (xhr, status, error) {
      console.error("Error al cargar los datos:", error);
      console.log("Respuesta cruda del servidor:", xhr.responseText);
    })
    .always(function () {
      // Opcional: Código que se ejecuta siempre al finalizar (éxito o error)
      ajaxConsultar();

    });

}

function AccionModal(boton) {
  const $encadezadoModal = $('#modalLabel');
  const $botonModal = $('button[name="tipoSolicitud"]');

  // Obtener los datos del vehículo desde los atributos datos- del botón (asumiendo que 'boton' es el elemento que disparó el evento, ej: $(this))
  const cod_marca = $(boton).attr('datos-cod-marca');
  const nombre = $(boton).attr('datos-nombre');
  const estado = $(boton).attr('datos-estado');

  // Obtener referencias a los campos del formulario dentro del modal
  const $inputCodMarca = $('#cod-marca');
  const $inputNombre = $('#nombre_marca');

  switch ($(boton).attr('title')) {
    case "Registrar":
      $encadezadoModal.html('<i class="bi bi-ev-front me-2"></i> Registro de Marca');
      $botonModal.val("registrar");
      $botonModal.html('<i class="bi bi-save"></i> Registrar');
      $inputCodMarca.val("");
      $inputNombre.val("");
      break;

    case "Actualizar":
      $encadezadoModal.html('<i class="bi bi-ev-front me-2"></i> Actualizacion de Marca');
      $botonModal.val("actualizar");
      $botonModal.html('<i class="bi bi-save"></i> Actualizar');

      if (cod_marca != "" && estado == 1) {
        // Asignar los valores obtenidos a los campos del formulario
        $inputCodMarca.val(cod_marca);
        $inputNombre.val(nombre);
      } else {
        $inputCodMarca.val("Error: Registro inactivo");
        $inputNombre.val("Error: Registro inactivo");
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
  setTimeout(() => {
    let title, text, icon;

    switch (status) {
      case 'success':
        title = "Registro exitoso!";
        text = mensaje;
        icon = "success";
        break;
      case 'updated':
        title = "Actualización exitosa!";
        text = mensaje;
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