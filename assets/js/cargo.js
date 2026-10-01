document.addEventListener("DOMContentLoaded", function () {


    // Validación de Registro.
    const formRegistrar = document.querySelector('#registerCargo form');
    if (formRegistrar) {
        formRegistrar.addEventListener('submit', function(event) {
            const nombreInput = document.querySelector('#registerCargo input[name="nombre"]').value.trim();
            if (nombreInput === "") {
                event.preventDefault();
                Swal.fire({ title: "Error de validación", text: "El nombre del cargo no puede estar vacío.", icon: "error" });
            }
        });
    }
    
    // Modal Modificar Cargo.
    const modal = document.getElementById('modificarCargo');
    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            const boton = event.relatedTarget;
            const cod_cargo = boton.getAttribute('datos-cod-cargo');
            const nombre = boton.getAttribute('datos-nombre');
            const inputCodCargo = modal.querySelector('.modal-body #cod-cargo');
            const inputNombre = modal.querySelector('.modal-body #nombre');
            inputCodCargo.value = cod_cargo;
            inputNombre.value = nombre;
            const form = modal.querySelector('form');
            form.setAttribute('data-orig-nombre', nombre);
        });
    }

    // Validación de Modificación duplicada y vacía.
    const formModificar = document.querySelector('#modificarCargo form');
    if (formModificar) {
        formModificar.addEventListener('submit', function(event) {
            const nombreOriginal = this.getAttribute('data-orig-nombre');
            const nombreActual = document.getElementById('nombre').value.trim();

            if (nombreOriginal === nombreActual) {
                event.preventDefault();
                Swal.fire({ title: "Sin modificaciones", text: "El nombre ingresado es igual al actual y no se registraron cambios.", icon: "info" });
            }
        });
    }

    // Modal Eliminar.
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function(event) {
            event.preventDefault(); 
            let codCargo = this.getAttribute('data-id');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "¿Está seguro que desea eliminar este cargo?",
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
                    form.action = '?url=cargo';
                    form.innerHTML = `<input type="hidden" name="tipoSolicitud" value="eliminar"><input type="hidden" name="cod_cargo" value="${codCargo}">`;
                    document.body.appendChild(form);
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({ title: "Cancelado", text: "Eliminación del cargo cancelada", icon: "error" });
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
                    text = "El cargo ha sido registrado correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "El cargo ha sido modificado correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "¡Eliminado!";
                    text = "El cargo ha sido eliminado correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Cargo existente!";
                    text = "El cargo ingresado ya existe en la base de datos.";
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
