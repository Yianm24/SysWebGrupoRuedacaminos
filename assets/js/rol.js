$(document).ready(function () {
    ajaxConsultar();
    const modal = $('#modalRol');
    console.log(modal);

    if (modal) {
        modal.on('show.bs.modal', event => {

            const boton = event.relatedTarget;

            AccionModal(boton);
        })

        $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
            event.preventDefault();
            const datos = {
                cod_rol: $("#cod-rol").val(),
                nombre_rol: $("#nombre").val()
            }

            const btnEnviar = this;

            let solicitud = "";
            if ($(btnEnviar).val() === "registrar" && $(btnEnviar).attr('name') === "tipoSolicitud") {
                solicitud = "registrar";
            } else if ($(btnEnviar).val() === "actualizar" && $(btnEnviar).attr('name') === "tipoSolicitud") {
                solicitud = "actualizar";
            } else {
                solicitud = "eliminar";
            }

            const objmodal = bootstrap.Modal.getInstance(modal) ?? '';
            ajaxEnvioDatos(objmodal, btnEnviar, solicitud, datos);

        });
    }

    $("#tablaRol tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();

        const codrol = this.getAttribute("datos-cod-rol");

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
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '?url=rol';
                form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_rol" value="${codrol}">
                    `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });


    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const mensaje = urlParams.get('msg');


    if (status) {
        mostrarAlerta(status, mensaje)
    }
});

function ajaxConsultar() {
    iconoCargar("#tablaRol tbody");

    $.ajax({
        url: "index.php?url=rol",
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: "consultar"
        },
        beforeSend: function () {
            console.log("Cargando roles...");
        },
        success: function (response) {
            let tbody = $("#tablaRol tbody");
            console.log("Respuesta del servidor:", response);

            tbody.empty();

            let lista = Array.isArray(response) ? response : ['error al obtener los datos'];

            if (lista.length > 0) {
                let rowsHtml = "";

                $.each(lista, function (index, dato) {
                    rowsHtml += `<tr>
                    <td class="ps-4 text-center fw-bold text-secondary">${dato.nombre}</td>
                    <td class="text-end pe-4">     
                    <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalRol"
                                datos-cod-rol="${dato.cod_rol}"
                                datos-nombre="${dato.nombre}"
                                datos-estado="${dato.estado}"
                                >
                                <i class="bi bi-pencil"></i>
                            </button>
                        <a href="#" class="text-secondary btn-eliminar"
                                datos-cod-rol="${dato.cod_rol}" >
                                <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            `});

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
        error: function (xhr, status, error) {
            console.error("Error al cargar los datos:", error);
            console.log("Respuesta cruda del servidor:", xhr.responseText);
        }
    });

}

function ajaxEnvioDatos(modal = null, btnEnviar, solicitud, datos) {

    iconoCargar("#tablaRol tbody");
    $.ajax({
        url: "index.php?url=rol",
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: solicitud,
            datos: datos
            // nombre_estado: nombre_estado
        },
        beforeSend: function () {
            if (modal != null) {
                modal.hide();
                $(btnEnviar).attr("disabled", true);
            }
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

function AccionModal(boton) {
    const encabezadoModal = $('#modalLabel');
    const botonModal = $('button[name="tipoSolicitud"]');

    const cod_rol = $(boton).attr('datos-cod-rol');
    const nombre = $(boton).attr('datos-nombre');
    const estado = $(boton).attr('datos-estado');

    // Obtener referencias a los campos del formulario dentro del modal
    const inputCodRol = $('#cod-rol')
    const inputNombre = $('#nombre')


    console.log($('#modalLabel'));

    switch ($(boton).attr('title')) {
        case "Registrar":

            encabezadoModal.html('<i class="bi bi-person-badge me-2"></i> Registrar Rol');
            botonModal.val("registrar");
            botonModal.html('<i class="bi bi-save"></i> Registrar');
            inputCodRol.val("");
            inputNombre.val("");
            break

        case "Actualizar":
            encabezadoModal.html('<i class="bi bi-person-badge me-2"></i> Actualizaciar Rol');
            botonModal.val("actualizar");
            botonModal.html('<i class="bi bi-save"></i> Actualizar');

            if (cod_rol != "" && estado == 1) {
                // Asignar los valores obtenidos a los campos del formulario
                inputCodRol.val(cod_rol);
                inputNombre.val(nombre);
            } else {
                inputCodRol.val("Error: Registro inactivo");
                inputNombre.val("Error: Registro inactivo");
            }
            break
    }
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