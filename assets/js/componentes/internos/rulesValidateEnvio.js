// jQuery.validator.addMethod("solo_letras", function (value, element) {

//     return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/i.test(value);
// }, "Formato inválido. Ingrese únicamente letras.")

// jQuery.validator.addMethod("solo_numeros", function (value, element) {

//     return this.optional(element) || /^\d{11}$/.test(value);
// }, "Ingrese únicamente dígitos numéricos.")


// jQuery.validator.addMethod("solo_correo", function (value, element) {

//     return this.optional(element) || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
// }, "Por favor, introduzca una correo válido.")

const condValidate = {
    solo_letras: {
        expre: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/i,
        mssj: "Formato inválido. Ingrese únicamente letras."
    },
    solo_numeros: {
        expre: /^\d{11}$/,
        mssj: "Ingrese únicamente dígitos numéricos."
    },
    solo_correo: {
        expre: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        mssj: "Por favor, introduzca un correo válido."
    }
};

Object.entries(condValidate).forEach(([nombre, condicion]) => {
    jQuery.validator.addMethod(nombre, function (value, element) {
        return this.optional(element) || condicion.expre.test(value);
    }, condicion.mssj);
});

jQuery.validator.addMethod("solo_numeros", function (value, element) {

    return this.optional(element) || /^\d{11}$/.test(value);
}, "Ingrese únicamente dígitos numéricos.")



$('#formEnvio').validate({
    rules: {
        rem_telefono: {
            required: true,
            solo_numeros: true
        },
        rem_correo: {
            email: false,
            solo_correo: true
        },
        dest_telefono: {
            required: true,
            solo_numeros: true
        }, 
    },
messages: {
    rem_telefono: {
        required: "El teléfono es requerido"
    },
    dest_telefono: {
        required: "El teléfono es requerido"
    }
},

highlight: function (element) {
    $(element).addClass('is-invalid');
},

unhighlight: function (element) {
    $(element).removeClass('is-invalid');
}
});

function validarCliente(){}


