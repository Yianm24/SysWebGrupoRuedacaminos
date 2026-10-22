document.addEventListener("DOMContentLoaded", function () {
    
    //Modal Formularios para Registrar y Editar.
    const modalCambio = document.getElementById('modalCambio');
    if (modalCambio) {
        modalCambio.addEventListener('show.bs.modal', event => {
            const botonTrig = event.relatedTarget;
            const tituloModal = modalCambio.querySelector('#modalLabel');
            const btnSubmit = modalCambio.querySelector('#btnSubmitModal');
            
            const inputId = modalCambio.querySelector('#id_cambio');
            const selectMoneda = modalCambio.querySelector('#moneda');
            const inputTasa = modalCambio.querySelector('#tasa');

            $(inputTasa).removeClass('is-valid is-invalid');$(inputTasa).siblings('.mensaje-error').hide().text('');
            if (botonTrig.title === "Registrar" || botonTrig.getAttribute('title') === 'Registrar') {
                tituloModal.innerHTML = '<i class="bi bi-currency-exchange"></i> Registrar Cambio Moneda';
                btnSubmit.value = "registrar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Registrar';
                
                inputId.name = ""; 
                selectMoneda.name = "moneda";
                inputTasa.name = "tasa";
                
                inputId.value = "";
                selectMoneda.value = "";
                inputTasa.value = "";
                
                $(inputTasa).trigger('input');
                
            } else if (botonTrig.title === "Editar" || botonTrig.getAttribute('title') === 'Editar') {
                tituloModal.innerHTML = '<i class="bi bi-pencil-square"></i> Editar Tasa de Cambio';
                btnSubmit.value = "actualizar";
                btnSubmit.innerHTML = '<i class="bi bi-save"></i> Actualizar';

                inputId.name = "id_cambio_editar";
                selectMoneda.name = "moneda_editar";
                inputTasa.name = "tasa_editar";

                inputId.value = botonTrig.getAttribute('data-id');
                selectMoneda.value = botonTrig.getAttribute('data-moneda');
                inputTasa.value = botonTrig.getAttribute('data-tasa');

                const datosOriginales = {
                    tasa: inputTasa.value,
                    moneda: selectMoneda.value
                };
                document.getElementById('formCambio').setAttribute('data-originales', JSON.stringify(datosOriginales));
                $(inputTasa).trigger('input');
                btnSubmit.disabled = true;
                selectMoneda.addEventListener('change', function() {
                    btnSubmit.disabled = false;
                });

            }
        });
    }

    // Validación para formulario editar
    const formCambio = document.getElementById('formCambio');
    if (formCambio) {
        formCambio.addEventListener('submit', function(event) {
            const btnSubmit = modalCambio.querySelector('#btnSubmitModal');
            
            if (btnSubmit.value === "actualizar") {
                const originales = JSON.parse(this.getAttribute('data-originales'));
                const tasaActual = document.getElementById('tasa').value;
                const monedaActual = document.getElementById('moneda').value;
                
                if (Number(originales.tasa) === Number(tasaActual) && originales.moneda === monedaActual) {
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