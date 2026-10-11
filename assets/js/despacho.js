document.addEventListener("DOMContentLoaded", function () {

  const modal = document.getElementById('modalDespacho');

  const selectVehiculo = document.querySelectorAll("td select[name='select_vehiculo']");

  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      const encabezadoModal = modal.querySelector('h1#modalLabel');
      const botonModal = document.querySelector('button[name="tipoSolicitud"]');
      const botonSiguiente = document.getElementById('btn_siguiente');
      const tbodyDespachos = document.querySelector('#tabla_Despacho tbody');


      botonSiguiente.addEventListener('click', function (event) {
        event.preventDefault();
        tbodyDespachos.innerHTML = ''; // Limpiar despacho
        const filasTablaVehiculoFecha = document.querySelectorAll('#tabla_vehiculo_fecha tbody tr');

        let arrayDespachos = [];

        filasTablaVehiculoFecha.forEach(fila => {
          // CAMBIO: Capturamos el código desde el input oculto en lugar del texto
          const cod_envio = fila.querySelector('input[name="cod_envio"]').value;
          //const texto_vehiculo = fila.querySelector('input[name="cod_vehiculo"]');
          const cod_vehiculo= fila.querySelector('select[name="select_vehiculo"]').value;
          const fecha = fila.querySelector('input[name="fecha"]').value;

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
              //placamarca:texto_vehiculo,
              fecha: fecha,
              codigos: [cod_envio] // Iniciamos el array con el primer código
            });
          }
        });

        arrayDespachos.forEach(grupo => {
          const filasDespacho = document.createElement('tr');

          filasDespacho.innerHTML = `
              <td class="ps-4 fw-medium">
                          <input ${grupo.vehiculo ? `value="${grupo.vehiculo}"` : 'VACIO'} name="vehiculo_asignado[]" 
                          readonly></input>
                      </td>
                  <td class="text-center align-middle">
                      <input type="date" class="form-control" name="fecha_establecida" value="${grupo.fecha}" readonly>
                  </td>
                  <td class="text-center align-middle">
                      <select class="form-select form-select-sm" aria-label="Seleccionar Empleado" name="cod_empleado" required>
                          <option selected>Empleados</option>
                          <?php if (!empty($datosForaneos['empleado'])): ?>
                              <?php foreach ($datosForaneos['empleado'] as $empleado): ?>
                                  <option value="<?= $empleado['cod_empleado']; ?>"><?php echo $empleado['nombre'] . ' ' . $empleado['apellido']; ?></option>
                              <?php endforeach; ?>
                          <?php else: ?>
                              <option value="">No hay empleados con el cargo especificado</option>
                          <?php endif; ?>
                      </select>
                  </td>
                 
          `;

          tbodyDespachos.appendChild(filasDespacho);
        });

        console.log("Array agrupado generado:", arrayDespachos);

      });



      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;

      switch (boton.title) {
        case "Registrar":

          encabezadoModal.innerHTML = '<i class="bi bi-boxes me-2"> Registro Despacho';
          botonModal.value = "registrar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
          break
      };
    });
  };

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