document.addEventListener("DOMContentLoaded", () => {
    // 1. Capturamos los elementos del DOM

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
});