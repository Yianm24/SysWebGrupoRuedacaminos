document.addEventListener("DOMContentLoaded", function () {

    // Validación de Registro
    const formRegistro = document.querySelector('#registerEmpleado form');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(event) {
            const cedulaInput = document.getElementById('cedula').value.trim();
            const nombreInput = document.getElementById('nombre').value.trim();
            const apellidoInput = document.getElementById('apellido').value.trim();
            
            if (cedulaInput === "" || nombreInput === "" || apellidoInput === "") {
                event.preventDefault(); 
                Swal.fire({ title: "Error de validación", text: "Por favor, complete los campos obligatorios.", icon: "error" });
            }
        });
    }
    
    // Modal Editar.
    const modalEditar = document.getElementById('modalEditar');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', event => {
            const boton = event.relatedTarget;
            const id = boton.getAttribute('data-id');
            const cedula = boton.getAttribute('data-cedula');
            const nombre = boton.getAttribute('data-nombre');
            const apellido = boton.getAttribute('data-apellido');
            const telefono = boton.getAttribute('data-telefono');
            const emergencia = boton.getAttribute('data-emergencia');
            const cargo = boton.getAttribute('data-cargo');

            modalEditar.querySelector('#id_empleado_editar').value = id;
            modalEditar.querySelector('#cedula_editar').value = cedula;
            modalEditar.querySelector('#nombre_editar').value = nombre;
            modalEditar.querySelector('#apellido_editar').value = apellido;
            modalEditar.querySelector('#telefono_editar').value = telefono;
            modalEditar.querySelector('#telefono_emergencia_editar').value = emergencia;
            modalEditar.querySelector('#cod_cargo_editar').value = cargo;

            const formEditar = document.getElementById('formEditarEmpleado');
            formEditar.setAttribute('data-orig-cedula', cedula);
            formEditar.setAttribute('data-orig-nombre', nombre);
            formEditar.setAttribute('data-orig-apellido', apellido);
            formEditar.setAttribute('data-orig-telefono', telefono);
            formEditar.setAttribute('data-orig-emergencia', emergencia);
            formEditar.setAttribute('data-orig-cargo', cargo);
        });
    }

    // Validación de Edición duplicada y vacía.
    const formEditar = document.getElementById('formEditarEmpleado');
    if (formEditar) {
        formEditar.addEventListener('submit', function(event) {
            const origCedula = this.getAttribute('data-orig-cedula');
            const origNombre = this.getAttribute('data-orig-nombre');
            const origApellido = this.getAttribute('data-orig-apellido');
            const origTelefono = this.getAttribute('data-orig-telefono');
            const origEmergencia = this.getAttribute('data-orig-emergencia');
            const origCargo = this.getAttribute('data-orig-cargo');

            const actCedula = document.getElementById('cedula_editar').value.trim();
            const actNombre = document.getElementById('nombre_editar').value.trim();
            const actApellido = document.getElementById('apellido_editar').value.trim();
            const actTelefono = document.getElementById('telefono_editar').value.trim();
            const actEmergencia = document.getElementById('telefono_emergencia_editar').value.trim();
            const actCargo = document.getElementById('cod_cargo_editar').value;

            if (origCedula === actCedula && origNombre === actNombre && origApellido === actApellido && origTelefono === actTelefono && origEmergencia === actEmergencia && origCargo === actCargo) {
                event.preventDefault();
                Swal.fire({ title: "Sin modificaciones", text: "Los datos ingresados son iguales a los actuales y no se registraron cambios.", icon: "info" });
                return;
            }
        });
    }

    // Modal Eliminar
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function(event) {
            event.preventDefault(); 
            let idEmpleado = this.getAttribute('data-id');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: { confirmButton: "btn btn-success ms-2", cancelButton: "btn btn-danger" },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "¿Está seguro que desea eliminar este empleado?",
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
                    form.action = '?url=empleado';
                    form.innerHTML = `<input type="hidden" name="tipoSolicitud" value="eliminar"><input type="hidden" name="id_empleado" value="${idEmpleado}">`;
                    document.body.appendChild(form);
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({ title: "Cancelado", text: "Eliminación de empleado cancelada", icon: "error" });
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
                    text = "Registro de empleado realizado exitosamente";
                    icon = "success";
                    break;
                case 'exists':
                    title = "¡Empleado existente!";
                    text = "Ya existe un empleado registrado con la cédula ingresada";
                    icon = "warning";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "Modificación del empleado realizado exitosamente";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "¡Eliminado!";
                    text = "Eliminación del empleado realizado exitosamente";
                    icon = "success";
                    break;
            }
            if (title && text && icon) {
                Swal.fire({ title: title, text: text, icon: icon });
            }
        }, 100);
    }
});