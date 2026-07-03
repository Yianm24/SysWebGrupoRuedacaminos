document.addEventListener("DOMContentLoaded", function () {
    
    // Modal Editar
    const modalEditar = document.getElementById('modalEditar');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', event => {
            const boton = event.relatedTarget;
            const id = boton.getAttribute('data-id');
            const kilometraje = boton.getAttribute('data-kilometraje'); 
            const precio = boton.getAttribute('data-precio');

            const inputId = modalEditar.querySelector('.modal-body #id_tarifa_editar');
            const inputKilometraje = modalEditar.querySelector('.modal-body #kilometraje_editar');
            const inputPrecio = modalEditar.querySelector('.modal-body #precio_kilometraje_editar');

            if (inputId) inputId.value = id;
            if (inputKilometraje) inputKilometraje.value = kilometraje;
            if (inputPrecio) inputPrecio.value = precio;
        });
    }

    // Modal Eliminar
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function(event) {
            event.preventDefault(); 
            let idTarifa = this.getAttribute('data-id');

            // Configuración de SweetAlert2 con botones personalizados
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
                    form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="id_tarifa" value="${idTarifa}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelado",
                        text: "Eliminación del Precio de Kilometraje cancelada",
                        icon: "error"
                    });
                }
            });
        });
    });

    // Validación de formulario
    const formRegistro = document.getElementById('formPrecioKilometraje');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(event) {
            const kilometrajeInput = document.getElementById('kilometraje').value;
            const precioInput = document.getElementById('precio_kilometraje').value;
            
            if (kilometrajeInput === "" || isNaN(kilometrajeInput) || Number(kilometrajeInput) <= 0 || 
                precioInput === "" || isNaN(precioInput) || Number(precioInput) <= 0) {
                
                event.preventDefault(); 
                Swal.fire({
                    title: "Error de validación",
                    text: "Ingrese valores válidos mayores a 0.00.",
                    icon: "error"
                });
            }
        });
    }

    // Función de búsqueda 
    const inputBusqueda = document.getElementById('inputBusqueda');
    if (inputBusqueda) {
        inputBusqueda.addEventListener('input', function() {
            const textoBuscado = this.value.toLowerCase();
            const filas = document.querySelectorAll("#tablaPrecios tbody tr");
            filas.forEach(fila => {
                const contenidoFila = fila.textContent.toLowerCase();
                fila.style.display = contenidoFila.includes(textoBuscado) ? "" : "none";
            });
        });
    }
});