$(document).ready(function () {
  const objDatatable = instanciarDatatableGlobal('#tablaModelo');
  dibujarTabla(objDatatable);
  const modal = $('#modalModelo');

  if (modal) {
    modal.on('show.bs.modal', event => {
      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;
      accionModal(boton);

    })
    $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
      event.preventDefault();
      const datos = {
        cod_modelo: $("#cod-modelo").val(),
        nombre_modelo: $("#nombre_modelo").val(),
        cod_marca: $('#marca').val()
      }

      const btnEnviar = this;
      const objModal = bootstrap.Modal.getInstance(modal) ?? '';
      ajaxEnvioDatosGlobal('modelo',$(this).val(),dibujarTabla,objDatatable,datos,objModal,btnEnviar);
    });
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
        ajaxEnvioDatosGlobal('modelo','eliminar',dibujarTabla,objDatatable,{cod_modelo:codmodelo},null,null);
      }
    });
  });

});

function dibujarTabla(objTabla) {
  const modulo = 'modelo';
  ajaxConsultarGlobal(modulo, (response) => {
    objTabla.clear();

    let lista = Array.isArray(response) ? response : [];

    if (lista.length > 0) {

      $.each(lista, function (index, dato) {
        const botones = `
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
        `;
        objTabla.row.add([
          dato.nombre,
          dato.nombre_marca,
          botones

        ])
      });
      objTabla.draw();
    } else {
      objTabla.row.add([
        'No se encontraron registros.',
        'No se encontraron registros.',
        'No se encontraron registros.'
        ])
        objTabla.draw()
    }
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