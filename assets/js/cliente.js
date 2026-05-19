document.addEventListener("DOMContentLoaded", function() {
       
        // Lógica para alternar campos de Persona Natural o Jurídica en el Módulo de Clientes
        const tipoPersonaInputs = document.querySelectorAll('input[name="tipo_persona"]');
        const naturalFields = document.getElementById('natural-fields');
        const juridicaFields = document.getElementById('juridica-fields');

        if(tipoPersonaInputs.length > 0 && naturalFields && juridicaFields) {
            tipoPersonaInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if(this.value === 'natural') {
                        naturalFields.style.display = 'block';
                        juridicaFields.style.display = 'none';
                    } else if(this.value === 'juridica') {
                        naturalFields.style.display = 'none';
                        juridicaFields.style.display = 'block';
                    }
                });
            });
        }
    });