$(document).ready(function () {
    // Array de objetos con las reglas de validación completa Y de caracteres permitidos
    const reglasRegex = [
        {
            id: "solo-letras",
            expresion: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
            permitir: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/, // Bloquea números y símbolos
            mensaje: "Solo ingresar letras y espacios"
        },
        {
            id: "formato-placa",
            expresion: /^[a-zA-Z\d]+$/,
            permitir: /^[a-zA-Z\d]$/,
            mensaje: "Solo ingresar letras y números"
        },
        {
            id: "solo-numeros",
            expresion: /^\d+$/,
            permitir: /^\d$/, // Solo deja teclear números
            mensaje: "Solo ingresar números"
        },
        {
            id: "numeros-decimales",
            expresion: /^[0-9]+([.,][0-9]+)*$/,
            mensaje: "Solo ingresar números, puede incluir separadores de miles y decimales"
        },
        {
            id: "correo-electronico",
            expresion: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            // No permite espacios
            permitir: /^[^\s]$/,
            mensaje: "Ingresar Correo válido ej: juan123@gmail.com"
        },
        {
            id: "letra-num-ceb",
            expresion: /^[a-zA-Z0-9\s!-\/:-?\[-`{-~]+$/,
            permitir: /^[a-zA-Z0-9\s!-\/:-?\[-`{-~]$/,
            mensaje: "Solo ingrese letras, números o caracteres especiales"
        }
    ];

    const btnEnviar = $('button[name="tipoSolicitud"]');
    const inputs = $('.input-evaluar');

    // =========================================================================
    // 1. FILTRADO PREVIO AL ESCRIBIR (Bloqueo de caracteres no deseados)
    // =========================================================================
    inputs.on('beforeinput', function (e) {
        // e.originalEvent da acceso al evento nativo del navegador en jQuery
        const textoIngresado = e.originalEvent.data;

        // Si la acción no inserta texto (por ejemplo, borrar con Backspace/Delete), lo dejamos pasar
        if (!textoIngresado) return;

        const inputActual = $(this);
        const reglaCoincidente = reglasRegex.find(regla => inputActual.hasClass(regla.id));

        // Si el input tiene asignada una regla de caracteres permitidos
        if (reglaCoincidente && reglaCoincidente.permitir) {
            // Evaluamos cada carácter que intenta entrar (sirve para una tecla o si pegan texto)
            for (let char of textoIngresado) {
                if (!reglaCoincidente.permitir.test(char)) {
                    e.preventDefault(); // Cancela la impresión en pantalla al instante
                    break;
                }
            }
        }
    });

    // =========================================================================
    // 2. VALIDACIÓN DEL VALOR COMPLETO Y ESTADOS (Bootstrap is-valid / is-invalid)
    // =========================================================================
    function evaluarInput(input) {
        const valor = input.val().trim();
        const mensajeError = input.siblings('.mensaje-error');

        // Si está vacío, se resetea el estado del campo
        if (valor === '') {
            input.removeClass('is-valid is-invalid');
            mensajeError.hide().text('');

            return input.hasClass('opcional');
        }

        const reglaCoincidente = reglasRegex.find(regla => input.hasClass(regla.id));

        if (reglaCoincidente) {
            
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

    function verificarFormulario() {
        let formularioValido = true;

        inputs.each(function () {
            if (!evaluarInput($(this))) {
                formularioValido = false;
            }
        });

        btnEnviar.prop('disabled', !formularioValido);
    }

    // Evento input para evaluar semánticamente cuando ya cambió el valor
    inputs.on('input', function () {
        evaluarInput($(this));
        verificarFormulario();
    });

    // Botón de reset/cierre de modal (limpiar validaciones)
    $('.btn-close').on('click', function () {
        inputs.removeClass('is-valid is-invalid');
        inputs.siblings('.mensaje-error').hide().text('');
        btnEnviar.prop('disabled', true);
    });
});