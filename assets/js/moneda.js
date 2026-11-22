$(document).ready(function () {

    const miTabla = instanciarDatatableGlobal('#tablaMoneda');

    dibujarTabla(miTabla);

    const modal = $('#modalMoneda');

    if (modal) {
        modal.on('show.bs.modal', event => {

            const boton = event.relatedTarget;

            AccionModal(boton);
        })

        $("#estado_moneda").on("change", function () {
            if ($(this).is(":checked")) {
                $(this).prop("disabled", true);
                $("#label_estado_moneda").text("Activo");
            }
        });

        $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
            event.preventDefault();
            const datos = {
                cod_moneda: $("#cod-moneda").val(),
                nombre_moneda: $("#nombre_moneda").val(),
                abreviatura: $('#abreviatura').val(),
                estado: $("#estado_moneda").is(":checked") ? 1 : 0
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

});

function dibujarTabla(objTable) {
    const modulo = 'moneda';
    ajaxConsultarGlobal(modulo, (response) => {

        objTable.clear();

        let lista = Array.isArray(response) ? response : [];

        if (lista.length > 0) {
            $.each(lista, function (index, dato) {

                let estadoJS;
                if (dato.estado == 1) {
                    estadoJS = `<span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                    <i class="bi bi-check-circle-fill me-1"></i>Activo
                                </span>`;
                } else if (dato.estado == 0) {
                    estadoJS = `<span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">
                                    <i class="bi bi-x-circle-fill me-1"></i>Inactivo
                                </span>`;
                }


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

                if (ROL_USUARIO != '6') { 
                    
                objTable.row.add([
                    dato.abreviatura,
                    dato.nombre
                ])
                }
                else {

                    objTable.row.add([
                        dato.abreviatura,
                        dato.nombre,
                        estadoJS,
                        botones
                    ])
                }


            });
            objTable.draw();
        } else {
            if (ROL_USUARIO != '6') {
                objTable.row.add([
                    'No se encontraron registros.',
                    'No se encontraron registros.'
                ]);
            } else {
                objTable.row.add([
                    'No se encontraron registros.',
                    'No se encontraron registros.',
                    'No se encontraron registros.',
                    'No se encontraron registros.'
                ]);
            }
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
    const checkEstado = $('#estado_moneda')
    const labelEstado = $('#label_estado_moneda')

    switch ($(boton).attr('title')) {
        case "Registrar":
            encabezadoModal.html('<i class="bi bi-coin"></i> Registro de Moneda');
            botonModal.val("registrar");
            botonModal.html('<i class="bi bi-save"></i> Registrar');
            inputCodMoneda.val("");
            inputNombre.val("");
            inputAbreviatura.val("");
            checkEstado.prop("checked", true).prop("disabled", true);
            labelEstado.text("Activo");
            break;
        case "Modificar":

            encabezadoModal.html('<i class="bi bi-coin"></i> Modificación de Moneda');
            botonModal.val("modificar");
            botonModal.html('<i class="bi bi-pencil"></i> Modificar');

            if (cod_moneda != "") {
                // Asignar los valores obtenidos a los campos del formulario
                inputCodMoneda.val(cod_moneda);
                inputNombre.val(nombre);
                inputAbreviatura.val(abreviatura);

                if (estado == 0) {
                    checkEstado.prop("checked", false).prop("disabled", false);
                    labelEstado.text("Inactivo");
                } else {
                    checkEstado.prop("checked", true).prop("disabled", true);
                    labelEstado.text("Activo");
                }
            }
            break;
    }
}