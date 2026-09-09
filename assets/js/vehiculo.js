document.addEventListener("DOMContentLoaded", function () {

    const modal = document.getElementById('modalVehiculo');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            const encabezadoModal = modal.querySelector('h1#modalLabel');
            const botonModal = document.querySelector('button[name="tipoSolicitud"]');
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_vehiculo = boton.getAttribute('datos-cod-vehiculo');
            const placa = boton.getAttribute('datos-placa');
            const color = boton.getAttribute('datos-color');
            const anio = boton.getAttribute('datos-anio');
            const anchura = boton.getAttribute('datos-anchura');
            const altura = boton.getAttribute('datos-altura');
            const peso_max = boton.getAttribute('datos-peso-max');
            const modelo = boton.getAttribute('datos-modelo');
            const estado = boton.getAttribute('datos-estado');

            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodVehiculo = modal.querySelector('.modal-body #cod-vehiculo');
            const inputPlaca = modal.querySelector('.modal-body #placa');
            const inputColor = modal.querySelector('.modal-body #color');
            const inputAnio = modal.querySelector('.modal-body #anio');
            const inputAnchura = modal.querySelector('.modal-body #anchura');
            const inputAltura = modal.querySelector('.modal-body #altura');
            const inputPesoMax = modal.querySelector('.modal-body #peso_max');
            const inputModelo = modal.querySelector('.modal-body #modelo');

            switch (boton.title) {
                case "Registrar":
                    const selectTipoVehiculo = modal.querySelector('.modal-body #tipo-vehiculo');
                    const selectModelo = modal.querySelector('.modal-body #modelo');

                    encabezadoModal.innerHTML = '<i class="bi bi-truck me-2"></i> Registro de Vehículo';


                    botonModal.value = "registrar";
                    botonModal.innerHTML = '<i class="bi bi-save"></i> Registrar';

                    inputCodVehiculo.value = "";
                    inputPlaca.value = "";
                    inputColor.value = "";
                    inputAnio.value = "";
                    inputAnchura.value = "";
                    inputAltura.value = "";
                    inputPesoMax.value = "";
                    inputModelo.value = "";
                    selectModelo.selectedIndex = 0;
                    break
                case "Actualizar":
                    encabezadoModal.innerHTML = '<i class="bi bi-truck me-2"></i> Actualización de Vehículo';
                    botonModal.value = "actualizar";
                    botonModal.innerHTML = '<i class="bi bi-pencil"></i> Actualizar';
                    if (cod_vehiculo != "" && estado == 1) {
                        //Inserta valores dentro de los inputs del formulario para actualizar
                        inputCodVehiculo.value = cod_vehiculo;
                        inputPlaca.value = placa;
                        inputColor.value = color;
                        inputAnio.value = anio;
                        inputAnchura.value = anchura;
                        inputAltura.value = altura;
                        inputPesoMax.value = peso_max;
                        inputModelo.value = modelo;
                        
                    } else {
                        inputPlaca.value = "Error: Registro inactivo";
                        inputColor.value = "Error: Registro inactivo";
                        inputAnio.value = "Error: Registro inactivo";
                        inputAnchura.value = "Error: Registro inactivo";
                        inputAltura.value = "Error: Registro inactivo";
                        inputPesoMax.value = "Error: Registro inactivo";
                        inputModelo.value = "Error: Registro inactivo";
                        console.log("No se puede editar el registro, ya que está inactivo.");
                    }
                    break

            }
        })
    }

    //Modal Eliminar
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function (event) {
            event.preventDefault();
            let codvehiculo = this.getAttribute('data-id');

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
                    form.action = '?url=vehiculo';
                    form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="cod_vehiculo" value="${codvehiculo}">
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
                    text = "El Vehiculo ha sido registrada correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "El Vehiculo ha sido actualizada correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "El Vehiculo ha sido eliminada correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Vehiculo existente!";
                    text = "El Vehiculo ingresada ya existe en la base de datos.";
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