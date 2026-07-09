document.addEventListener("DOMContentLoaded", function () {
    
    // Modal Editar.
    const modalEditar = document.getElementById('modalEditar');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', event => {
            const boton = event.relatedTarget;
            const id = boton.getAttribute('data-id');
            const kilometraje = boton.getAttribute('data-kilometraje'); 
            const precio = boton.getAttribute('data-precio');

            modalEditar.querySelector('#id_tarifa_editar').value = id;
            modalEditar.querySelector('#kilometraje_editar').value = kilometraje;
            modalEditar.querySelector('#precio_kilometraje_editar').value = precio;

            document.getElementById('formEditarPrecio').setAttribute('data-km-original', kilometraje);
            document.getElementById('formEditarPrecio').setAttribute('data-precio-original', precio);
        });
    }

    // Validación de Edición.
    const formEditar = document.getElementById('formEditarPrecio');
    if (formEditar) {
        formEditar.addEventListener('submit', function(event) {
            const kmOrig = this.getAttribute('data-km-original');
            const preOrig = this.getAttribute('data-precio-original');
            const kmActual = document.getElementById('kilometraje_editar').value;
            const preActual = document.getElementById('precio_kilometraje_editar').value;

            if (Number(kmOrig) === Number(kmActual) && Number(preOrig) === Number(preActual)) {
                event.preventDefault();
                Swal.fire({ title: "Sin modificaciones", text: "Los valores ingresados son iguales a los actuales y no se registraron cambios.", icon: "info" });
                return;
            }

            if (kmActual === "" || isNaN(kmActual) || Number(kmActual) <= 0 || preActual === "" || isNaN(preActual) || Number(preActual) <= 0) {
                event.preventDefault(); 
                Swal.fire({ title: "Error de validación", text: "Ingrese valores válidos mayores a 0.", icon: "error" });
            }
        });
    }

    // Validación de Registro
    const formRegistro = document.getElementById('formPrecioKilometraje');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(event) {
            const kilometrajeInput = document.getElementById('kilometraje').value;
            const precioInput = document.getElementById('precio_kilometraje').value;
            
            if (kilometrajeInput === "" || isNaN(kilometrajeInput) || Number(kilometrajeInput) <= 0 || precioInput === "" || isNaN(precioInput) || Number(precioInput) <= 0) {
                event.preventDefault(); 
                Swal.fire({ title: "Error de validación", text: "Ingrese valores válidos mayores a 0.", icon: "error" });
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

    // Filtro de búsqueda en la tabla
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
});