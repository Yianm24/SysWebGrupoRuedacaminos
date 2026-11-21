function instanciarDatatableGlobal(idTabla) {
    const objDatatable = $(idTabla).DataTable({
        language: {
            url: 'assets/json/datatable.json'
        },
        responsive: true,
        pageLength: 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "Todos"]],
        order: [],
    });
    return objDatatable;
}

function ajaxConsultarGlobal(modulo, devolverDatos) {
    $.ajax({
        url: `index.php?url=${modulo}`,
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: "consultar"
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
        pageLength: 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "Todos"]],           // Cantidad inicial por página
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

            // Fuerza el reinicio de la petición AJAX del DataTable (serverSide)
            if (objTabla != null && objTabla.ajax && typeof objTabla.ajax.reload === "function") {
                objTabla.ajax.reload(null, false);

            } else if (typeof funcConsultar === "function") {
                //esto es cuando se usa la api de datatable
                funcConsultar(objTabla);
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
                text = `Se produjo un error en el proceso de ${mensaje}.`;
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