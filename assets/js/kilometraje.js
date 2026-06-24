document.addEventListener("DOMContentLoaded", function () {
    
    //Modal de Edición
    const modalEditar = document.getElementById('modalEditar');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', event => {
            const boton = event.relatedTarget;
            
            // Obtener los datos del registro
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

    // Modal de Eliminación.
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function(event) {
            event.preventDefault(); 
            
            // Mostrar una confirmación antes de eliminar
            let confirmacion = confirm("¿Está seguro de eliminar esta tarifa?");
            
            if (confirmacion) {
                let idTarifa = this.getAttribute('data-id');
                
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                
                form.innerHTML = `
                    <input type="hidden" name="tipoSolicitud" value="eliminar">
                    <input type="hidden" name="id_tarifa" value="${idTarifa}">
                `;
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    //Validación de Registros.
    const formRegistro = document.getElementById('formPrecioKilometraje');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(event) {
            const kilometrajeInput = document.getElementById('kilometraje').value;
            const precioInput = document.getElementById('precio_kilometraje').value;
            
            if (kilometrajeInput === "" || isNaN(kilometrajeInput) || Number(kilometrajeInput) <= 0 || kilometrajeInput.length > 7 || 
                precioInput === "" || isNaN(precioInput) || Number(precioInput) <= 0 || precioInput.length > 10) {
                
                event.preventDefault(); 
                alert("Ingrese valores válidos mayores a 0.00 y que no excedan el límite permitido.");

                document.getElementById('kilometraje').classList.add('is-invalid');
                document.getElementById('precio_kilometraje').classList.add('is-invalid');
            } else {
                document.getElementById('kilometraje').classList.remove('is-invalid');
                document.getElementById('precio_kilometraje').classList.remove('is-invalid');
            }
        });
    }

    // Filtro de busqueda.
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