$(document).ready(function () {

    const miTabla = instanciarDatatableGlobal('#tablaMoneda');

    dibujarTabla(miTabla);

    const modal = $('#modalMoneda');

    if (modal) {
        modal.on('show.bs.modal', event => {

            const boton = event.relatedTarget;

            AccionModal(boton);
        })

        $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
            event.preventDefault();
            const datos = {
                cod_moneda: $("#cod-moneda").val(),
                nombre_moneda: $("#nombre_moneda").val(),
                abreviatura:$('#abreviatura').val()
            }

            const btnEnviar = this;
            const solicitud = $(this).val();

            const objmodal = bootstrap.Modal.getInstance(modal) ?? '';
            ajaxEnvioDatosGlobal('moneda', solicitud, dibujarTabla, miTabla, datos, objmodal, btnEnviar);
        });
    }

    $("#tablaMoneda tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();

        const codmoneda = this.getAttribute("datos-cod-moneda");

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
                ajaxEnvioDatosGlobal('moneda', 'eliminar', dibujarTabla, miTabla, { cod_moneda: codmoneda }, null, null)
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
    const modulo = 'moneda';
    ajaxConsultarGlobal(modulo, (response) => {

        objTable.clear();

        let lista = Array.isArray(response) ? response : [];

        if (lista.length > 0) {
            $.each(lista, function (index, dato) {

                const botones = ` <td class="text-start pe-4">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Modificar" data-bs-toggle="modal" data-bs-target="#modalMoneda"
                                 datos-cod-moneda="${dato.cod_moneda}"
                                 datos-nombre="${dato.nombre}"
                                 datos-abreviatura="${dato.abreviatura}"
                                 datos-estado="${dato.estado}"
                                 >
                                 <i class="bi bi-pencil"></i>
                             </button>
                         <a href="#" class="text-secondary btn-eliminar"
                                 datos-cod-moneda="${dato.cod_moneda}" >
                                 <i class="bi bi-trash"></i>
                         </a>
                     </td>`;

                objTable.row.add([
                    dato.abreviatura,
                    dato.nombre,
                    botones
                ])
            });
            objTable.draw();
        } else {
            objTable.row.add([
                'No se encontraron registros.',
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
    botonModal.prop("disabled", false);
    
    const cod_moneda = $(boton).attr('datos-cod-moneda');
    const nombre = $(boton).attr('datos-nombre');
    const abreviatura = $(boton).attr('datos-abreviatura');
    const estado = $(boton).attr('datos-estado');
    // Obtener referencias a los campos del formulario dentro del modal
    const inputCodMoneda = $('#cod-moneda')
    const inputNombre = $('#nombre_moneda')
    const inputAbreviatura = $('#abreviatura')

    switch ($(boton).attr('title')) {
        case "Registrar":
            encabezadoModal.html('<i class="bi bi-coin"></i> Registro de Moneda');
            botonModal.val("registrar");
            botonModal.html('<i class="bi bi-save"></i> Registrar');
            inputCodMoneda.val("");
            inputNombre.val("");
            inputAbreviatura.val("");
            break;
        case "Modificar":

            encabezadoModal.html('<i class="bi bi-coin"></i> Modificación de Moneda');
            botonModal.val("modificar");
            botonModal.html('<i class="bi bi-pencil"></i> Modificar');


            if (cod_moneda != "" && estado == 1) {
                // Asignar los valores obtenidos a los campos del formulario
                inputCodMoneda.val(cod_moneda);
                inputNombre.val(nombre);
                inputAbreviatura.val(abreviatura);
            } else {
                inputCodMoneda.value = "Error: Registro inactivo";
                inputNombre.value = "Error: Registro inactivo";
                inputAbreviatura.value = "Error: Registro inactivo";
            }
            break;
    }
}