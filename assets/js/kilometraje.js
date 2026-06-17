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
            const kilometrajeInput = document.getElementById('kilometraje').value.trim();
            const precioInput = document.getElementById('precio_kilometraje').value;
            
            if (kilometrajeInput === "" || precioInput === "" || isNaN(precioInput) || Number(precioInput) <= 0) {
                event.preventDefault(); 
                alert("Por favor, ingrese un kilometraje válido y un precio mayor a 0.");
            }
        });
    }

    // Filtro de busqueda.
    const inputBusqueda = document.getElementById('inputBusqueda');
    if (inputBusqueda) {
        inputBusqueda.addEventListener('keyup', function() {
            let filter = this.value.toUpperCase();
            let rows = document.querySelector("#tablaPrecios tbody").rows;
            
            for (let i = 0; i < rows.length; i++) {
                if(rows[i].cells.length > 1) {
                    let col1 = rows[i].cells[0].textContent.toUpperCase();
                    let col2 = rows[i].cells[1].textContent.toUpperCase();
                    
                    rows[i].style.display = (col1.indexOf(filter) > -1 || col2.indexOf(filter) > -1) ? "" : "none";
                }
            }
        });
    }
});