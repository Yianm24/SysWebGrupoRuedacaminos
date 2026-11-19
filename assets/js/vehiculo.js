$(function () {
    const objDatatable = instanciarDatatableGlobal('#tablaVehiculo');
    dibujarTabla (objDatatable);
    
    const modal = $('#modalVehiculo');

    if (modal) {
        modal.on('show.bs.modal', function (event) {

            const boton = $(event.relatedTarget);
            AccionModal(boton);
        });
        $(modal).on('click','button[name=tipoSolicitud]',function(evento){
            evento.preventDefault();
            datos = {
                cod_vehiculo:$('#cod_vehiculo').val(),
                placa: $('#placa').val(),
                color: $('#color').val(),
                modelo: $('#modelo').val(),
                anio: $('#anio').val(),
                anchura: $('#anchura').val(),
                altura: $('#altura').val(),
                peso_max: $('#peso_max').val()
            }
            console.log(datos);
            objModal = bootstrap.Modal.getInstance(modal) ?? '';

            ajaxEnvioDatosGlobal('vehiculo',$(this).val(),dibujarTabla,objDatatable,datos,objModal,this)
        })

    }

    // Modal Eliminar (con delegación de eventos por si la tabla se recarga dinámicamente)
    $(document).on('click', '.btn-eliminar', function (event) {
        event.preventDefault();
        const codvehiculo = $(this).data('cod-vehiculo');

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
            }
        });
    });
});

function AccionModal(boton) {
    const encabezadoModal = $('#modalLabel');
    const botonModal = $('button[name="tipoSolicitud"]');

    // Obtener los datos del vehículo desde los atributos datos- del botón
    const cod_vehiculo = $(boton).data('cod-vehiculo');
    const placa = $(boton).data('placa');
    const color = $(boton).data('color');
    const anio = $(boton).data('anio');
    const anchura = $(boton).data('anchura');
    const altura = $(boton).data('altura');
    const peso_max = $(boton).data('peso-max');
    const modelo = $(boton).data('modelo');
    const estado = $(boton).data('estado');

    // Obtener referencias a los campos del formulario dentro del modal
    // Referencias directas por ID a los campos del formulario
    const inputCodVehiculo = $('#cod_vehiculo');
    const inputPlaca = $('#placa');
    const inputColor = $('#color');
    const inputAnio = $('#anio');
    const inputAnchura = $('#anchura');
    const inputAltura = $('#altura');
    const inputPesoMax = $('#peso_max');
    const inputModelo = $('#modelo');

    switch (boton.attr('title')) {
        case "Registrar":
            encabezadoModal.html('<i class="bi bi-truck me-2"></i> Registro de Vehículo');
            botonModal.val("registrar").html('<i class="bi bi-save"></i> Registrar');

            inputCodVehiculo.val("");
            inputPlaca.val("");
            inputColor.val("");
            inputAnio.val("");
            inputAnchura.val("");
            inputAltura.val("");
            inputPesoMax.val("");
            inputModelo.val("").prop('selectedIndex', 0);
            break;

        case "Actualizar":
            encabezadoModal.html('<i class="bi bi-truck me-2"></i> Actualización de Vehículo');
            botonModal.val("actualizar").html('<i class="bi bi-pencil"></i> Actualizar');

            if (cod_vehiculo !== "" && estado == 1) {
                inputCodVehiculo.val(cod_vehiculo);
                inputPlaca.val(placa);
                inputColor.val(color);
                inputAnio.val(anio);
                inputAnchura.val(anchura);
                inputAltura.val(altura);
                inputPesoMax.val(peso_max);
                inputModelo.val(modelo);
            } else {
                const msgError = "Error: Registro inactivo";
                inputPlaca.val(msgError);
                inputColor.val(msgError);
                inputAnio.val(msgError);
                inputAnchura.val(msgError);
                inputAltura.val(msgError);
                inputPesoMax.val(msgError);
                inputModelo.val(msgError);
                console.log("No se puede editar el registro, ya que está inactivo.");
            }
            break;
    }

}

function dibujarTabla(objTabla){
    const modulo = 'vehiculo';
    ajaxConsultarGlobal(modulo, (response)=>{
        objTabla.clear();
        const lista = Array.isArray(response.vehiculos) ? response.vehiculos : [];
        console.log(lista);
        if(lista.length > 0){
            $.each(lista, function (index, dato){
                const botones =`
                <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalVehiculo"
                    data-cod-vehiculo="${dato.cod_vehiculo}"
                    data-placa="${dato.placa}"
                    data-color="${dato.color}"
                    data-anio="${dato.anio}"
                    data-anchura="${dato.anchura}"
                    data-altura="${dato.altura}"
                    data-peso-max="${dato.peso_max}"
                    data-modelo="${dato.cod_modelo}"
                    data-estado="${dato.estado}">
                    <i class="bi bi-pencil"></i>
                </button>

                <a href="#" class="text-secondary btn-eliminar"
                    data-cod-vehiculo="${dato.cod_vehiculo}">
                    <i class="bi bi-trash"></i>
                </a>
                `;

                objTabla.row.add([
                    dato.placa,
                    dato.color,
                    dato.nombremodelo,
                    dato.anio,
                    dato.anchura,
                    dato.altura,
                    dato.peso_max,
                    botones
                ])
            })
        }
    objTabla.draw();
    // Aprovechar la misma respuesta para llenar el select de modelos
        const modelos = Array.isArray(response.modelos) ? response.modelos : [];
        llenarSelectModelos(modelos);        
    })
}
function llenarSelectModelos(modelos) {
    const selectModelo = $('#modelo');
    let opciones = '';

    $.each(modelos, function (index, modelo) {
       opciones += `<option value="${modelo.cod_modelo}">${modelo.nombre}</option>`;
    });
    selectModelo.html(opciones);
}