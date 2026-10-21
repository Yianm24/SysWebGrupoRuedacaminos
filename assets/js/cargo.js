document.addEventListener("DOMContentLoaded", function () {


    // Validación de Registro y Modificación.
    const modalCargo = document.getElementById('modalCargo');
    if (modalCargo) {
        modalCargo.addEventListener('show.bs.modal', event => {
            const botonTrig = event.relatedTarget;
            const tituloModal = modalCargo.querySelector('#modalLabel');
            const btnSubmit = modalCargo.querySelector('#btnSubmitModal');
            
            const inputId = modalCargo.querySelector('#cod_cargo');
            const inputNombre = modalCargo.querySelector('#nombre');

            $(inputNombre).removeClass('is-valid is-invalid');$(inputNombre).siblings('.mensaje-error').hide().text('');
            
            if (botonTrig.title === "Registrar" || botonTrig.getAttribute('title') === 'Registrar') {
                tituloModal.innerHTML = '<i class="bi bi-person-badge"></i> Registrar Nuevo Cargo';
                btnSubmit.value = "registrar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Registrar';
                inputId.name = ""; 
                inputNombre.name = "nombre";
                inputId.value = "";
                inputNombre.value = "";

                $(inputNombre).trigger('input');
                
            } else if (botonTrig.title === "Modificar" || botonTrig.getAttribute('title') === 'Modificar') {
                tituloModal.innerHTML = '<i class="bi bi-pencil-square"></i> Modificar Cargo';
                btnSubmit.value = "modificar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Guardar';
                inputId.name = "cod-cargo";
                inputNombre.name = "nombre";
                inputId.value = botonTrig.getAttribute('datos-cod-cargo');
                inputNombre.value = botonTrig.getAttribute('datos-nombre');

                document.getElementById('formCargo').setAttribute('data-nombre-original', inputNombre.value);
                
                $(inputNombre).trigger('input');
                btnSubmit.disabled = true;
            }
        });
    }

    //validar edición de cargo sin cambios
    const formCargo = document.getElementById('formCargo');
    if (formCargo) {
        formCargo.addEventListener('submit', function(event) {
            const btnSubmit = modalCargo.querySelector('#btnSubmitModal');
            
            if (btnSubmit.value === "modificar") {
                const nombreOriginal = this.getAttribute('data-nombre-original');
                const nombreActual = document.getElementById('nombre').value;
                
                if (nombreOriginal === nombreActual) {
                    event.preventDefault();
                    Swal.fire({ title: "Sin modificaciones", text: "El nombre ingresado es igual al actual y no se registraron cambios.", icon: "info" });
                }
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
