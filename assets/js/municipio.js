document.addEventListener("DOMContentLoaded", function () {

    const inputBusqueda = document.getElementById('inputBusqueda');
    if (inputBusqueda) {
        inputBusqueda.addEventListener('input', function () {
            const textoBuscado = this.value.toLowerCase();
            const filas = document.querySelectorAll("table tbody tr");
            filas.forEach(fila => {
                const contenidoFila = fila.textContent.toLowerCase();
                fila.style.display = contenidoFila.includes(textoBuscado) ? "" : "none";
            });
        });
    }

    const modal = document.getElementById('modalMunicipio');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            const encabezadoModal = modal.querySelector('h1#modalLabel');
            const botonModal = document.querySelector('button[name="tipoSolicitud"]');

            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const codmunicipio = boton.getAttribute('datos-cod-municipio');
            const nombre = boton.getAttribute('datos-nombre');
            const codestado = boton.getAttribute('datos-cod-estado');
            const estado = boton.getAttribute('datos-estado');

            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodMunicipio = modal.querySelector('.modal-body #cod-municipio');
            const inputNombre = modal.querySelector('.modal-body #nombre_municipio');
            const inputCodEstado = modal.querySelector('.modal-body #cod-estado');

            switch (boton.title) {
                case "Registrar":
                    const selectEstado = document.querySelector('.modal-body #cod-estado');

                    encabezadoModal.innerHTML = '<i class="bi bi-car-front me-2"></i> Registro de Municipio';
                    botonModal.value = "registrar";
                    botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
                    inputCodMunicipio.value = "";
                    inputNombre.value = "";
                    inputCodEstado.value = "";
                    selectEstado.selectedIndex = 0;


                    break;

                case "Actualizar":
                    encabezadoModal.innerHTML = '<i class="bi bi-car-front me-2"></i> Actualizacion de Municipio';
                    botonModal.value = "actualizar";
                    botonModal.innerHTML = '<i class="bi bi-pencil"></i> Actualizar';

                    if (codmunicipio != "" && estado == 1) {
                        // Asignar los valores obtenidos a los campos del formulario
                        inputCodMunicipio.value = codmunicipio;
                        inputNombre.value = nombre;
                        inputCodEstado.value = codestado;
                    } else {
                        inputCodMunicipio.value = "Error: Registro inactivo";
                        inputNombre.value = "Error: Registro inactivo";
                        inputCodEstado.value = "Error: Registro inactivo";
                    }

                    break;
            }

        })
    }

    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function (event) {
            event.preventDefault();
            let codmunicipio = this.getAttribute('datos-cod-municipio');

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
                    form.action = '?url=municipio';
                    form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_municipio" value="${codmunicipio}">
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

    if (status) {
        // Usamos un pequeño retraso para asegurar que la página esté completamente cargada
        setTimeout(() => {
            let title, text, icon;

            switch (status) {
                case 'success':
                    title = "Registro exitoso!";
                    text = "El Municipio ha sido registrado correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "El Municipio ha sido actualizado correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "El Municipio ha sido eliminado correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Municipio existente!";
                    text = "El Municipio ingresado ya existe en la base de datos.";
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