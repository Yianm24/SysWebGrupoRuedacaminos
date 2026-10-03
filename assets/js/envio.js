document.addEventListener("DOMContentLoaded", () => {
    // 1. Capturamos los elementos del DOM
    const coordenadasOrigen = {
        ccmetropoli: [10.062907758626542, -69.36506133308706],
        ccsambil: [10.07193188848613, -69.2929416674693],
        ccbabilon: [10.076775653967122, -69.34135927947186]
    }

    let mapaInstancia = null;
    function CrearMapa() {
        const mapa = L.map('map', {
            // CORRECCIÓN: Faltaba el corchete "[" al inicio de las coordenadas
            center: [10.062907758626542, -69.36506133308706],
            zoom: 12
        });

        //Aca se hace el llamado a la plantilla del mapa, es decir su diseño
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            //Se trata del copiright de la "capa" osea del diseño del mapa
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(mapa);
        L.marker(coordenadasOrigen.ccmetropoli).addTo(mapa);

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


    const modal = document.getElementById('cotizarEnvio');


    if (modal) {
        modal.addEventListener('show.bs.modal', event => {

            // Creamos el mapa solo si no existe
            if (!mapaInstancia) {
                mapaInstancia = CrearMapa();
            }

            // Forzamos a recalcular el tamaño una vez que el modal está abierto
            setTimeout(() => {
                mapaInstancia.invalidateSize();
            }, 500);

        });
    };


});