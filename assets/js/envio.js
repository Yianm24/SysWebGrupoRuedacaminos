document.addEventListener("DOMContentLoaded", () => {
    ajaxConsultar();


    //console.log(direccionOrigen);

    $('button[name="tipoSolicitud"]').on("click", function (event) {
        event.preventDefault();
        const datos = { ancho: $("#ancho").val(), alto: $("#alto").val(), descripcion: $("#descripcion").val(), peso_total: $("#peso_total").val(), kilometraje: $('input[name="kilometraje"').val() };
        // console.log(datos);
        const modal = bootstrap.Modal.getInstance($('#carouselEnvio'));

        const remitente = obtenerValoreCliente('remitente', 'rem');
        const destinatario = obtenerValoreCliente('destinatario', 'dest');
        let articulosFragil = { fragil: $("#fragil").is(":checked") };
        let despacho = {
            municipio: $('#municipio_origen').val(),
            direccion: $('textarea[name="direccion_origen"]').val().trim()
        };

        const destino = {
            municipio: $('#municipio_destino').val(),
            direccion: $('textarea[name="direccion_destino"]').val().trim()
        };

        // console.log("Remitente");
        // console.log(remitente);
        // console.log("---------------------");
        // console.log("Destinatario");
        // console.log(destinatario);
        //console.log(destino.direccion);

        const btnEnviar = this;

        let solicitud = "crear";

        ajaxEnvioDatos(modal, solicitud, btnEnviar, datos, remitente, destinatario, articulosFragil, despacho, destino);

    })



    function obtenerValoreCliente(tipoCliente, abrev) {

        let cliente = {};
        if ($(`#persona_natural_${tipoCliente}`).is(":checked")) {
            cliente = {
                tipo_document: $(`#${abrev}_documento_natural`).val(),
                cedula: $(`#${abrev}_cedula`).val(),
                nombre: $(`#${abrev}_nombre`).val(),
                apellido: $(`#${abrev}_apellido`).val(),
                correo: $(`#${abrev}_correo`).val(),
                telefono: $(`#${abrev}_telefono`).val(),
            }
        } else if ($(`#persona_juridica_${tipoCliente}`).is(":checked")) {
            cliente = {
                tipo_document: $(`#${abrev}_documento_juridico`).val(),
                rif: $(`#${abrev}_rif`).val(),
                razon_social: $(`#${abrev}_razon_social`).val(),
                correo: $(`#${abrev}_correo`).val(),
                telefono: $(`#${abrev}_telefono`).val()
            }
        }

        return cliente;

    }



    //Variables para el remitente
    const radioNaturalRem = document.getElementById("persona_natural_remitente");
    const radioJuridicaRem = document.getElementById("persona_juridica_remitente");
    const camposNaturalRem = document.getElementById("rem_campos_natural");
    const camposJuridicoRem = document.getElementById("rem_campos_juridico");

    //Variables para el destinatario
    const radioNaturalDest = document.getElementById("persona_natural_destinatario");
    const radioJuridicaDest = document.getElementById("persona_juridica_destinatario");
    const camposNaturalDest = document.getElementById("dest_campos_natural");
    const camposJuridicoDest = document.getElementById("dest_campos_juridico");

    // 2. Función que evalúa cuál radio está seleccionado y cambia las clases
    function actualizarFormulario(tipoCliente) {


        switch (tipoCliente) {

            case "remitente":
                if (radioJuridicaRem.checked) {
                    // Si Jurídica está seleccionada, mostramos jurídico y ocultamos natural
                    camposJuridicoRem.classList.remove("d-none");
                    camposNaturalRem.classList.add("d-none");
                } else {
                    // Si Natural está seleccionada, mostramos natural y ocultamos jurídico
                    camposNaturalRem.classList.remove("d-none");
                    camposJuridicoRem.classList.add("d-none");
                }
                break;

            case "destinatario":
                if (radioJuridicaDest.checked) {
                    // Si Jurídica está seleccionada, mostramos jurídico y ocultamos natural
                    camposJuridicoDest.classList.remove("d-none");
                    camposNaturalDest.classList.add("d-none");
                } else {
                    // Si Natural está seleccionada, mostramos natural y ocultamos jurídico
                    camposNaturalDest.classList.remove("d-none");
                    camposJuridicoDest.classList.add("d-none");
                }
                break;

        }
    }

    $('input[name="kilometraje"').on('keydown', function (e) {


        if (e.key === 'Enter') {
            e.preventDefault();
            const kilometraje = $(this).val()

            const costoEnvio = kilometraje * 2.36;

            $('span#precio_envio').text(costoEnvio.toFixed(2));
            console.log("Costo de envío calculado:", costoEnvio);
        }
    })



    // 3. Asignamos el evento 'change' a ambos inputs radio
    radioNaturalRem.addEventListener("change", () => actualizarFormulario("remitente"));
    radioJuridicaRem.addEventListener("change", () => actualizarFormulario("remitente"));

    radioNaturalDest.addEventListener("change", () => actualizarFormulario("destinatario"));
    radioJuridicaDest.addEventListener("change", () => actualizarFormulario("destinatario"));
    actualizarFormulario();


    const pesoSumarInput = document.getElementById('peso_sumar');
    const pesoTotalInput = document.getElementById('peso_total');
    const btnSumarPeso = document.getElementById('btn_sumar_peso');
    const btnResetPesoTotal = document.getElementById('btn_reset_pesoTotal');

    pesoTotalInput.value = 0; // Inicializamos el valor del peso total a 0

    function sumarPesoTotal() {
        if (pesoSumarInput.value.trim() >= 0) {
            let pesoSumar = parseFloat(pesoSumarInput.value);
            let pesoTotal = parseFloat(pesoTotalInput.value);
            pesoTotal += pesoSumar;
            pesoTotalInput.value = pesoTotal.toFixed(2); // Actualizamos el valor del input con dos decimales
            pesoSumarInput.value = 0; // Limpiamos el input de peso a sumar
        } else {
            alert("Por favor, ingrese un número válido para el peso.");
        }
    }

    btnSumarPeso.addEventListener('click', sumarPesoTotal);
    pesoSumarInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            sumarPesoTotal();
        }
    });

    btnResetPesoTotal.addEventListener('click', () => {
        pesoTotalInput.value = 0; // Reiniciamos el valor del peso total a 0
    });


    $("#tablaEnvio tbody").on("click", ".btn-eliminar", function (event) {
        event.preventDefault();

        const codenvio = this.getAttribute("data-cod-envio");

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
                ajaxEnvioDatos(null, 'eliminar', null, { cod_envio: codenvio });
            }
        });
    });
});

function ajaxConsultar() {
    iconoCargar("#tablaEnvio tbody");
    $.ajax({
        url: "index.php?url=envio",
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: "consultar"
        }
    })
        .done(function (response) {

            let tbody = $("#tablaEnvio tbody");
            tbody.empty();

            let lista = Array.isArray(response) ? response : ['error al obtener los datos'];

            if (lista.length > 0) {
                let rowsHtml = "";

                $.each(lista, function (index, dato) {
                    rowsHtml += `
                        <tr class="align-middle">
                            <td class="ps-4 fw-semibold text-dark py-3">
                                ${dato.rem_doc} - ${dato.rem_nombre} ${dato.rem_apellido}
                            </td>
                            <td>
                                <span class="fw-medium">
                                ${dato.dest_doc} - ${dato.dest_nombre} ${dato.dest_apellido}
                                </span>
                            </td>
                            <td class="py-3">
                                ${dato.direccion_destino}
                            </td>
                            <td class="text-secondary py-3">${dato.descrip_contenido}</td>
                            <td class="text-secondary fw-medium py-3">${dato.peso_total}</td>
                            <td class="text-secondary fw-medium py-3">${dato.estatus}</td>
                            <td class="text-secondary py-3">
                                ${dato.fecha}
                            </td>
                            <td class="text-start pe-4">
                              
                                <a href="#" class="text-secondary btn-eliminar" data-cod-envio="${dato.cod_envio}">
                                <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>`;
                });

                tbody.html(rowsHtml);
            } else {
                tbody.html(`
    <tr>
      <td colspan="2" class="text-center text-muted py-3">
        No se encontraron registros.
      </td>
    </tr>
  `);
            }
        })
        .fail(function (xhr, status, error) {
            console.error("Error al cargar los datos:", error);
            console.log("Respuesta cruda del servidor:", xhr.responseText);
        })
}


function ajaxEnvioDatos(modal = null, solicitud, btnEnviar, datos, datosRemitente, datosDestinatarios, articulosFragil, despacho, destino) {

    iconoCargar("#tablaEnvio tbody");
    $.ajax({
        url: 'index.php?url=envio',
        type: "POST",
        dataType: "json",
        data: {
            tipoSolicitud: solicitud,
            datos: datos,
            remitente: datosRemitente,
            destinatario: datosDestinatarios,
            articulosFragil: articulosFragil,
            despacho: despacho,
            destino: destino
        },
        beforeSend: function () {
            if (modal != null) {
                modal.hide();
                $(btnEnviar).attr("disabled", true);
                setTimeout(() => {
                    $(btnEnviar).attr("disabled", false);
                }, 2000);

            }
        }
    })
        .done(function (response) {
            console.log("Respuesta del servidor:", response);

            mostrarAlerta(response.status, response.message);
        })
        .fail(function (xhr, status, error) {
            console.error("Error al cargar los datos:", error);
            console.log("Respuesta cruda del servidor:", xhr.responseText);
        })
        .always(function () {
            // Opcional: Código que se ejecuta siempre al finalizar (éxito o error)
            ajaxConsultar();

        });

}

function iconoCargar(selector) {
    const elementoHtml = $(`${selector}`);
    elementoHtml.html(`
    <tr>
      <td colspan="2" class="text-center text-muted py-3">
        <button class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Loading...
      </button>
      </td>
    </tr>
  `);
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
                text = "El Estado ha sido actualizado correctamente.";
                icon = "success";
                break;
            case 'deleted':
                title = "Eliminación exitosa!";
                text = mensaje;
                icon = "success";
                break;
            case 'exists':
                title = "Estado existente!";
                text = "El Estado ingresado ya existe en la base de datos.";
                icon = "warning";
                break;
            case 'empty':
                title = "Campos vacíos!";
                text = "Uno o más campos están vacíos.";
                icon = "warning";
                break;
            case 'error':
                title = "Error!";
                text = `Se produjo un error en el processo de ${mensaje}`;
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