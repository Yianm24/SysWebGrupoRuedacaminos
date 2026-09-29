document.addEventListener("DOMContentLoaded", () => {
    // 1. Capturamos los elementos del DOM
    const radioNatural = document.getElementById("persona_natural");
    const radioJuridica = document.getElementById("persona_juridica");
    const camposNatural = document.getElementById("rem_campos_natural");
    const camposJuridico = document.getElementById("rem_campos_juridico");

    // 2. Función que evalúa cuál radio está seleccionado y cambia las clases
    function actualizarFormulario() {
        if (radioJuridica.checked) {
            // Si Jurídica está seleccionada, mostramos jurídico y ocultamos natural
            camposJuridico.classList.remove("d-none");
            camposNatural.classList.add("d-none");
        } else {
            // Si Natural está seleccionada, mostramos natural y ocultamos jurídico
            camposNatural.classList.remove("d-none");
            camposJuridico.classList.add("d-none");
        }
    }

    // 3. Asignamos el evento 'change' a ambos inputs radio
    radioNatural.addEventListener("change", actualizarFormulario);
    radioJuridica.addEventListener("change", actualizarFormulario);

    // 4. Ejecutamos la función una vez al cargar la página para sincronizar la vista 
    // con el radio que venga 'checked' por defecto en el HTML
    actualizarFormulario();
});