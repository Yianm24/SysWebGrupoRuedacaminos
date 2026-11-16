$(document).ready(function () {

    const miTabla = instanciarDatatableGlobal('#tablaBanco');

    dibujarTabla(miTabla);
    const modal = $('#modalBanco');

    if (modal) {
        modal.on('show.bs.modal', event => {

            const boton = event.relatedTarget;

            AccionModal(boton);
        })

        $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
            event.preventDefault();
            const datos = {
                cod_banco: $("#cod-banco").val(),
                nombre_banco: $("#nombre_banco").val()
            }

            const btnEnviar = this;

            const solicitud = $(this).val();

            const objmodal = bootstrap.Modal.getInstance(modal) ?? '';
            ajaxEnvioDatosGlobal('banco', solicitud, dibujarTabla, miTabla, datos, objmodal, btnEnviar);

        });

    }


    $("#tablaBanco tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();

        const codbanco = this.getAttribute("datos-cod-banco");

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success ms-2",
                cancelButton: "btn btn-danger"
            },
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
                ajaxEnvioDatosGlobal('banco', 'eliminar', dibujarTabla, miTabla, { cod_banco: codbanco }, null, null)
            }
        });
    });
});

//Dibuja los registros de la tabla
function dibujarTabla(objTable) {
    const modulo = 'banco';
    ajaxConsultarGlobal(modulo, (response) => {

        objTable.clear();

        let lista = Array.isArray(response) ? response : [];

        if (lista.length > 0) {
            $.each(lista, function (index, dato) {

                const botones = ` <td class="text-start pe-4">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalBanco"
                                 datos-cod-banco="${dato.cod_banco}"
                                 datos-nombre="${dato.nombre}"
                                 datos-estado="${dato.estado}"
                                 >
                                 <i class="bi bi-pencil"></i>
                             </button>
                         <a href="#" class="text-secondary btn-eliminar"
                                 datos-cod-banco="${dato.cod_banco}" >
                                 <i class="bi bi-trash"></i>
                         </a>
                     </td>`;

                objTable.row.add([
                    dato.nombre,
                    botones
                ])
            });
            objTable.draw();
        } else {
            objTable.row.add([
                'No se encontraron registros.',
                'No se encontraron registros.'
            ])
            objTable.draw();
        }
    })
}

function AccionModal(boton) {

    const encabezadoModal = $('#modalLabel');
    const botonModal = $('button[name="tipoSolicitud"]');

    const cod_banco = $(boton).attr('datos-cod-banco');
    const nombre = $(boton).attr('datos-nombre');
    const estado = $(boton).attr('datos-estado');

    // Obtener referencias a los campos del formulario dentro del modal
    const inputCodBanco = $('#cod-banco')
    const inputNombre = $('#nombre_banco')

    switch ($(boton).attr('title')) {
        case "Registrar":

            encabezadoModal.html('<i class="bi bi-ev-front me-2"></i> Registro de Banco');
            botonModal.val("registrar");
            botonModal.html('<i class="bi bi-save"></i> Registrar');
            inputCodBanco.val("");
            inputNombre.val("");
            break
        case "Actualizar":
            encabezadoModal.html('<i class="bi bi-ev-front me-2"></i> Actualizacion de Banco');
            botonModal.val("actualizar");
            botonModal.html('<i class="bi bi-save"></i> Actualizar');

            if (cod_banco != "" && estado == 1) {
                inputCodBanco.val(cod_banco);
                inputNombre.val(nombre);
            } else {
                inputCodBanco.val("Error: Registro inactivo");
                inputNombre.val("Error: Registro inactivo");
            }
            break
    }
}
