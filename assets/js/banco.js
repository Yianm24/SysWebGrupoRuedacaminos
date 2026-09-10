document.addEventListener("DOMContentLoaded", function () {
    
    const inputBusqueda = document.getElementById('inputBusqueda');
    if (inputBusqueda) {
        inputBusqueda.addEventListener('input', function() {
            const textoBuscado = this.value.toLowerCase();
            const filas = document.querySelectorAll("table tbody tr");
            filas.forEach(fila => {
                const contenidoFila = fila.textContent.toLowerCase();
                fila.style.display = contenidoFila.includes(textoBuscado) ? "" : "none";
            });
        });
    }
    
    const modal = document.getElementById('modalBanco');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            const encabezadoModal = modal.querySelector('h1#modalLabel');
            const botonModal = document.querySelector('button[name="tipoSolicitud"]');

            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_banco = boton.getAttribute('datos-cod-banco');
            const nombre = boton.getAttribute('datos-nombre');
            const estado = boton.getAttribute('datos-estado');

            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodBanco = modal.querySelector('.modal-body #cod-banco')
            const inputNombre = modal.querySelector('.modal-body #nombre_banco')

            switch (boton.title) {
                case "Registrar":

                    encabezadoModal.innerHTML = '<i class="bi bi-ev-front me-2"></i> Registro de Banco';
                    botonModal.value = "registrar";
                    botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';
                    inputCodBanco.value = "";
                    inputNombre.value = "";
                    break
                case "Actualizar":
                    encabezadoModal.innerHTML = '<i class="bi bi-ev-front me-2"></i> Actualizacion de Banco';
                    botonModal.value = "actualizar";
                    botonModal.innerHTML = '<i class="bi bi-save"></i> Actualizar';

                    if (cod_banco != "" && estado == 1) {
                        // Asignar los valores obtenidos a los campos del formulario
                        inputCodBanco.value = cod_banco;
                        inputNombre.value = nombre;
                    } else {
                        inputCodBanco.value = "Error: Registro inactivo";
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
            let codbanco = this.getAttribute('datos-cod-banco');

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
                    form.action = '?url=banco';
                    form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_banco" value="${codbanco}">
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
                    text = "El Banco ha sido registrado correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "El Banco ha sido actualizado correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "El Banco ha sido eliminado correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Banco existente!";
                    text = "El Banco ingresado ya existe en la base de datos.";
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