function instanciarDatatableGlobal(idTabla) {
    const objDatatable = $(idTabla).DataTable({
        language: {
            url: 'assets/json/datatable.json'
        },
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
        order: [],
    });
    return objDatatable;
}

function ajaxConsultarGlobal(modulo,datos = null ,devolverDatos) {
    $.ajax({
        url: `index.php?url=${modulo}`,
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: "consultar",
            datos: datos
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Procesando...',
                text: 'Por favor espere un momento.',
                allowOutsideClick: false,
                didOpen: () => {
                    if (document.activeElement) document.activeElement.blur();
                    Swal.showLoading();
                }
            });
        }
    })
        .done(function (response) {
            if (typeof devolverDatos === "function") {
                devolverDatos(response);
            }
        })
        .fail(function (xhr, status, error) {
            console.error("Error al cargar los datos:", error);
            console.log("Respuesta cruda del servidor:", xhr.responseText);
        })
        .always(function () {
            Swal.close();
        })
}


function datatableServer(idTabla, modulo, colunms) {
    const objDatatable = $(idTabla).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `index.php?url=${modulo}`,
            type: 'POST',
            data: { tipoSolicitud: 'consultar' }

        },
        language: {
            url: 'assets/json/datatable.json'
        },
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 20, 30, -1], [10, 20, 30, "Todos"]],           // Cantidad inicial por página
        order: [[1, 'asc']],     // Orden inicial por columna 1 (Estado ASC)
        columns: colunms
    });
    return objDatatable;
}

function ajaxEnvioDatosGlobal(moduloNombre, solicitud, funcConsultar, objTabla = null, datos = null, modal = null, btnEnviar = null) {

    $.ajax({
        url: `index.php?url=${moduloNombre}`,
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: solicitud,
            datos: datos
        },
        beforeSend: function () {
            if (modal != null) {
                modal.hide();
                $(btnEnviar).attr("disabled", true);
            }
            Swal.fire({
                title: 'Procesando...',
                text: 'Por favor espere un momento.',
                allowOutsideClick: false,
                didOpen: () => {
                    if (document.activeElement) document.activeElement.blur();
                    Swal.showLoading();
                }
            });
        }
    })
        .done(function (response) {
            console.log("Respuesta del servidor:", response);
            mostrarAlerta(response.status, response.message);

            if (typeof funcConsultar === "function") {
                // Cuando se usa instanciarDatatableGlobal + dibujarTabla
                funcConsultar(objTabla);
            } else if (objTabla != null && objTabla.ajax && typeof objTabla.ajax.reload === "function") {
                // Cuando funcConsultar es null y se usa datatableServer (serverSide)
                objTabla.ajax.reload(null, false);
            }
        })
        .fail(function (xhr, status, error) {
            console.error("Error al cargar los datos:", error);
            console.log("Respuesta cruda del servidor:", xhr.responseText);
        })
        .always(function () {
            if (btnEnviar != null) {
                $(btnEnviar).prop("disabled", false);
            }
        });

}

function mostrarAlerta(status, mensaje) {
    // Usamos un pequeño retraso para asegurar que la página esté completamente cargada
    setTimeout(() => {
        let title, text, icon;

        switch (status) {
            case 'success':
                title = "Registro exitoso!";
                text = mensaje;
                icon = "success";
                break;
            case 'updated':
                title = "Actualización exitosa!";
                text = mensaje;
                icon = "success";
                break;
            case 'deleted':
                title = "Eliminación exitosa!";
                text = mensaje;
                icon = "success";
                break;
            case 'exists':
                title = "Registro existente!";
                text = mensaje;
                icon = "warning";
                break;
            case 'empty':
                title = "Campos vacíos!";
                text = "Uno o más campos están vacíos.";
                icon = "warning";
                break;
            case 'error':
                title = "Error!";
                text = mensaje;
                icon = "error";
                break;
            case 'exception':
                title = "Exception Retornada!";
                text = `El servidor devolvio el siguiente mensaje: ${mensaje}`;
                icon = "error";
                break;
        }

        if (title && text && icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon
            });
        }
    }, 100);
}