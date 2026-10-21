document.addEventListener("DOMContentLoaded", function () {

    // Validación de Registro y Edición
    const modalKilometraje = document.getElementById('modalKilometraje');
    if (modalKilometraje) {
        modalKilometraje.addEventListener('show.bs.modal', event => {
            const botonTrig = event.relatedTarget;
            const tituloModal = modalKilometraje.querySelector('#modalLabel');
            const btnSubmit = modalKilometraje.querySelector('#btnSubmitModal');
            
            const inputId = modalKilometraje.querySelector('#id_tarifa');
            const inputKm = modalKilometraje.querySelector('#kilometraje_input');
            const inputPrecio = modalKilometraje.querySelector('#precio_kilometraje');
            
            const inputsEvaluar = modalKilometraje.querySelectorAll('.input-evaluar');
            inputsEvaluar.forEach(input => {
                $(input).removeClass('is-valid is-invalid');$(input).siblings('.mensaje-error').hide().text('');
            });

            if (botonTrig.title === "Registrar" || botonTrig.getAttribute('title') === 'Registrar') {
                tituloModal.innerHTML = '<i class="bi bi-currency-dollar"></i> Registrar Precio de Kilometraje';
                btnSubmit.value = "registrar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Registrar';
                
                inputId.name = ""; 
                inputKm.name = "kilometraje";
                inputPrecio.name = "precio_kilometraje";
                
                inputId.value = "";
                inputKm.value = "";
                inputPrecio.value = "";
                $(inputKm).trigger('input');
                
            } else if (botonTrig.title === "Editar" || botonTrig.getAttribute('title') === 'Editar') {
                tituloModal.innerHTML = '<i class="bi bi-pencil-square"></i> Editar Precio de Kilometraje';
                btnSubmit.value = "actualizar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Guardar';

                inputId.name = "id_tarifa_editar";
                inputKm.name = "kilometraje_editar";
                inputPrecio.name = "precio_kilometraje_editar";

                inputId.value = botonTrig.getAttribute('data-id');
                inputKm.value = botonTrig.getAttribute('data-kilometraje');
                inputPrecio.value = botonTrig.getAttribute('data-precio');
                
                const datosOriginales = {
                    km: inputKm.value,
                    precio: inputPrecio.value
                };
                document.getElementById('formKilometraje').setAttribute('data-originales', JSON.stringify(datosOriginales));
                inputsEvaluar.forEach(input => $(input).trigger('input'));
                btnSubmit.disabled = true;
            }
        });
    }

    //Validar Edición sin cambios
    const formKilometraje = document.getElementById('formKilometraje');
    if (formKilometraje) {
        formKilometraje.addEventListener('submit', function(event) {
            const btnSubmit = modalKilometraje.querySelector('#btnSubmitModal');
            
            if (btnSubmit.value === "actualizar") {
                const originales = JSON.parse(this.getAttribute('data-originales'));
                const actuales = {
                    km: document.getElementById('kilometraje_input').value,
                    precio: document.getElementById('precio_kilometraje').value
                };
                
                if (Number(originales.km) === Number(actuales.km) && Number(originales.precio) === Number(actuales.precio)) {
                    event.preventDefault();
                    Swal.fire({ title: "Sin modificaciones", text: "Los valores ingresados son iguales a los actuales y no se registraron cambios.", icon: "info" });
                }
            }
        });
    }

    // Modal Eliminar
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function(event) {
            event.preventDefault(); 
            let idTarifa = this.getAttribute('data-id');

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
                    form.action = '?url=kilometraje';
                    form.innerHTML = `<input type="hidden" name="tipoSolicitud" value="eliminar"><input type="hidden" name="id_tarifa" value="${idTarifa}">`;
                    document.body.appendChild(form);
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({ title: "Cancelado", text: "Eliminación de la tarifa cancelada", icon: "error" });
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
                    text = "Registro de precio de kilometraje realizado exitosamente";
                    icon = "success";
                    break;
                case 'exists':
                    title = "¡Tarifa existente!";
                    text = "Ya existe una tarifa registrada para el Kilometraje ingresado";
                    icon = "warning";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "Actualización del Precio de kilometraje realizado exitosamente";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "¡Eliminado!";
                    text = "Eliminación del Precio de Kilometraje realizado exitosamente";
                    icon = "success";
                    break;
            }
            if (title && text && icon) {
                Swal.fire({ title: title, text: text, icon: icon });
            }
        }, 100);
    }
});