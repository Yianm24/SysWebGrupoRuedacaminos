$(document).ready(function () {
  const objDatatable = instanciarDatatableGlobal('#tablaDespacho');

  dibujarTabla(objDatatable);
  //ajaxConsultarEnvios();
  limpiarInputModal();

  const modal = $('#modalDespacho');

  modal.on('show.bs.modal', event => {
    // Obtener acceso al botón que disparó el modal
    const boton = event.relatedTarget;
    AccionModal(boton);

  });

  $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
    event.preventDefault();

    const objModal = bootstrap.Modal.getInstance(modal) ?? '';
    const solicitud = $(this).val();

    let enviosSeleccionados = $('.check-envio:checked').map(function () {
      return $(this).val();
    }).get();

    let datosDespacho = {
      chofer: $('#select_chofer').val(),
      vehiculo: $('#select_vehiculo').val(),
      fechaSalida: $('#fecha_salida').val(),
      horaSalida: $('#hora_salida').val()
    };

    ajaxEnvioDatosGlobal('despacho', solicitud, dibujarTabla, objDatatable, { 'datosDespacho': datosDespacho, 'enviosSeleccionados': enviosSeleccionados }, objModal, this)
    datosForaneos();
  });

  $("#modalDespacho").on("input change", "#fecha_salida, #hora_salida, #select_vehiculo, #select_chofer, .check-envio, #check_todos_head", function () {
    const fechaSalida = ($("#fecha_salida").val() || "").trim();
    const horaSalida = ($("#hora_salida").val() || "").trim();
    const vehiculo = $("#select_vehiculo").val();
    const chofer = $("#select_chofer").val();
    const enviosMarcados = $(".check-envio:checked").length > 0;

    const valoresInput = Boolean(
      fechaSalida !== "" &&
      horaSalida !== "" &&
      vehiculo && vehiculo != 0 &&
      chofer && chofer != 0 &&
      enviosMarcados
    );

    const $btnRegistrar = $('button[name="tipoSolicitud"]');
    $btnRegistrar.prop("disabled", !valoresInput);
    $btnRegistrar.toggleClass("disabled", !valoresInput);
  });

  $("#modalDespacho").on("hidden.bs.modal", function () {
    limpiarInputModal();
  });

  $('#botonRegistrar').on('click', function (e) {
    e.preventDefault();
    $(this).prop('disabled', true); // Deshabilitar el botón para evitar múltiples clics

    $('#formularioRegistrar').removeClass('d-none');

    //Animación de scroll 
    $('html, body').animate({
      scrollTop: $("#formularioRegistrar").offset().top - 20
    }, 'fast');
  });

  $("#tablaDespacho tbody").on("click", ".btn-eliminar", function (event) {
    event.preventDefault();

    const coddespacho = this.getAttribute("datos-cod-despacho");

    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success ms-2",
        cancelButton: "btn btn-danger"
      },
      buttonsStyling: false
    });

    Swal.fire({
      title: "¿Anular este despacho?",
      html: `Al anular el despacho <strong>DCH-${String(coddespacho)}</strong>, todos los envíos contenidos serán <strong>liberados y devueltos a estatus PENDIENTE</strong> para ser asignados a otra ruta.<br><br><em>Esta acción no eliminará los registros de los envíos.</em>`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "<i class='bi bi-trash me-1'></i> Confirmar Anulación",
      cancelButtonText: "Cancelar",
      customClass: { confirmButton: "btn btn-danger ms-2", cancelButton: "btn btn-secondary" },
      buttonsStyling: false,
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        ajaxEnvioDatosGlobal('despacho', 'eliminar', dibujarTabla, objDatatable, { cod_despacho: coddespacho }, null, null);
      }
    });
  });

});

function AccionModal(boton) {
  const encadezadoModal = $('#modalLabel');
  const botonModal = $('button[name="tipoSolicitud"]');
  const btn = $(boton);

  const cod_despacho = (btn.attr('datos-cod-despacho') || '').trim();
  const cod_empleado = (btn.attr('datos-cod-empleado') || '').trim();
  const cod_vehiculo = (btn.attr('datos-cod-vehiculo') || '').trim();
  const fecha_salida = (btn.attr('datos-fecha-salida') || '').trim();
  const hora_salida = (btn.attr('datos-hora-salida') || '').trim();

  const inputCodDespacho = $('#cod_despacho');
  const selectChofer = $('#select_chofer');
  const selectVehiculo = $('#select_vehiculo');
  const inputFecha = $('#fecha_salida');
  const inputHora = $('#hora_salida');

  switch (btn.attr('title')) {
    case "Registrar":
      encadezadoModal.html('<i class="bi bi-boxes me-2"></i> Programar Nuevo Despacho y Carga');
      botonModal.val("registrar");
      botonModal.html('<i class="bi bi-save me-1"></i> Registrar');
      inputCodDespacho.val('');
      break;

    case "Modificar":
      encadezadoModal.html('<i class="bi bi-boxes me-2"></i> Modificación de Despacho');
      botonModal.val("modificar");
      botonModal.html('<i class="bi bi-save me-1"></i> Modificar');

      if (cod_despacho !== "") {
        const horaFormateada = hora_salida.length >= 5 ? hora_salida.substring(0, 5) : hora_salida;

        inputCodDespacho.val(cod_despacho);
        selectChofer.val(cod_empleado);
        selectVehiculo.val(cod_vehiculo);
        inputFecha.val(fecha_salida);
        inputHora.val(horaFormateada);

        selectChofer.trigger('change');
      } else {
        inputCodDespacho.val('');
        selectChofer.val('0');
        selectVehiculo.val('0');
        inputFecha.val('');
        inputHora.val('');
      }
      break;
  }
}

function limpiarInputModal() {
  const modal = $("#modalDespacho");

  modal.find("#select_chofer, #select_vehiculo").val("0");
  modal.find("#fecha_salida, #hora_salida").val("");
  modal.find('input[type="checkbox"]').prop("checked", false);

  modal.find('button[name="tipoSolicitud"]')
    .prop("disabled", true)
    .addClass("disabled");
}

function dibujarTabla(objTable) {
  const modulo = 'despacho';
  ajaxConsultarGlobal(modulo, (response) => {

    objTable.clear();

    let despachos = Array.isArray(response.despachos) ? response.despachos : [];

    if (despachos.length > 0) {
      $.each(despachos, function (index, dato) {


        const botones = `
        <button type="button" id="btn-modificar" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-editar" title="Modificar" data-bs-toggle="modal" data-bs-target="#modalDespacho"
        datos-cod-despacho="${dato.cod_despacho}",
        datos-fecha-salida="${dato.fecha_salida}",
        datos-hora-salida="${dato.hora_salida}",
        datos-cod-empleado="${dato.cod_empleado}",
        datos-cod-vehiculo="${dato.cod_vehiculo}">
          <i class="bi bi-pencil"></i>
        </button>
        <a href="#" class="text-secondary btn-eliminar"
        datos-cod-despacho="${dato.cod_despacho}">
          <i class="bi bi-trash"></i>
        </a>
        `;

        objTable.row.add([
          "<strong>DCH-" + dato.cod_despacho + "</strong>",
          dato.fecha_salida,
          dato.total_envios,
          dato.nombre_chofer + dato.apellido_chofer,
          dato.placa_vehiculo + dato.modelo_vehiculo,
          dato.estatus,
          botones
        ])
      });
      objTable.draw();
    }

    datosForaneos(response);
  })

}

function datosForaneos(response) {
  iconoCargar('#tablaEnviosPendientes tbody');

  const selectChofer = $('#select_chofer');
  const selectVehiculo = $('#select_vehiculo');

  selectChofer.find('option:not([value="0"])').remove();
  selectVehiculo.find('option:not([value="0"])').remove();

  let datosEnvios = response.enviosPendientes;
  let choferes = response.choferes;
  let vehiculos = response.vehiculos;

  if (choferes.length > 0) {
    $.each(choferes, function (index, chofer) {
      $(selectChofer).append(`<option value="${chofer.cod_empleado}">${chofer.nombreEmpleado} ${chofer.apellidoEmpleado}</option>`);
    })
  } else {
    $(selectChofer).append(`<option value="">Sin choferes registrados</option>`);
  }

  if (vehiculos.length > 0) {
    $.each(vehiculos, function (index, vehiculo) {
      $(selectVehiculo).append(`<option value="${vehiculo.cod_vehiculo}">${vehiculo.placaVehiculo}-${vehiculo.modeloVehiculo}</option>`);
    })
  } else {
    $(selectVehiculo).append(`<option value="">Sin choferes registrados</option>`);
  }

  let tbody = $("#tablaEnviosPendientes tbody");

  tbody.empty();

  if (datosEnvios.length > 0) {
    let rowsHtml = "";

    $.each(datosEnvios, function (index, dato) {
      rowsHtml += `
             <tr class="align-middle fila-envio-disponible">
                <td class="ps-3">
                    <input class="form-check-input check-envio" type="checkbox"
                        name="envios_seleccionados[]"
                        value="${dato.cod_envio}">
                </td>
                <td class="fw-medium text-dark">
                     ${dato.cod_envio}
                </td>
                <td class="fw-medium text-dark">
                     ${dato.dest_nombre} ${dato.dest_apellido}
                </td>
                <td>
                        <span class="fw-small text-dark"><i class="bi bi-geo-alt text-danger me-1"></i>${dato.estado_destino}-${dato.municipio_destino}</span>
                        <div class="text-muted small">${dato.direccion_destino}</div>
                </td>
                <td class="text-secondary small" style="max-width: 180px;">
                    <div class="text-truncate" title="${dato.descrip_contenido}">
                        ${dato.descrip_contenido}
                    </div>
                </td>
                <td class="text-center fw-bold text-dark">
                    ${dato.peso_total} kg
                </td>
            </tr>
          `;
    });

    tbody.html(rowsHtml);
  } else {
    tbody.html(`
    <tr>
        <td colspan="7" class="text-center py-4 text-muted">
            <i class="bi bi-inbox fs-3 d-block mb-1 text-secondary"></i>
            No hay envíos pendientes por despachar.
        </td>
    </tr>
  `);
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