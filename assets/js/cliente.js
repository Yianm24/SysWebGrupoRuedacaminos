document.addEventListener("DOMContentLoaded", function() {
       
        // Lógica para alternar campos de Persona Natural o Jurídica en el Módulo de Clientes
        const tipoPersona_remitente = document.querySelectorAll('input[name="tipo_persona_remitente"]');
        const remitente_natural = document.getElementById('remitente_natural-fields');
        const remitente_juridico = document.getElementById('remitente_juridico-fields');

        if(tipoPersona_remitente.length > 0 && remitente_natural && remitente_juridico) {
            tipoPersona_remitente.forEach(input => {
                input.addEventListener('change', function() {
                    if(this.value === 'remitente_natural') {
                        console.log('Remitente Natural seleccionado');
                        remitente_natural.style.display = 'block';
                        remitente_juridico.style.display = 'none';
                    } else if(this.value === 'remitente_juridico') {
                        remitente_natural.style.display = 'none';
                        remitente_juridico.style.display = 'block';
                    }
                });
            });
        }

        const tipoPersona_destinatario = document.querySelectorAll('input[name="tipo_persona_destinatario"]');
        const destinatario_natural = document.getElementById('destinatario_natural-fields');
        const destinatario_juridico = document.getElementById('destinatario_juridico-fields');

        if(tipoPersona_destinatario.length > 0 && destinatario_natural && destinatario_juridico ) {
            tipoPersona_destinatario.forEach(input => {
                input.addEventListener('change', function() {
                    if(this.value === 'destinatario_natural') {
                        console.log('Destinatario Natural seleccionado');
                        destinatario_natural.style.display = 'block';
                        destinatario_juridico .style.display = 'none';
                    } else if(this.value === 'destinatario_juridico') {
                        destinatario_natural.style.display = 'none';
                        destinatario_juridico .style.display = 'block';
                    }
                });
            });
        }
    });