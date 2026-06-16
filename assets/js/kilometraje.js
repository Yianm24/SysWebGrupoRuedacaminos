document.addEventListener("DOMContentLoaded", function () {
    //Modal de Edición lógica.
    const modalEditar = document.getElementById('modalEditar');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', event => {
            // Botón que activó el modal
            const boton = event.relatedTarget;
            
            // Extraemos los datos del botón
            const id = boton.getAttribute('data-id');
            const vehiculo = boton.getAttribute('data-vehiculo');
            const precio = boton.getAttribute('data-precio');

            // Asignamos los valores a los campos del formulario dentro del modal
            document.getElementById('id_tarifa_editar').value = id;
            document.getElementById('vehiculo_editar').value = vehiculo;
            document.getElementById('precio_kilometraje_editar').value = precio;
        });
    }

    //Modal de Eliminación logica.
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function() {
            document.getElementById('id_tarifa_eliminar').value = this.getAttribute('data-id');
            document.getElementById('codigo_tipovehiculo_eliminar').value = this.getAttribute('data-codigo');
        });
    });

    //Validación de Registros.
    const formRegistro = document.getElementById('formPrecioKilometraje');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(event) {
            const precioInput = document.getElementById('precio_kilometraje').value;
            const alerta = document.getElementById('alertaSistema');
            
            if (precioInput === "" || isNaN(precioInput) || Number(precioInput) <= 0) {
                event.preventDefault(); 
                if (alerta) {
                    alerta.classList.remove('d-none', 'alert-success');
                    alerta.classList.add('alert-danger');
                    alerta.innerHTML = '<i class="bi bi-x-circle-fill me-2"></i> <strong>Error:</strong> Datos inválidos.';
                }
                document.getElementById('precio_kilometraje').focus();
            }
        });
    }

    //Filtro de búsqueda.
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