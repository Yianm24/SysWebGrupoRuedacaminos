document.addEventListener("DOMContentLoaded", function () {

    //Modal Registrar y Editar.
    const modalEmpleado = document.getElementById('modalEmpleado');
    if (modalEmpleado) {
        modalEmpleado.addEventListener('show.bs.modal', event => {
            const botonTrig = event.relatedTarget; 
            const tituloModal = modalEmpleado.querySelector('#modalLabel');
            const btnSubmit = modalEmpleado.querySelector('#btnSubmitModal');
            const inputId = modalEmpleado.querySelector('#id_empleado');
            const inputCedula = modalEmpleado.querySelector('#cedula');
            const inputNombre = modalEmpleado.querySelector('#nombre');
            const inputApellido = modalEmpleado.querySelector('#apellido');
            const inputTelefono = modalEmpleado.querySelector('#telefono');
            const inputEmergencia = modalEmpleado.querySelector('#telefono_emergencia');
            const selectCargo = modalEmpleado.querySelector('#cod_cargo');
            const inputsEvaluar = modalEmpleado.querySelectorAll('.input-evaluar');
            inputsEvaluar.forEach(input => {
                $(input).removeClass('is-valid is-invalid');$(input).siblings('.mensaje-error').hide().text('');
            });

            if (botonTrig.title === "Registrar" || botonTrig.getAttribute('title') === 'Registrar') {
                tituloModal.innerHTML = '<i class="bi bi-person-plus"></i> Registro de Empleado';
                btnSubmit.value = "registrar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Registrar';
                inputId.name = ""; 
                inputCedula.name = "cedula";
                inputNombre.name = "nombre";
                inputApellido.name = "apellido";
                inputTelefono.name = "telefono";
                inputEmergencia.name = "telefono_emergencia";
                selectCargo.name = "cod_cargo";
                
                inputId.value = "";
                inputCedula.value = "";
                inputNombre.value = "";
                inputApellido.value = "";
                inputTelefono.value = "";
                inputEmergencia.value = "";
                selectCargo.value = "";
                
                $(inputCedula).trigger('input');
                
            } else if (botonTrig.title === "Editar" || botonTrig.getAttribute('title') === 'Editar') {
                tituloModal.innerHTML = '<i class="bi bi-pencil-square"></i> Modificar Empleado';
                btnSubmit.value = "actualizar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Modificar';
                inputId.name = "id_empleado_editar";
                inputCedula.name = "cedula_editar";
                inputNombre.name = "nombre_editar";
                inputApellido.name = "apellido_editar";
                inputTelefono.name = "telefono_editar";
                inputEmergencia.name = "telefono_emergencia_editar";
                selectCargo.name = "cod_cargo_editar";

                //llenando los datos de la tabla
                inputId.value = botonTrig.getAttribute('data-id');
                inputCedula.value = botonTrig.getAttribute('data-cedula');
                inputNombre.value = botonTrig.getAttribute('data-nombre');
                inputApellido.value = botonTrig.getAttribute('data-apellido');
                inputTelefono.value = botonTrig.getAttribute('data-telefono');
                inputEmergencia.value = botonTrig.getAttribute('data-emergencia');
                selectCargo.value = botonTrig.getAttribute('data-cargo');

                const datosOriginales = {
                    cedula: inputCedula.value, nombre: inputNombre.value,
                    apellido: inputApellido.value, telefono: inputTelefono.value,
                    emergencia: inputEmergencia.value, cargo: selectCargo.value
                };
                document.getElementById('formEmpleado').setAttribute('data-originales', JSON.stringify(datosOriginales));
                inputsEvaluar.forEach(input => $(input).trigger('input'));
                btnSubmit.disabled = true;
                selectCargo.addEventListener('change', function() {
                    btnSubmit.disabled = false;
                });
            }
        });
    }

    //Validación Editar
    const formEmpleado = document.getElementById('formEmpleado');
    if (formEmpleado) {
        formEmpleado.addEventListener('submit', function(event) {
            const btnSubmit = modalEmpleado.querySelector('#btnSubmitModal');
            
            if (btnSubmit.value === "actualizar") {
                const originales = JSON.parse(this.getAttribute('data-originales'));
                const actuales = {
                    cedula: document.getElementById('cedula').value,
                    nombre: document.getElementById('nombre').value,
                    apellido: document.getElementById('apellido').value,
                    telefono: document.getElementById('telefono').value,
                    emergencia: document.getElementById('telefono_emergencia').value,
                    cargo: document.getElementById('cod_cargo').value
                };
                
                if (JSON.stringify(originales) === JSON.stringify(actuales)) {
                    event.preventDefault();
                    Swal.fire({ title: "Sin modificaciones", text: "Los datos ingresados son iguales a los actuales y no se registraron cambios.", icon: "info" });
                }
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
                    title = "Modificación exitosa!";
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