document.addEventListener("DOMContentLoaded", function () {
    //const boton = document.querySelectorAll('.obtener-codigo');
    //const codigo = document.querySelectorAll('.codigo_vehiculo');
    const modal = document.getElementById('actualizarVehiculo');

    /*boton.forEach(function(boton) {
        boton.addEventListener('click', function() {
            //console.log(codigo.value);
            console.log(this.value);
            
            //location.href = "?url=vehiculo&prueba=" + encodeURIComponent(this.value);
          
        });
    });*/


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;

            //Obtener los datos del vehículo desde los atributos datos- del botón
            const cod_vehiculo = boton.getAttribute('datos-cod-vehiculo');
            const placa = boton.getAttribute('datos-placa');
            const color = boton.getAttribute('datos-color');
            const tipovehiculo = boton.getAttribute('datos-tipovehiculo');
            const modelo = boton.getAttribute('datos-modelo');
            const ano = boton.getAttribute('datos-ano');

            // Obtener referencias a los campos del formulario dentro del modal
            const inputCodVehiculo = modal.querySelector('.modal-body #cod-vehiculo')
            const inputPlaca = modal.querySelector('.modal-body #placa')
            const inputColor = modal.querySelector('.modal-body #color')
            const inputTipovehiculo = modal.querySelector('.modal-body #tipo-vehiculo')
            const inputModelo = modal.querySelector('.modal-body #modelo')
            const inputAno = modal.querySelector('.modal-body #ano')


            // Asignar los valores obtenidos a los campos del formulario
            inputCodVehiculo.value = cod_vehiculo;
            inputPlaca.value = placa;
            inputColor.value = color;
            inputTipovehiculo.value = tipovehiculo;
            inputModelo.value = modelo;
            inputAno.value = ano;
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
                    text = "La unidad de medida ha sido registrada correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Actualización exitosa!";
                    text = "La unidad de medida ha sido actualizada correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "La unidad de medida ha sido eliminada correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Unidad de medida existente!";
                    text = "La unidad de medida ingresada ya existe en la base de datos.";
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