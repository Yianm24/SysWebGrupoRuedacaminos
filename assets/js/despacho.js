$(document).ready(function () {
  const objDatatable = instanciarDatatableGlobal('#tablaDespacho');
  
  dibujarTabla(objDatatable);
  ajaxConsultarEnvios();
  limpiarInputModal();

  const modal = $('#modalDespacho');

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
      fechaSalida: $('#fecha_salida').val() + " " + $('#hora_salida').val()
    };
    

    ajaxEnvioDatosGlobal('despacho',solicitud,dibujarTabla,objDatatable,{'datosDespacho':datosDespacho, 'enviosSeleccionados':enviosSeleccionados},objModal,this)
    ajaxConsultarEnvios();
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
    $(this).attr('disabled', true); // Deshabilitar el botón para evitar múltiples clics

    $('#formularioRegistrar').removeClass('d-none');

    //Animación de scroll 
    $('html, body').animate({
      scrollTop: $("#formularioRegistrar").offset().top - 20
    }, 'fast');
  });

});

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
  })

}

function ajaxConsultarEnvios() {
  iconoCargar("#tablaEnviosPendientes tbody");
  $.ajax({
    url: "index.php?url=despacho",
    type: "POST",
    dataType: "json",
    data: {
      tipoSolicitud: "datos-foraneos"
    }
  })
    .done(function (response) {
      let datosEnvios = response.enviosPendientes;
      let choferes = response.choferes;
      let vehiculos = response.vehiculos;

      if (choferes.length > 0) {
        $.each(choferes, function (index, chofer) {
          $('#select_chofer').append(`<option value="${chofer.cod_empleado}">${chofer.nombreEmpleado} ${chofer.apellidoEmpleado}</option>`);
        })
      } else {
        $('#select_chofer').append(`<option value="">Sin choferes registrados</option>`);
      }

      if (vehiculos.length > 0) {
        $.each(vehiculos, function (index, vehiculo) {
          $('#select_vehiculo').append(`<option value="${vehiculo.cod_vehiculo}">${vehiculo.placaVehiculo}-${vehiculo.modeloVehiculo}</option>`);
        })
      } else {
        $('#select_vehiculo').append(`<option value="">Sin choferes registrados</option>`);
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
    })
    .fail(function (xhr, status, error) {
      console.error("Error al cargar los datos:", error);
      console.log("Respuesta cruda del servidor:", xhr.responseText);
    })

}

function ajaxEnvioDatos(solicitud, datos, codEnvios) {

  iconoCargar("#tablaEnviosPendientes tbody");
  $.ajax({
    url: 'index.php?url=despacho',
    type: "POST",
    dataType: "json",
    data: {
      tipoSolicitud: solicitud,
      datosDespacho: datos,
      envSeleccionados: codEnvios
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
      dibujarTabla(objDatatable);

    });

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
        text = mensaje;
        icon = "success";
        break;
      case 'updated':
        title = "Actualización exitosa!";
        text = "El Estado ha sido actualizado correctamente.";
        icon = "success";
        break;
      case 'deleted':
        title = "Eliminación exitosa!";
        text = mensaje;
        icon = "success";
        break;
      case 'exists':
        title = "Estado existente!";
        text = "El Estado ingresado ya existe en la base de datos.";
        icon = "warning";
        break;
      case 'empty':
        title = "Campos vacíos!";
        text = mensaje;
        icon = "warning";
        break;
      case 'error':
        title = "Error!";
        text = `Se produjo un error en el processo de ${mensaje}`;
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