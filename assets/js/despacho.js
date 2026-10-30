document.addEventListener("DOMContentLoaded", function () {
  $('#botonRegistrar').on('click', function() {
        $(this).prop('disabled', true);

        $('#formularioRegistrar').removeClass('d-none').hide().fadeIn(500);
    });

    // Ocultar contenedor y habilitar nuevamente #botonRegistrar
    $('#cancelarRegistro').on('click', function() {
        $('#formularioRegistrar').fadeOut(500, function() {
            $(this).addClass('d-none');
            $('#botonRegistrar').prop('disabled', false);
        });
    });

  
  const selectVehiculo = document.querySelectorAll("td select[name='select_vehiculo']");

      const botonSiguiente = document.getElementById('btn_siguiente');
      const tbodyDespachos = document.querySelector('#tabla_Despacho tbody');


      botonSiguiente.addEventListener('click', function (event) {
        event.preventDefault();
        tbodyDespachos.innerHTML = ''; // Limpiar despacho
        const filasTablaVehiculoFecha = document.querySelectorAll('#tabla_vehiculo_fecha tbody tr');

        let arrayDespachos = [];

        filasTablaVehiculoFecha.forEach(fila => {
          const selectInput = fila.querySelector('select[name="select_vehiculo"]');
          //El código es capturado desde el input oculto en lugar del texto
          const cod_envio = fila.querySelector('input[name="cod_envio"]').value;
          
          const cod_vehiculo = selectInput.value;
          const texto_vehiculo = selectInput.options[selectInput.selectedIndex].text;
          const fecha = fila.querySelector('input[name="fechaSalida"]').value;
          const hora = fila.querySelector('input[name="horaSalida"]').value;

          // Omitir si la fila no tiene vehículo o fecha asignada
          if (!cod_vehiculo || !fecha) return;

          // Buscamos si ya existe esta combinación (vehículo + fecha) en nuestro array
          let grupoDespachos = arrayDespachos.find(
            grupo => grupo.vehiculo === cod_vehiculo && grupo.fecha === fecha
          );

          if (grupoDespachos) {
            // Si ya existe, agregamos el código de envío a este grupo
            grupoDespachos.codigos.push(cod_envio);
          } else {
            // Si no existe, creamos un nuevo objeto en el array
            arrayDespachos.push({
              vehiculo: cod_vehiculo, // Guardamos tanto el nombre como el código del vehículo
              placamarca:texto_vehiculo,
              fecha: fecha,
              hora: hora,
              codigos: [cod_envio] // Iniciamos el array con el primer código
            });
          }
        });

        arrayDespachos.forEach(grupo => {
          const filasDespacho = document.createElement('tr');

          filasDespacho.innerHTML = `
              <td class="ps-4 fw-medium">
                          <input type="hidden" value=${grupo.vehiculo ? `"${grupo.vehiculo}"` : "VACIO"} name="vehiculo_asignado[]">
                          <input value=${grupo.placamarca ? `"${grupo.placamarca}"` : "VACIO"} name="vehiculo_asignado[]" 
                          readonly>
                      </td>
                  <td class="text-center align-middle">
                  <div class="input-group d-inline-flex justify-content-center w-auto mx-auto">
                      <input type="date" class="form-control" name="fechaDespacho" value="${grupo.fecha}" readonly>
                      <input type="time" class="form-control" name="horaDespacho" value="${grupo.hora}" readonly>
                      </div>
                  </td>
                  <td class="text-center align-middle">
                      <button type="button" class="btn btn-outline-secondary" title="Choferes" data-bs-toggle="modal" data-bs-target="#modalChofer">
                        Seleccionar Chofer
                    </button>
                  </td>
                 
          `;

          tbodyDespachos.appendChild(filasDespacho);
        });

        console.log("Array agrupado generado:", arrayDespachos);

      });  

// Lógica para mostrar alertas de estado (éxito, error, etc.)
  const urlParams = new URLSearchParams(window.location.search);
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
  }

});