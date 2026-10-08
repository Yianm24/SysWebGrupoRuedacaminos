document.addEventListener("DOMContentLoaded", () => {
    /* const textareaUbiDestino = document.getElementById('direccion_destino'),
        inputKilometro = document.getElementById('kilometraje'); */
    const coordenadasOrigen = {
        ccmetropoli: [10.062907758626542, -69.36506133308706],
        ccsambil: [10.07193188848613, -69.2929416674693],
        ccbabilon: [10.076775653967122, -69.34135927947186]
    }

    let mapaInstancia = null;

    function CrearElementoMapa(id) {
        const mapa = L.map(id, {
            // CORRECCIÓN: Faltaba el corchete "[" al inicio de las coordenadas
            center: [10.062907758626542, -69.36506133308706], // Coordenadas de la ubicación inicial
            zoom: 12
        });

        //Aca se hace el llamado a la plantilla del mapa, es decir su diseño
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            //Se trata del copiright de la "capa" osea del diseño del mapa
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(mapa);
        //L.marker(coordenadasOrigen.ccmetropoli).addTo(mapa);

        return mapa
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

    // 3. Asignamos el evento 'change' a ambos inputs radio
    radioNaturalRem.addEventListener("change", () => actualizarFormulario("remitente"));
    radioJuridicaRem.addEventListener("change", () => actualizarFormulario("remitente"));

    radioNaturalDest.addEventListener("change", () => actualizarFormulario("destinatario"));
    radioJuridicaDest.addEventListener("change", () => actualizarFormulario("destinatario"));
    // 4. Ejecutamos la función una vez al cargar la página para sincronizar la vista 
    // con el radio que venga 'checked' por defecto en el HTML
    actualizarFormulario();


    function CrearMapa(id) {  // Creamos el mapa solo si no existe
        console.log("Creando mapa en el contenedor con ID:", id);
        if (!mapaInstancia) {
            mapaInstancia = CrearElementoMapa(id);

        }

        // Forzamos a recalcular el tamaño una vez que el modal está abierto
        setTimeout(() => {
            mapaInstancia.invalidateSize();
        }, 500);
    }

    function DestruirMapa() {
        if (mapaInstancia) {
            mapaInstancia.remove(); // Destruye el mapa y limpia el contenedor HTML
            mapaInstancia = null;   // Reinicia tu variable
        }
    }

    // Modal de cotización
    const modalCotizar = document.getElementById('cotizarEnvio');

    if (modalCotizar) {
        modalCotizar.addEventListener('show.bs.modal', event => {
            CrearMapa('mapCotizar');
        }) }

    modalCotizar.addEventListener('hidden.bs.modal', event => {
        DestruirMapa();
    });


    const modalEnvio = document.getElementById('carouselEnvio');

    if (modalEnvio) {
        modalEnvio.addEventListener('show.bs.modal', event =>
            CrearMapa('mapCrear')
        );
    }

    modalEnvio.addEventListener('hidden.bs.modal', event => {
        DestruirMapa();
    });



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




    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status) {
        // Usamos un pequeño retraso para asegurar que la página esté completamente cargada
        setTimeout(() => {
            let title, text, icon;

            switch (status) {
                case 'success':
                    title = "Creación exitosa!";
                    text = "El envio ha sido creado correctamente.";
                    icon = "success";
                    break;
                case 'updated':
                    title = "Modificación exitosa!";
                    text = "El envio ha sido modificado correctamente.";
                    icon = "success";
                    break;
                case 'deleted':
                    title = "Eliminación exitosa!";
                    text = "El envio ha sido eliminado correctamente.";
                    icon = "success";
                    break;
                case 'exists':
                    title = "Envio existente!";
                    text = "El envio ingresado ya existe en la base de datos.";
                    icon = "warning";
                    break;
                case 'empty':
                    title = "Campos vacíos!";
                    text = "Uno o más campos están vacíos.";
                    icon = "warning";
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

});