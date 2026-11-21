$(document).ready(function () {

    const selectModal = $('select#cod_estado');
    // console.log(selectModal);

    dibujarSelect(selectModal)

    const colunms = [
        { data: 'Municipio' },
        { data: 'Estado' },
        { data: 'botones' }

    ]

  const tablaServer= datatableServer('#tablaMunicipio', 'municipio', colunms);

    const modal = $('#modalMunicipio');

    if (modal) {
        modal.on('show.bs.modal', event => {
            // Obtener acceso al botón que disparó el modal
            const boton = event.relatedTarget;
            accionModal(boton);

        });

        $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
            event.preventDefault();
            const datos = {
                cod_municipio: $("#cod-municipio").val(),
                nombre_municipio: $("#nombre_municipio").val(),
                cod_estado: $('#cod_estado').val()
            }

            const btnEnviar = this;

            const solicitud = $(this).val();
            console.log(solicitud);

            const objmodal = bootstrap.Modal.getInstance(modal) ?? '';
            ajaxEnvioDatosGlobal('municipio', solicitud, null, tablaServer, datos, objmodal, btnEnviar);
           
        });
    }

    $("#tablaMunicipio tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        let codmunicipio = this.getAttribute('datos-cod-municipio');

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
                ajaxEnvioDatosGlobal('municipio', 'eliminar', null, tablaServer, { cod_municipio: codmunicipio }, null, null)
            }
        });
    });

});

function dibujarSelect(objtSelect) {

    const modulo = "estado";

    let opciones = "";
    ajaxConsultarGlobal(modulo, (response) => {

        $.each(response, function (index, dato) {
            opciones += `
         <option value=${dato.cod_estado}>${dato.nombre}</option>
        `
        })
        $(objtSelect).html(opciones);

    })
}

function accionModal(boton) {
    const encabezadoModal = $('#modalLabel');
    const botonModal = $('button[name="tipoSolicitud"]');

    //Obtener los datos del vehículo desde los atributos datos- del botón
    const codmunicipio = $(boton).attr('datos-cod-municipio');
    const nombre = $(boton).attr('datos-nombre');
    const codestado = $(boton).attr('datos-cod-estado');
    const estado = $(boton).attr('datos-estado');

    // Obtener referencias a los campos del formulario dentro del modal
    const inputCodMunicipio = $('#cod-municipio');
    const inputNombre = $('#nombre_municipio');
    const inputEstado = $('#cod_estado');

    switch ($(boton).attr('title')) {
        case "Registrar":

            encabezadoModal.html('<i class="bi bi-car-front me-2"></i> Registro de Municipio');
            botonModal.val("registrar");
            botonModal.html('<i class="bi bi-save"></i> Registrar');
            inputCodMunicipio.val("");
            inputNombre.val("");
            inputEstado.val("");
            $('#cod_estado').prop('selectedIndex', 0);

            break;
        case "Modificar":
            encabezadoModal.html('<i class="bi bi-car-front me-2"></i> Modificacion de Municipio');
            botonModal.val("modificar");
            botonModal.html('<i class="bi bi-pencil"></i> Modificar');

            if (codestado != "" && estado == 1) {
                // Asignar los valores obtenidos a los campos del formulario
                inputCodMunicipio.val(codmunicipio);
                inputNombre.val(nombre);
                inputEstado.val(codestado);
            } else {
                inputCodMunicipio.val("Error: Registro inactivo");
                inputNombre.val("Error: Registro inactivo");
                inputEstado.val("Error: Registro inactivo");
            }
            break;
    }
}
