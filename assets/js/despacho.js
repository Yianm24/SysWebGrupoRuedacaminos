$(document).ready(function () {
  ajaxConsultar();
  ajaxConsultarEnvios();
  // Mostrar el formulario al hacer clic en "Registrar"
  $('#botonRegistrar').on('click', function (e) {
    e.preventDefault();
    $(this).attr('disabled', true); // Deshabilitar el botón para evitar múltiples clics
    // Quitamos la clase que oculta el formulario
    $('#formularioRegistrar').removeClass('d-none');

    // (Opcional) Animación de scroll suave hacia el formulario para mejor experiencia UX
    $('html, body').animate({
      scrollTop: $("#formularioRegistrar").offset().top - 20
    }, 'fast');
  });

  // Ocultar el formulario al hacer clic en el botón "Cancelar" inferior
  $('#cancelarRegistro').on('click', function (e) {
    e.preventDefault();
    $('#botonRegistrar').attr('disabled', false); // Habilitar el botón nuevamente
    $('#formularioRegistrar').addClass('d-none');

    // (Opcional) Limpiar el formulario al cancelar
    $('#formularioDespacho')[0].reset();
  });

  // Ocultar el formulario al hacer clic en la "X" (btnCerrarForm) de la cabecera
  $('#btnCerrarForm').on('click', function (e) {
    e.preventDefault();
    $('#formularioRegistrar').addClass('d-none');
    $('#botonRegistrar').attr('disabled', false); // Habilitar el botón nuevamente
    // (Opcional) Limpiar el formulario al cerrar
    $('#formularioDespacho')[0].reset();
  });

 /*  $('#footerForm').on("click", "button[name='tipoSolicitud']", function (event) {
        event.preventDefault();
        const solicitud = $(this).val();
        let enviosSeleccionados = $('.check-envio:checked').map(function () {
        return $(this).val();
      }).get();

      let envSeleccionados = { codEnvios:enviosSeleccionados}
      let datosDespacho = {
        chofer: $('#select_chofer').val(),
        vehiculo: $('#select_vehiculo').val(),
        fechaSalida: $('#fecha_salida').val()+" "+$('#hora_salida').val()
      }

      ajaxEnvioDatos(solicitud,datosDespacho,envSeleccionados)

      });
 */

$('#footerForm').on("click", "button[name='tipoSolicitud']", function (event) {
    event.preventDefault();
    
    const solicitud = $(this).val().toLowerCase(); 
    
    let enviosSeleccionados = $('.check-envio:checked').map(function () {
        return $(this).val();
    }).get();

    let datosDespacho = {
        chofer: $('#select_chofer').val(),
        vehiculo: $('#select_vehiculo').val(),
        fechaSalida: $('#fecha_salida').val() + " " + $('#hora_salida').val()
    };

    if(!datosDespacho.chofer || !datosDespacho.vehiculo || $('#fecha_salida').val() === '' || $('#hora_salida').val() === ''){
        mostrarAlerta('empty', 'Debe seleccionar un chofer, un vehículo y una fecha/hora válida.');
        return;
    }
// Se pasa directamente el array
    ajaxEnvioDatos(solicitud, datosDespacho, enviosSeleccionados);
});

  // Lógica para mostrar alertas de estado (éxito, error, etc.)
 /*  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  const msg = urlParams.get('msg');

  if (status) {
    // Usamos un pequeño retraso para asegurar que la página esté completamente cargada
    setTimeout(() => {
      let title, text, icon;

      switch (status) {
        case 'success':
          title = "Registro exitoso!";
          text = "El Despacho ha sido registrado correctamente.";
          icon = "success";
          break;
        case 'updated':
          title = "Actualización exitosa!";
          text = "El Despacho ha sido actualizado correctamente.";
          icon = "success";
          break;
        case 'deleted':
          title = "Eliminación exitosa!";
          text = "El Despacho ha sido eliminado correctamente.";
          icon = "success";
          break;
        case 'exists':
          title = "Despacho existente!";
          text = "El Despacho ya existe en la base de datos.";
          icon = "warning";
          break;
        case 'bdError':
          title = "Despacho existente!";
          text = `Error en la base de datos.${msg}`;
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
  }*/

}); 

function ajaxConsultar() {
    iconoCargar("#tablaDespacho tbody");
    $.ajax({
        url: "index.php?url=despacho",
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: "consultar"
        }
    })
        .done(function (response) {

            let tbody = $("#tablaDespacho tbody");
            tbody.empty();

            let lista = Array.isArray(response) ? response : ['error al obtener los datos'];

            if (lista.length > 0) {
                let rowsHtml = "";

                $.each(lista, function (index, dato) {
                    rowsHtml += `
                        <tr class="align-middle">
                            <td class="ps-4 fw-semibold text-dark py-3">
                                ${dato.fecha_salida}
                            </td>
                            <td>
                                <span class="fw-medium">
                                ${dato.total_envios}
                                </span>
                            </td>
                            <td class="py-3">
                                ${dato.nombre_chofer} ${dato.apellido_chofer}
                            </td>
                            <td class="text-secondary py-3">
                            ${dato.placa_vehiculo} ${dato.modelo_vehiculo}
                            </td>
                            <td class="text-secondary fw-medium py-3">${dato.estatus}</td>
                        </tr>`;
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

function ajaxConsultarEnvios() {
  iconoCargar("#tablaEnviosPendientes tbody");
  $.ajax({
    url: "index.php?url=despacho",
    type: "POST",
    dataType: "json",
    data: {
      tipoSolicitud: "consultar-envios-pendientes"
    }
  })
    .done(function (response) {
      let datosEnvios = response.envios;
      let choferes = response.choferes;
      let vehiculos = response.vehiculos;

      if (choferes.length > 0){
        $.each(choferes, function (index, chofer) {
          $('#select_chofer').append(`<option value="${chofer.cod_empleado}">${chofer.nombre} ${chofer.apellido}</option>`);
        })
      }else {
        $('#select_chofer').append(`<option value="">Sin choferes registrados</option>`);
      }

      if (vehiculos.length > 0){
        $.each(vehiculos, function (index, vehiculo) {
          $('#select_vehiculo').append(`<option value="${vehiculo.cod_vehiculo}">${vehiculo.placa}-${vehiculo.nombremodelo}</option>`);
        })
      }else {
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

function ajaxEnvioDatos(solicitud, datos,codEnvios) {

    iconoCargar("#tablaEnviosPendientes tbody");
    $.ajax({
        url: 'index.php?url=despacho',
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: solicitud,
            datosDespacho: datos,
            envSeleccionados:codEnvios
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