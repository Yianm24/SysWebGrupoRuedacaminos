document.addEventListener("DOMContentLoaded", function () {


ajaxConsultar();
  function ajaxConsultar(){
    $.ajax({
      url: "index.php?url=estado",
      type: "POST",
      dataType: "json",
      data: {
        tipoSolicitud: "consultar"
      },
      beforeSend: function() {
        console.log("Cargando estados...");
      },
      success: function(response) {
        let tbody = $("#tablaEstado tbody");
        console.log("Respuesta del servidor:", response);

        // 1. Limpiamos la tabla
        tbody.empty();

        // 2. Si el backend devuelve un array directo [{...}, {...}]
        // (O si viene dentro de una propiedad como response.datos, cambia 'lista' abajo)
        let lista = Array.isArray(response) ? response : ['error al obtener los datos'];

        if (lista.length > 0) {
          let rowsHtml = "";

          // 3. Recorremos únicamente el arreglo de registros
          $.each(lista, function(index, dato) {
            rowsHtml += `<tr>
                    <td class="ps-4 text-center fw-bold text-secondary">${dato.nombre}</td>
                    <td class="text-start pe-4">
                          
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
                    </td>
                </tr>
            `
            ;
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
      },
      error: function(xhr, status, error) {
        console.error("Error al cargar los datos:", error);
        console.log("Respuesta cruda del servidor:", xhr.responseText);
      }
    });

  }

  const modal = document.getElementById('modalEstado');


  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      const encabezadoModal = modal.querySelector('h1#modalLabel');
      const botonModal = document.querySelector('button[name="tipoSolicitud"]');

      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;

      //Obtener los datos del vehículo desde los atributos datos- del botón
      const cod_estado = boton.getAttribute('datos-cod-estado');
      const nombre = boton.getAttribute('datos-nombre');
      const estado = boton.getAttribute('datos-estado');

      // Obtener referencias a los campos del formulario dentro del modal
      const inputCodEstado = modal.querySelector('.modal-body #cod-estado')
      const inputNombre = modal.querySelector('.modal-body #nombre_estado')

      switch (boton.title) {
        case "Registrar":

          encabezadoModal.innerHTML = '<i class="bi bi-ev-front me-2"></i> Registro de Estado';
          botonModal.value = "registrar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
          inputCodEstado.value = "";
          inputNombre.value = "";
          break
        case "Actualizar":
          encabezadoModal.innerHTML = '<i class="bi bi-ev-front me-2"></i> Actualizacion de Estado';
          botonModal.value = "actualizar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Actualizar';

          if (cod_estado != "" && estado == 1) {
            // Asignar los valores obtenidos a los campos del formulario
            inputCodEstado.value = cod_estado;
            inputNombre.value = nombre;
          } else {
            inputCodEstado.value = "Error: Registro inactivo";
            inputNombre.value = "Error: Registro inactivo";
          }
          break
      }
    })
  }

  const botonesEliminar = document.querySelectorAll('.btn-eliminar');
  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', function (event) {
      event.preventDefault();
      let codestado = this.getAttribute('datos-cod-estado');

      const swalWithBootstrapButtons = Swal.mixin({
        customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
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
          form.action = '?url=estado';
          form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_estado" value="${codestado}">
                    `;
          document.body.appendChild(form);
          form.submit();
        }
      });
    });
  });

  // Lógica para mostrar alertas de estado (éxito, error, etc.)
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  const mensaje = urlParams.get('msg');

  if (status) {
    // Usamos un pequeño retraso para asegurar que la página esté completamente cargada
    setTimeout(() => {
      let title, text, icon;

      switch (status) {
        case 'success':
          title = "Registro exitoso!";
          text = "El Estado ha sido registrado correctamente.";
          icon = "success";
          break;
        case 'updated':
          title = "Actualización exitosa!";
          text = "El Estado ha sido actualizado correctamente.";
          icon = "success";
          break;
        case 'deleted':
          title = "Eliminación exitosa!";
          text = "El Estado ha sido eliminado correctamente.";
          icon = "success";
          break;
        case 'exists':
          title = "Estado existente!";
          text = "El Estado ingresado ya existe en la base de datos.";
          icon = "warning";
          break;
        case 'empty':
          title = "Campos vacíos!";
          text = "Uno o más campos están vacíos.";
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
});