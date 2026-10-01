document.addEventListener("DOMContentLoaded", function () {
    
    // Modal Editar
    const modalEditar = document.getElementById('modalEditarCambio');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', event => {
            const boton = event.relatedTarget;
            const id = boton.getAttribute('data-id');
            const tasa = boton.getAttribute('data-tasa');
            const moneda = boton.getAttribute('data-moneda');

            modalEditar.querySelector('#id_cambio_editar').value = id;
            modalEditar.querySelector('#tasa_editar').value = tasa;
            modalEditar.querySelector('#moneda_editar').value = moneda;

            document.getElementById('formEditarCambio').setAttribute('data-tasa-original', tasa);
        });
    } 

    // Validación de Edición
    const formEditar = document.getElementById('formEditarCambio');
    if (formEditar) {
        formEditar.addEventListener('submit', function(event) {
            const tasaOriginal = this.getAttribute('data-tasa-original');
            const tasaActual = document.getElementById('tasa_editar').value;
            
            if (Number(tasaOriginal) === Number(tasaActual)) {
                event.preventDefault();
                Swal.fire({ title: "Sin modificaciones", text: "El valor ingresado es igual al actual y no se registraron cambios.", icon: "info" });
                return;
            }

            if (tasaActual === "" || isNaN(tasaActual) || Number(tasaActual) <= 0) {
                event.preventDefault();
                Swal.fire({ title: "Error de validación", text: "Ingrese una tasa válida mayor a 0.", icon: "error" });
            }
        });
    }

    // Validación de Registro
    const formRegistro = document.getElementById('formCambioMoneda');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(event) {
            const tasaInput = document.getElementById('tasa').value;
            if (tasaInput === "" || isNaN(tasaInput) || Number(tasaInput) <= 0) {
                event.preventDefault();
                Swal.fire({ title: "Error de validación", text: "Ingrese una tasa válida mayor a 0.", icon: "error" });
            }
        });
    }

    // Modal Eliminar
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function(event) {
            event.preventDefault(); 
            let idCambio = this.getAttribute('data-id');

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
                    form.action = '?url=cambiomoneda';
                    form.innerHTML = `<input type="hidden" name="tipoSolicitud" value="eliminar"><input type="hidden" name="id_cambio" value="${idCambio}">`;
                    document.body.appendChild(form);
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) { 
                    swalWithBootstrapButtons.fire({ title: "Cancelado", text: "Eliminación de la Tasa cancelada", icon: "error" });
                }
            });
        });
    });

    // Mensajes y alertas.
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status) {
        setTimeout(() => {
            let title, text, icon;
            switch (status) {
                case 'success':
                    title = "Registro exitoso!";
                    text = "Registro de tasa de cambio exitoso";
                    icon = "success";
                    break;
                case 'exists':
                    title = "¡Tasa existente!";
                    text = "La moneda ya posee una tasa registrada el día de hoy.";
                    icon = "warning";
                    break;
                case 'updated':
                    title = "Modificación exitosa!";
                    text = "Modificación de los datos realizada exitosamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "¡Eliminado!";
                    text = "Eliminación de la tasa realizada exitosamente.";
                    icon = "success";
                    break;
            }
            if (title && text && icon) {
                Swal.fire({ title: title, text: text, icon: icon });
            }
        }, 100);
    }
});