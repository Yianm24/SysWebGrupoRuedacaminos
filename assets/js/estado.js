$(document).ready(function () {

  const miTabla = instanciarDatatableGlobal('#tablaEstado');

  dibujarTabla(miTabla);

  const modal = $('#modalEstado');

  if (modal) {
    modal.on('show.bs.modal', event => {

      const boton = event.relatedTarget;

      AccionModal(boton);
    })

    $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
      event.preventDefault();
      const datos = {
        cod_estado: $("#cod-estado").val(),
        nombre_estado: $("#nombre_estado").val()
      }

      const btnEnviar = this;

      const solicitud = $(this).val();

      const objmodal = bootstrap.Modal.getInstance(modal) ?? '';
      ajaxEnvioDatosGlobal('estado', solicitud, dibujarTabla, miTabla, datos, objmodal, btnEnviar);

    });
  }

  $("#tablaEstado tbody").on("click", ".btn-eliminar", function (event) {
    event.preventDefault();

    const codestado = this.getAttribute("datos-cod-estado");

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
        ajaxEnvioDatosGlobal('estado', 'eliminar', dibujarTabla, miTabla, { cod_estado: codestado }, null, null)
      }
    });
  });

})

//Dibuja los registros de la tabla
function dibujarTabla(objTable) {
  const modulo = 'estado';
  ajaxConsultarGlobal(modulo, (response) => {

    objTable.clear();

    let lista = Array.isArray(response) ? response : [];

    if (lista.length > 0) {
      $.each(lista, function (index, dato) {

        const botones = ` <td class="text-start pe-4">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalEstado"
                                 datos-cod-estado="${dato.cod_estado}"
                                 datos-nombre="${dato.nombre}"
                                 datos-estado="${dato.estado}"
                                 >
                                 <i class="bi bi-pencil"></i>
                             </button>
                         <a href="#" class="text-secondary btn-eliminar"
                                 datos-cod-estado="${dato.cod_estado}" >
                                 <i class="bi bi-trash"></i>
                         </a>
                     </td>`;

        objTable.row.add([
          dato.nombre,
          botones
        ])
      });
      objTable.draw();
    } else {
      objTable.row.add([
        'No se encontraron registros.',
        'No se encontraron registros.'
      ])
      objTable.draw();
    }
  })
}

function AccionModal(boton) {
  const encabezadoModal = $('#modalLabel');
  const botonModal = $('button[name="tipoSolicitud"]');

  //Obtener los datos del vehículo desde los atributos datos- del botón
  const cod_estado = $(boton).attr('datos-cod-estado');
  const nombre = $(boton).attr('datos-nombre');
  const estado = $(boton).attr('datos-estado');

  // Obtener referencias a los campos del formulario dentro del modal
  const inputCodEstado = $('#cod-estado')
  const inputNombre = $('#nombre_estado')

  switch ($(boton).attr('title')) {
    case "Registrar":

      encabezadoModal.html('<i class="bi bi-ev-front me-2"></i> Registro de Estado');
      botonModal.val("registrar");
      botonModal.html('<i class="bi bi-save"></i> Registrar');
      inputCodEstado.val("");
      inputNombre.val("");
      break

    case "Actualizar":
      encabezadoModal.html('<i class="bi bi-ev-front me-2"></i> Actualizacion de Estado');
      botonModal.val("actualizar");
      botonModal.html('<i class="bi bi-save"></i> Actualizar');

      if (cod_estado != "" && estado == 1) {
        // Asignar los valores obtenidos a los campos del formulario
        inputCodEstado.val(cod_estado);
        inputNombre.val(nombre);
      } else {
        inputCodEstado.val("Error: Registro inactivo");
        inputNombre.val("Error: Registro inactivo");
      }
      break
  }
}