$(document).ready(function () {
  const objDatatable = instanciarDatatableGlobal('#tablaMarca');
  //ajaxEnvioDatos("#tablaMarca tbody", "marca", "consultar", html, null, null, null);
  dibujarTabla(objDatatable);
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
      const objModal = bootstrap.Modal.getInstance(modal) ?? ''; 

      ajaxEnvioDatosGlobal('marca',$(this).val(),dibujarTabla,objDatatable,datos,objModal,btnEnviar);
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
        ajaxEnvioDatosGlobal('marca','eliminar',dibujarTabla,objDatatable,{cod_marca:codmarca},null,null);
      }
    });
  });
});

//Dibuja los registros de la tabla
function dibujarTabla(objTable) {
  const modulo = 'marca';
  ajaxConsultarGlobal(modulo, (response) => {

    objTable.clear();

    let lista = Array.isArray(response) ? response : [];

    if (lista.length > 0) {
      $.each(lista, function (index, dato) {


        const botones = `
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
        `;

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