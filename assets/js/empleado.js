document.addEventListener("DOMContentLoaded", function () {
    
    //Modal Editar
    const modalEditar = document.getElementById('modalEditar');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', event => {
            const boton = event.relatedTarget;
            
            //Capturamos los datos del empleado
            const id = boton.getAttribute('data-id');
            const cedula = boton.getAttribute('data-cedula');
            const nombre = boton.getAttribute('data-nombre');
            const apellido = boton.getAttribute('data-apellido');
            const telefono = boton.getAttribute('data-telefono');
            const emergencia = boton.getAttribute('data-emergencia');
            const cargo = boton.getAttribute('data-cargo');

            modalEditar.querySelector('#id_empleado_editar').value = id;
            modalEditar.querySelector('#cedula_editar').value = cedula;
            modalEditar.querySelector('#nombre_editar').value = nombre;
            modalEditar.querySelector('#apellido_editar').value = apellido;
            modalEditar.querySelector('#telefono_editar').value = telefono;
            modalEditar.querySelector('#telefono_emergencia_editar').value = emergencia;
            modalEditar.querySelector('#cod_cargo_editar').value = cargo;

            const form = document.getElementById('formEditarEmpleado');
            form.setAttribute('data-orig-cedula', cedula);
            form.setAttribute('data-orig-nombre', nombre);
            form.setAttribute('data-orig-apellido', apellido);
            form.setAttribute('data-orig-telefono', telefono);
            form.setAttribute('data-orig-emergencia', emergencia);
            form.setAttribute('data-orig-cargo', cargo);
        });
    }

    //Validación al Editar
    const formEditar = document.getElementById('formEditarEmpleado');
    if (formEditar) {
        formEditar.addEventListener('submit', function(event) {
            const oCed = this.getAttribute('data-orig-cedula');
            const oNom = this.getAttribute('data-orig-nombre');
            const oApe = this.getAttribute('data-orig-apellido');
            const oTel = this.getAttribute('data-orig-telefono');
            const oEme = this.getAttribute('data-orig-emergencia');
            const oCar = this.getAttribute('data-orig-cargo');

            const aCed = document.getElementById('cedula_editar').value;
            const aNom = document.getElementById('nombre_editar').value;
            const aApe = document.getElementById('apellido_editar').value;
            const aTel = document.getElementById('telefono_editar').value;
            const aEme = document.getElementById('telefono_emergencia_editar').value;
            const aCar = document.getElementById('cod_cargo_editar').value;

            if (oCed === aCed && oNom === aNom && oApe === aApe && oTel === aTel && oEme === aEme && oCar === aCar) {
                event.preventDefault();
                Swal.fire({ title: "Sin modificaciones", text: "Los datos ingresados son idénticos a los actuales. No se registraron cambios.", icon: "info" });
            }
        });
    }

    //Modal Eliminar
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

    //Filtro de búsqueda en la tabla de empleados
    const inputBusqueda = document.querySelector('input[placeholder="Buscar Empleado..."]');
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