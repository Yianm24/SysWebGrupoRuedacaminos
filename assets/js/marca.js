$(document).ready(function () {

  ajaxEnvioDatos("#tablaMarca tbody", "marca", "consultar", html, null, null, null);

  const modal = $('#modalMarca');

  if (modal) {
    modal.on('show.bs.modal', event => {
      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;
      AccionModal(boton, modal);

    });
    $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
      event.preventDefault();
      const datos ={
        cod_marca: $("#cod-marca").val(),
        nombre_marca: $("#nombre_marca").val()
      }
      
      const btnEnviar = this;
      const objmodal = bootstrap.Modal.getInstance(modal) ?? '';
      //ajaxEnvioDatos(objmodal, btnEnviar, datos);
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
        ajaxEnvioDatos(null,null, { cod_marca: codmarca});
      }
    });
  });
});

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