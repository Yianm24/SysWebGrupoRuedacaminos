document.addEventListener("DOMContentLoaded", function () {

  ajaxConsultar();
  function ajaxConsultar(){
  /* $.ajax({
    url: "index.php?url=marca",
    type: "POST",
    dataType: "json",
    data:{
      tipoSolicitud: "consultar"
    },
    beforeSend: function(xhr) {
      console.log("Mensaje antes de cargar el ajax")
      
    },
    success: function(response, status, xhr) {
      let tbody = $("#tablaMarca tbody");
      console.log(response)
      console.log(response[1])
      /* const registros = JSON.parse(response);
      console.log(registros);  */
    
    // 1. Limpiamos la tabla para quitar datos viejos
    /*tbody.empty(); 

    // 2. Verificamos que la respuesta sea un array y tenga elementos
    if (response.success) {
      let rowsHtml = "";
      // 3. Recorremos los datos con $.each
      $.each(response, function(index, dato) {
        rowsHtml += `
      <tr>
          <td class="ps-4 text-center fw-bold text-secondary">${dato.nombre}</td>
          <td class="text-start pe-4">
              <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalMarca"
                  datos-cod-marca="${dato.cod_marca}"
                  datos-nombre="${dato.nombre}"
                  datos-estado="${dato.estado}"
                  >
                  <i class="bi bi-pencil"></i>
              </button>
              <a href="#" class="text-secondary btn-eliminar ms-2"
                  datos-cod-marca="${dato.cod_marca}" >
                  <i class="bi bi-trash"></i>
              </a>
          </td>
      </tr>
    `;
      });
      tbody.html(rowsHtml);
    } else {
      // Opcional: Mostrar un mensaje si la tabla está vacía
      let $trVacio = $("<tr></tr>").append(
        $("<td></td>")
          .attr("colspan", "2")
          .addClass("text-center text-muted py-3")
          .text("No se encontraron registros.")
      );
      tbody.append($trVacio);
    }
      
    },
    error: function(xhr, status, error) {
      console.error("Error al cargar los datos:", error);
    }
  }) */
 $.ajax({
  url: "index.php?url=marca",
  type: "POST",
  dataType: "json",
  data: {
    tipoSolicitud: "consultar"
  },
  beforeSend: function() {
    console.log("Cargando marcas...");
  },
  success: function(response) {
    let tbody = $("#tablaMarca tbody");
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
        rowsHtml += `
          <tr>
            <td class="ps-4 text-center fw-bold text-secondary">${dato.nombre}</td>
            <td class="text-start pe-4">
              <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-editar" 
                  title="Actualizar" 
                  data-bs-toggle="modal" 
                  data-bs-target="#modalMarca"
                  data-cod-marca="${dato.cod_marca}"
                  data-nombre="${dato.nombre}"
                  data-estado="${dato.estado}">
                <i class="bi bi-pencil"></i>
              </button>
              <a href="#" class="text-secondary btn-eliminar ms-2"
                  data-cod-marca="${dato.cod_marca}">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
        `;
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
  const modal = document.getElementById('modalMarca');


  if (modal) {
    modal.addEventListener('show.bs.modal', event => {
      const encabezadoModal = modal.querySelector('h1#modalLabel');
      const botonModal = document.querySelector('button[name="tipoSolicitud"]');

      // Obtener acceso al botón que disparó el modal
      const boton = event.relatedTarget;

      //Obtener los datos del vehículo desde los atributos datos- del botón
      const cod_marca = boton.getAttribute('datos-cod-marca');
      const nombre = boton.getAttribute('datos-nombre');
      const estado = boton.getAttribute('datos-estado');

      // Obtener referencias a los campos del formulario dentro del modal
      const inputCodMarca = modal.querySelector('.modal-body #cod-marca')
      const inputNombre = modal.querySelector('.modal-body #nombre_marca')

      switch (boton.title) {
        case "Registrar":

          encabezadoModal.innerHTML = '<i class="bi bi-ev-front me-2"></i> Registro de Marca';
          botonModal.value = "registrar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
          inputCodMarca.value = "";
          inputNombre.value = "";
          break
        case "Actualizar":
          encabezadoModal.innerHTML = '<i class="bi bi-ev-front me-2"></i> Actualizacion de Marca';
          botonModal.value = "actualizar";
          botonModal.innerHTML = '<i class="bi bi-save"></i> Actualizar';

          if (cod_marca != "" && estado == 1) {
            // Asignar los valores obtenidos a los campos del formulario
            inputCodMarca.value = cod_marca;
            inputNombre.value = nombre;
          } else {
            inputCodMarca.value = "Error: Registro inactivo";
            inputNombre.value = "Error: Registro inactivo";
          }
          break
      };
    });
  };

  const botonesEliminar = document.querySelectorAll('.btn-eliminar');
  botonesEliminar.forEach(boton => {
    boton.addEventListener('click', function (event) {
      event.preventDefault();
      let codmarca = this.getAttribute('datos-cod-marca');

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
          form.action = '?url=marca';
          form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_marca" value="${codmarca}">
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
          text = "La Marca ha sido registrada correctamente.";
          icon = "success";
          break;
        case 'updated':
          title = "Actualización exitosa!";
          text = "La Marca ha sido actualizada correctamente.";
          icon = "success";
          break;
        case 'deleted':
          title = "Eliminación exitosa!";
          text = "La Marca ha sido eliminada correctamente.";
          icon = "success";
          break;
        case 'exists':
          title = "Marca existente!";
          text = "La Marca ingresada ya existe en la base de datos.";
          icon = "warning";
          break;
        case 'empty':
          title = "Campos vacíos!";
          text = "Uno o más campos están vacíos.";
          icon = "warning";
          break;
        case 'error':
          title = "Error!";
          text = `Se produjo un error en el proceso de ${mensaje}.`;
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