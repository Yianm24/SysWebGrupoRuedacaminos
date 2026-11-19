$(document).ready(function () {
    const moduloActual = "cargo";
    const tablaSelector = "#tablaCargo";

    //const dataTable = instanciarDatatableGlobal('table#tablaCargo');
    const otraDataTable = $(tablaSelector).DataTable({
        processing: true ,
        serverSide: true,
        ajax:{
            url: `index.php?url=cargo`,
            type: "POST",
            data:{
                tipoSolicitud: 'datatable'
            }
        },
        columns: [
            {data: 'cod_cargo'},
            {data: 'estado'},
            {data: 'nombre'}
            ],
            language: {
            url: 'assets/json/datatable.json'
        },
        responsive: true,
        pageLength: 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "Todos"]],
        order: [],
    }); 
    ajaxConsultarCargo(otraDataTable);
    const modalCargo = $('#modalCargo');
    let hasChanged = false;

    //Jquery validate
    $('#formCargo').validate({
        rules: {
            nombre: {
                required: true,
                //noSpace: true,
                minlength: 3,
                maxlength: 15,
            }
        },
        messages: {
            nombre: {
                required: "Debes ingresar el nombre del cargo.",
                //noSpace: "El cargo no puede contener solo espacios.",
                minlength: "El cargo debe tener al menos 3 letras.",
                maxlength: "El cargo no puede superar las 15 letras."
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) { element.siblings('.mensaje-error').text(error.text()).show(); },
        highlight: function (element) { $(element).addClass('is-invalid').removeClass('is-valid'); },
        unhighlight: function (element) { $(element).addClass('is-valid').removeClass('is-invalid').siblings('.mensaje-error').hide().text(''); },

        onkeyup: function (element) { $(element).valid(); if ($('#btnSubmitModal').val() === 'modificar') hasChanged = true; evaluarBoton(); },
        onfocusout: function (element) { $(element).valid(); if ($('#btnSubmitModal').val() === 'modificar') hasChanged = true; evaluarBoton(); }
    });

    $('#btnSubmitModal').on('click', function (event) {
        event.preventDefault();

        //Verificar  que todo el formulario sea válido antes de enviar
        if ($('#formCargo').valid()) {
            const btnEnviar = $(this);
            let solicitud = btnEnviar.val();

            if (solicitud === "modificar" && $('#formCargo').attr('data-nombre-original') === $("#nombre").val()) {
                Swal.fire({ title: "Sin modificaciones", text: "El nombre ingresado es igual al actual.", icon: "info" });
                return false;
            }

            const datos = { cod_cargo: $("#cod_cargo").val(), nombre: $("#nombre").val() };
            const objModal = bootstrap.Modal.getInstance(modalCargo[0]);

            //Llamamado a AJAX GLOBAL
            ajaxEnvioDatosGlobal('cargo', solicitud, ajaxConsultarCargo,dataTable, datos, objModal, btnEnviar)
        }
    });

    $('#nombre').on('input', function () { if ($('#btnSubmitModal').val() === 'modificar') { hasChanged = true; evaluarBoton(); } });

    function evaluarBoton() {
        let esValido = $('#formCargo').validate().checkForm();
        let btnEnviar = $('#btnSubmitModal');
        btnEnviar.prop('disabled', btnEnviar.val() === 'modificar' ? !(esValido && hasChanged) : !esValido);
    }

    if (modalCargo.length) {
        modalCargo.on('show.bs.modal', function (event) { accionModalCargo($(event.relatedTarget)); });
        modalCargo.on('shown.bs.modal', function () { if (document.activeElement) document.activeElement.blur(); });
    }

    //Alerta Confirmar Eliminación
    $(tablaSelector + " tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        const codCargo = $(this).attr("data-id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success ms-2",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Está seguro que desea eliminar este cargo?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            reverseButtons: true,
            didOpen: () => { if (document.activeElement) document.activeElement.blur(); }
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxEnvioDatosGlobal('cargo', 'eliminar',ajaxConsultarCargo, dataTable, {cod_cargo:codCargo},null,null)

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelado",
                    text: "Eliminación del cargo cancelada.",
                    icon: "error"
                });
            }
        });
    });


    function ajaxConsultarCargo(dataTable) {
        ajaxConsultarGlobal(moduloActual, function (response) {

            let button = ''

            dataTable.clear()

            // Inyectar datos en el HTML
            if (Array.isArray(response) && response.length > 0) {
                let rowsHtml = "";
                $.each(response, function (index, dato) {

                    button = `<button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Modificar" data-bs-toggle="modal" data-bs-target="#modalCargo" datos-cod-cargo="${dato.cod_cargo}" datos-nombre="${dato.nombre}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar ms-2" title="Eliminar" data-id="${dato.cod_cargo}">
                                    <i class="bi bi-trash"></i>
                                </button>`

                    dataTable.row.add([

                        dato.nombre,
                        button,
                    ])

                });

                dataTable.draw()
            } else {

                dataTable.row.add([

                    'No hay cargos registrados',
                ])
            }
        });
    }

    function accionModalCargo(boton) {
        hasChanged = false;
        $('#formCargo').validate().resetForm();
        $('#nombre').removeClass('is-valid is-invalid').val("").siblings('.mensaje-error').hide();
        $('#cod_cargo').val("");

        if (boton.attr('title') === "Registrar") {
            $('#modalLabel').html('<i class="bi bi-person-badge"></i> Registrar Nuevo Cargo');
            $('#btnSubmitModal').val("registrar").html('<i class="bi bi-save"></i> Registrar').prop('disabled', true);
        } else if (boton.attr('title') === "Modificar") {
            $('#modalLabel').html('<i class="bi bi-pencil-square"></i> Modificar Cargo');
            $('#cod_cargo').val(boton.attr('datos-cod-cargo'));
            $('#nombre').val(boton.attr('datos-nombre'));
            $('#formCargo').attr('data-nombre-original', $('#nombre').val());
            $('#btnSubmitModal').val("modificar").html('<i class="bi bi-save"></i> Guardar').prop('disabled', true);
        }
    }
});