
document.addEventListener("DOMContentLoaded", function () {

const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const mensaje = urlParams.get('msg');

    if (status) {
        // Usamos un pequeño retraso para asegurar que la página esté completamente cargada
        setTimeout(() => {
            let title, text, icon;

            switch (status) {
            
                case 'incorrect':
                    title = "Credenciales incorrectas!";
                    text = mensaje || "Por favor, verifique su cédula y contraseña.";
                    icon = "error";
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