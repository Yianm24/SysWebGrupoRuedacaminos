$(document).ready(function () {
    // Array de objetos con las reglas de validación completa Y de caracteres permitidos
    const reglasRegex = [
        {
            id: "solo-letras",
            expresion: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
            permitir: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/,
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
            permitir: /^\d$/,
            mensaje: "Solo ingresar números"
        },
        {
            id: "numeros-decimales",
            expresion: /^[0-9]+([.,][0-9]+)*$/,
            mensaje: "Solo ingresar números, puede incluir separadores de miles y decimales"
        },
        {
            id: "valores-monetarios",
            expresion: /^[0-9]{1,3}(\.[0-9]{3})*(,[0-9]{1,2})?$/,
            permitir: /^[0-9.,]$/,
            mensaje: "Ingrese un formato válido. Ej: 1.000,00"
        },
        {
            id: "correo-electronico",
            expresion: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            permitir: /^[^\s]$/,
            mensaje: "Ingresar Correo válido. Ej: juan123@gmail.com"
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
    const inputsBloquear = $('.input-evaluar, .solo-letras, .formato-placa, .solo-numeros, .numeros-decimales, .valores-monetarios, .correo-electronico, .letra-num-ceb');

    // Filtrado al escribir para el bloqueo de caracteres no deseados
    inputsBloquear.on('beforeinput', function (e) {
        const textoIngresado = e.originalEvent.data;
        if (!textoIngresado) return;

        const inputActual = $(this);
        const reglaCoincidente = reglasRegex.find(regla => inputActual.hasClass(regla.id));

        if (reglaCoincidente && reglaCoincidente.permitir) {
            for (let char of textoIngresado) {
                if (!reglaCoincidente.permitir.test(char)) {
                    e.preventDefault();
                    break;
                }
            }
        }
    });

    //Formatear valores a miles y decimales
    $('.valores-monetarios').on('input', function() {
        let input = $(this);
        let val = input.val();
        
        //validar ingreso de datos . y ,
        val = val.replace(/[^0-9,]/g, '');
        let partes = val.split(',');
        if (partes.length > 2) {
            val = partes[0] + ',' + partes.slice(1).join('');
            partes = val.split(',');
        }
        
        //decimales después de la coma permitidos
        if (partes[1] && partes[1].length > 2) {
            val = partes[0] + ',' + partes[1].substring(0, 2);
            partes = val.split(',');
        }
        
        //Agregar puntos de miles automáticamente
        if (partes[0].length > 0) {
            partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        input.val(partes.join(','));
    });

    
    //Validar el estado completo con bootstrap (is-valid / is-invalid)
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

    // Botón de cierre de modal y limpieza de validaciones
    $('.btn-close').on('click', function () {
        inputs.removeClass('is-valid is-invalid');
        inputs.siblings('.mensaje-error').hide().text('');
        btnEnviar.prop('disabled', true);
    });

    
    $('#btnCerrar').on('click',function(){
        $('.modal input').removeClass('is-valid');
        $('.modal input').removeClass('is-invalid');
        $('.modal input').val('');
        $('.modal .mensaje-error').hide().text('');
        btnEnviar.prop('disabled', true);
    })
    
});