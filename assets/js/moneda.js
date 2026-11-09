document.addEventListener("DOMContentLoaded", function () {

    ajaxConsultar();
    function ajaxConsultar() {
        $.ajax({
            url: "index.php?url=moneda",
            type: "POST",
            dataType: "json",
            data: {
                tipoSolicitud: "consultar"
            },
            beforeSend: function () {
                console.log("Cargando monedas...");
            },
            success: function (response) {
                let tbody = $("#tablaMoneda tbody");
                console.log("Respuesta del servidor:", response);

                // 1. Limpiamos la tabla
                tbody.empty();

                // 2. Si el backend devuelve un array directo [{...}, {...}]
                // (O si viene dentro de una propiedad como response.datos, cambia 'lista' abajo)
                let lista = Array.isArray(response) ? response : ['error al obtener los datos'];

                if (lista.length > 0) {
                    let rowsHtml = "";

                    // 3. Recorremos únicamente el arreglo de registros
                    $.each(lista, function (index, dato) {
                        rowsHtml +=
                            `<tr>
                        <td class="ps-4 fw-bold text-secondary">${dato.abreviatura}</td>
                        <td>${dato.nombre}</td>
                        <td class="text-end pe-4">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Modificar" data-bs-toggle="modal" data-bs-target="#modalMoneda"
                                datos-cod-moneda="${dato.cod_moneda}"
                                datos-nombre="${dato.nombre}"
                                datos-abreviatura="${dato.abreviatura}"
                                datos-estado="${dato.estado}">

                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="#" class="text-secondary btn-eliminar"
                                datos-cod-moneda="${dato.cod_moneda}">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>`
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
            error: function (xhr, status, error) {
                console.error("Error al cargar los datos:", error);
                console.log("Respuesta cruda del servidor:", xhr.responseText);
            }
        });

    }


    const modal = document.getElementById('modalMoneda');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            const encabezadoModal = modal.querySelector('h1#modalLabel');
            const botonModal = document.querySelector('button[name="tipoSolicitud"]');
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_moneda = boton.getAttribute('datos-cod-moneda');
            const nombre = boton.getAttribute('datos-nombre');
            const abreviatura = boton.getAttribute('datos-abreviatura');
            const estado = boton.getAttribute('datos-estado');
            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodMoneda = modal.querySelector('.modal-body #cod-moneda')
            const inputNombre = modal.querySelector('.modal-body #nombre')
            const inputAbreviatura = modal.querySelector('.modal-body #abreviatura')

            switch (boton.title) {
                case "Registrar":
                    encabezadoModal.innerHTML = '<i class="bi bi-coin"></i> Registro de Moneda';
                    botonModal.value = "registrar";
                    botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
                    inputCodMoneda.value = "";
                    inputNombre.value = "";
                    inputAbreviatura.value = "";
                    break;
                case "Modificar":

                    encabezadoModal.innerHTML = '<i class="bi bi-coin"></i> Modificación de Moneda';
                    botonModal.value = "modificar";
                    botonModal.innerHTML = '<i class="bi bi-pencil"></i> Modificar';


                    if (cod_moneda != "" && estado == 1) {
                        // Asignar los valores obtenidos a los campos del formulario
                        inputCodMoneda.value = cod_moneda;
                        inputNombre.value = nombre;
                        inputAbreviatura.value = abreviatura;
                    } else {
                        inputCodMoneda.value = "Error: Registro inactivo";
                        inputNombre.value = "Error: Registro inactivo";
                        inputAbreviatura.value = "Error: Registro inactivo";
                    }


                    break;

            }
            // Asignar los valores obtenidos a los campos del formulario

        })
    }


    $("#tablaMoneda tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();

        const codmoneda = this.getAttribute("datos-cod-moneda");

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
                form.action = '?url=moneda';
                form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_moneda" value="${codmoneda}">
                    `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
// Lógica para mostrar alertas de estado (éxito, error, etc.)
const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('status');

if (status) {
    // Usamos un pequeño retraso para asegurar que la página esté completamente cargada
    setTimeout(() => {
        let title, text, icon;

        switch (status) {
            case 'success':
                title = "Registro exitoso!";
                text = "La moneda ha sido registrada correctamente.";
                icon = "success";
                break;
            case 'updated':
                title = "Actualización exitosa!";
                text = "La moneda ha sido actualizada correctamente.";
                icon = "success";
                break;
            case 'deleted':
                title = "Eliminación exitosa!";
                text = "La moneda ha sido eliminada correctamente.";
                icon = "success";
                break;
            case 'exists':
                title = "Moneda existente!";
                text = "La moneda ingresada ya existe en la base de datos.";
                icon = "warning";
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
