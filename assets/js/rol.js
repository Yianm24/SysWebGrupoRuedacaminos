$(document).ready(function () {

    const miTabla = instanciarDatatableGlobal('#tablaRol');

    dibujarTabla(miTabla);

    const modal = $('#modalRol');

    if (modal) {
        modal.on('show.bs.modal', event => {

            const boton = event.relatedTarget;

            AccionModal(boton);
        })

        $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
            event.preventDefault();
            const datos = {
                cod_rol: $("#cod-rol").val(),
                nombre_rol: $("#nombre").val()
            }

            const btnEnviar = this;

            const solicitud = $(this).val();

            const objmodal = bootstrap.Modal.getInstance(modal) ?? '';
            ajaxEnvioDatosGlobal('rol', solicitud, dibujarTabla, miTabla, datos, objmodal, btnEnviar);

        });
    }


    $("#tablaRol tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();

        const codrol = this.getAttribute("datos-cod-rol");

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
                ajaxEnvioDatosGlobal('rol', 'eliminar', dibujarTabla, miTabla, { cod_rol: codrol }, null, null)
            }
        });
    });


    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const mensaje = urlParams.get('msg');


    if (status) {
        mostrarAlerta(status, mensaje)
    }
});

function dibujarTabla(objTable) {

    const modulo = 'rol';
    ajaxConsultarGlobal(modulo, (response) => {

        objTable.clear();

        const lista = Array.isArray(response) ? response : [];

        if (lista.length > 0) {

            $.each(lista, function (index, dato) {

                    //console.log(dato.cod_rol);
                const botones = ` <td class="text-start pe-4">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalRol"
                                 datos-cod-rol="${dato.cod_rol}"
                                 datos-nombre="${dato.nombre}"
                                 datos-estado="${dato.estado}"
                                 >
                                 <i class="bi bi-pencil"></i>
                             </button>
                         <a href="#" class="text-secondary btn-eliminar"
                                 datos-cod-rol="${dato.cod_rol}" >
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
    });
}

function AccionModal(boton) {
    const encabezadoModal = $('#modalLabel');
    const botonModal = $('button[name="tipoSolicitud"]');

    const cod_rol = $(boton).attr('datos-cod-rol');
    const nombre = $(boton).attr('datos-nombre');
    const estado = $(boton).attr('datos-estado');

    // Obtener referencias a los campos del formulario dentro del modal
    const inputCodRol = $('#cod-rol')
    const inputNombre = $('#nombre')


    console.log($('#modalLabel'));

    switch ($(boton).attr('title')) {
        case "Registrar":

            encabezadoModal.html('<i class="bi bi-person-badge me-2"></i> Registrar Rol');
            botonModal.val("registrar");
            botonModal.html('<i class="bi bi-save"></i> Registrar');
            inputCodRol.val("");
            inputNombre.val("");
            break

        case "Actualizar":
            encabezadoModal.html('<i class="bi bi-person-badge me-2"></i> Actualizaciar Rol');
            botonModal.val("actualizar");
            botonModal.html('<i class="bi bi-save"></i> Actualizar');

            if (cod_rol != "" && estado == 1) {
                // Asignar los valores obtenidos a los campos del formulario
                inputCodRol.val(cod_rol);
                inputNombre.val(nombre);
            } else {
                inputCodRol.val("Error: Registro inactivo");
                inputNombre.val("Error: Registro inactivo");
            }
            break
    }
}