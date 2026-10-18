$(document).ready(function () {
    // Array de objetos con las reglas de validación
    const reglasRegex = [
        {
            id: "solo-letras",
            expresion: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
            mensaje: "Solo ingresar letras y espacios"

        },
        {
            id: "formato-placa",
            expresion: /^[a-zA-Z\d]+$/,
            mensaje: "Solo ingresar letras mayus y numeros"
        },
        {
            id: "solo-numeros",
            expresion: /^\d+$/,
            mensaje: "Solo ingresar numeros"
        },
        {
            id: "correo-electronico",
            expresion: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            mensaje: "Ingresar Correo valido ej:juan123@gmail.com"
        },
        {

            id: "letra-num-ceb",
            expresion: /^[a-zA-Z0-9\s!-\/:-?\[-`{-~]+$/,
            mensaje:"Solo ingrese letras, numeros o caracteres especiales"
        }
    ];

    const btnEnviar = $('button[name="tipoSolicitud"]');
    const inputs = $('.input-evaluar');

    // Función que evalúa dynamicamente un input según la clase que posee
    function evaluarInput(input) {
        const valor = input.val().trim();
        const mensajeError = input.siblings('.mensaje-error');

        // Si está vacío, se resetea el estado del campo
        if (valor === '') {
            input.removeClass('is-valid is-invalid');
            mensajeError.hide().text('');
            return false;
        }

        // 1. Identificar cuál objeto del array coincide con alguna clase del input
        const reglaCoincidente = reglasRegex.find(regla => input.hasClass(regla.id));

        // 2. Condicional: Si existe una regla cuya ID sea igual a una clase del input
        if (reglaCoincidente) {

            // Ejecución del .test() con la expresión regular encontrada
            const esValido = reglaCoincidente.expresion.test(valor);

            if (esValido) {
                input.addClass('is-valid').removeClass('is-invalid');
                mensajeError.hide().text('');
                return true;
            } else {
                input.addClass('is-invalid').removeClass('is-valid');
                mensajeError.text(reglaCoincidente.mensaje).show();
                return false;
            }

        }

        return false;
    }

    // Verificar el estado de todos los inputs para controlar el botón
    function verificarFormulario() {
        let formularioValido = true;

        inputs.each(function () {
            if (!evaluarInput($(this))) {
                formularioValido = false;
            }
        });

        // Habilitar o deshabilitar botón dependiendo de los tests
        btnEnviar.prop('disabled', !formularioValido);
    }

    // Evento input para evaluar dinámicamente al escribir
    inputs.on('input', function () {
        evaluarInput($(this));
        verificarFormulario();
    });

    // $('.btn-close').click(() => {

    //     // 
    //     // removeClass('is-invalid');

    //     inputs.each(() => {
    //         $(this).removeClass('is-valid');
    //         $(this).removeClass('is-invalid');
    //     });
    //     // btnEnviar.attr('disabled' = true);


    // })

});