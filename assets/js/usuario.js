$(document).ready(function () {

    const miTabla = instanciarDatatableGlobal('#tablaUsuario');

    dibujarTabla(miTabla);

    const selectModal = $('select#cod_rol');
    dibujarSelect(selectModal);

    const modal = $('#modalUsuario');

    if (modal.length) {
        modal.on('show.bs.modal', event => {
            const boton = event.relatedTarget;
            accionModal(boton);
        });

        $(modal).on("click", "button[name='tipoSolicitud']", function (event) {
            event.preventDefault();
            const datos = {
                cod_usuario: $('#cod_usuario').val(),
                cedula: $('#cedula').val(),
                password: $('#password').val(),
                nombre_usuario: $('#nombre_usuario').val(),
                cod_rol: $('#cod_rol').val()
            };

            const btnEnviar = this;
            const solicitud = $(this).val();

            const objmodal = bootstrap.Modal.getInstance(modal[0]) ?? null;
            ajaxEnvioDatosGlobal('usuario', solicitud, dibujarTabla, miTabla, datos, objmodal, btnEnviar);
        });
    }

    $("#tablaUsuario tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();
        let codusuario = this.getAttribute('datos-cod-usuario');

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
                ajaxEnvioDatosGlobal('usuario', 'eliminar', dibujarTabla, miTabla, { cod_usuario: codusuario }, null, null);
            }
        });
    });
});


function dibujarTabla(objTable) {
    const modulo = 'usuario';
    ajaxConsultarGlobal(modulo, (response) => {

        objTable.clear();

        let lista = Array.isArray(response) ? response : [];

        if (lista.length > 0) {
            $.each(lista, function (index, dato) {

                const botones = `
                    <div class="text-end pe-3">
                        <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline me-2" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalUsuario"
                            datos-cod-usuario="${dato.cod_usuario}"
                            datos-nombre="${dato.nombre}"
                            datos-cedula="${dato.cedula}"
                            datos-password="${dato.password}"
                            datos-cod-rol="${dato.cod_rol}"
                            datos-estado="${dato.estado}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <a href="#" class="text-secondary btn-eliminar"
                            datos-cod-usuario="${dato.cod_usuario}">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>`;

                objTable.row.add([
                    dato.cedula,
                    dato.nombre,
                    dato.nombrerol,
                    botones
                ]);
            });
        }

        objTable.draw();
    });
}


function dibujarSelect(objtSelect) {
    const modulo = "rol";
    let opciones = "";
    ajaxConsultarGlobal(modulo, (response) => {
        let lista = Array.isArray(response) ? response : [];
        $.each(lista, function (index, dato) {
            opciones += `<option value="${dato.cod_rol}">${dato.nombre}</option>`;
        });
        $(objtSelect).html(opciones);
    });
}

function accionModal(boton) {
    const encabezadoModal = $('#modalLabel');
    const botonModal = $('button[name="tipoSolicitud"]');
    const avisoPassword = $('#avisoPasswordActualizar');

    // Obtener los datos del usuario desde los atributos datos- del botón
    const codusuario = $(boton).attr('datos-cod-usuario');
    const nombre = $(boton).attr('datos-nombre');
    const cedula = $(boton).attr('datos-cedula');
    const password= $(boton).attr('datos-password');
    const rol = $(boton).attr('datos-cod-rol');
    const estado = $(boton).attr('datos-estado');

    // Obtener referencias a los campos del formulario dentro del modal
    const inputCodUsuario = $('#cod_usuario');
    const inputNombre = $('#nombre_usuario');
    const inputCedula = $('#cedula');
    const inputPassword = $('#password');
    const inputRol = $('#cod_rol');

    switch ($(boton).attr('title')) {
        case "Registrar":
            encabezadoModal.html('<i class="bi bi-person-plus me-2"></i> Registro de Usuario');
            botonModal.val("registrar");
            botonModal.html('<i class="bi bi-save"></i> Registrar');
            avisoPassword.addClass('d-none');
            inputCodUsuario.val("");
            inputNombre.val("");
            inputCedula.val("");
            inputPassword.val("");
            inputRol.prop('selectedIndex', 0);
            break;

        case "Actualizar":
            encabezadoModal.html('<i class="bi bi-pencil-square me-2"></i> Actualización de Usuario');
            botonModal.val("actualizar");
            botonModal.html('<i class="bi bi-pencil"></i> Actualizar');
            avisoPassword.removeClass('d-none');

            if (codusuario != "" && estado == 1) {
                inputCodUsuario.val(codusuario);
                inputNombre.val(nombre);
                inputCedula.val(cedula);
                inputPassword.val("");
                inputRol.val(rol);
            } else {
                inputCodUsuario.val("Error: Registro inactivo");
                inputNombre.val("Error: Registro inactivo");
                inputCedula.val("Error: Registro inactivo");
                inputPassword.val("Error: Registro inactivo");
                inputRol.val("Error: Registro inactivo");
            }
            break;
    }
}
