document.addEventListener("DOMContentLoaded", function () {
    
    //Modal Editar
    const modalEditar = document.getElementById('modalEditarCambio');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', event => {
            const boton = event.relatedTarget;
            const id = boton.getAttribute('data-id');
            const tasa = boton.getAttribute('data-tasa');
            const moneda = boton.getAttribute('data-moneda');

            modalEditar.querySelector('#id_cambio_editar').value = id;
            modalEditar.querySelector('#tasa_editar').value = tasa;
            modalEditar.querySelector('#moneda_editar').value = moneda;
        });
    } 

    //Modal Eliminar
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
                    form.innerHTML = `
                        <input type="hidden" name="tipoSolicitud" value="eliminar">
                        <input type="hidden" name="id_cambio" value="${idCambio}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
}); 