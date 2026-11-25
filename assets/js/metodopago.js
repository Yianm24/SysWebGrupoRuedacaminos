$(document).ready(function () {


    const miTabla = instanciarDatatableGlobal('#tablaMetodopago');

    dibujarTabla(miTabla);

    const selectModal = $('select#cod_moneda');

    dibujarSelect(selectModal);


    const modal = $('#modalMetodoPago');

    if (modal) {
        modal.on('show.bs.modal', event => {
            const boton = event.relatedTarget;
            accionModal(boton);
        });

        $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
            event.preventDefault();
            const datos = {
                cod_metodopago: $("#cod_metodopago").val(),
                nombre_metodopago: $("#nombre_metodopago").val(),
                cod_moneda: $('#cod_moneda').val()
            };


            const btnEnviar = this;

            const solicitud = $(this).val();
            console.log(solicitud);

            const objmodal = bootstrap.Modal.getInstance(modal) ?? '';
            ajaxEnvioDatosGlobal('metodopago', solicitud, dibujarTabla, miTabla, datos, objmodal, btnEnviar);

        });
    }

    $("#tablaMetodopago tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        let codmetodo = this.getAttribute('datos-cod-metodopago');

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
                ajaxEnvioDatosGlobal('metodopago', 'eliminar', dibujarTabla, miTabla, { cod_metodopago: codmetodo }, null, null);
            }
        });
    });
});


function dibujarTabla(objTable) {
    const modulo = 'metodopago';
    ajaxConsultarGlobal(modulo, (response) => {

        objTable.clear();

        let lista = Array.isArray(response) ? response : [];

        if (lista.length > 0) {
            $.each(lista, function (index, dato) {

                const botones = `
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalMetodoPago"
                                 datos-cod-metodopago="${dato.cod_metodo}"
                                 datos-nombre="${dato.nombre}"
                                 datos-cod-moneda="${dato.cod_moneda}"
                                 datos-estado="${dato.estado}"
                                 >
                                 <i class="bi bi-pencil"></i>
                             </button>
                         <a href="#" class="text-secondary btn-eliminar"
                                 datos-cod-metodopago="${dato.cod_metodo}" >
                                 <i class="bi bi-trash"></i>
                         </a>`;

                objTable.row.add([
                    dato.nombre,
                    dato.nombremoneda,
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

function dibujarSelect(objtSelect) {

    const modulo = "moneda";

    let opciones = "";
    ajaxConsultarGlobal(modulo, (response) => {

        $.each(response, function (index, dato) {
            opciones += `
         <option value=${dato.cod_moneda}>${dato.abreviatura}</option>
        `;
        });
        $(objtSelect).html(opciones);

    });
}

function accionModal(boton) {
    const encabezadoModal = $('#modalLabel');
    const botonModal = $('button[name="tipoSolicitud"]');

    // Obtener los datos desde los atributos datos- del botón
    const codmetodopago = $(boton).attr('datos-cod-metodopago');
    const nombre = $(boton).attr('datos-nombre');
    const codmoneda = $(boton).attr('datos-cod-moneda');
    const estado = $(boton).attr('datos-estado');

    // Obtener referencias a los campos del formulario dentro del modal
    const inputCodMetodo = $('#cod_metodopago');
    const inputNombre = $('#nombre_metodopago');
    const inputCodMoneda = $('#cod_moneda');

    switch ($(boton).attr('title')) {
        case "Registrar":
            encabezadoModal.html('<i class="bi bi-coin me-2"></i> Registro de Método de Pago');
            botonModal.val("registrar");
            botonModal.html('<i class="bi bi-save"></i> Registrar');
            inputCodMetodo.val("");
            inputNombre.val("");
            inputCodMoneda.val("");
            $('#cod_moneda').prop('selectedIndex', 0);

            break;
        case "Actualizar":
            encabezadoModal.html('<i class="bi bi-coin me-2"></i> Actualizacion de Método de Pago');
            botonModal.val("actualizar");
            botonModal.html('<i class="bi bi-pencil"></i> Actualizar');

            if (codmetodopago != "" && estado == 1) {
                // Asignar los valores obtenidos a los campos del formulario
                inputCodMetodo.val(codmetodopago);
                inputNombre.val(nombre);
                inputCodMoneda.val(codmoneda);
            } else {
                inputCodMetodo.val("Error: Registro inactivo");
                inputNombre.val("Error: Registro inactivo");
                inputCodMoneda.val("Error: Registro inactivo");
            }
            break;
    }
}
