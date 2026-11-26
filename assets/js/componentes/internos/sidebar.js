document.addEventListener("DOMContentLoaded", function () {
    // Toggle Sidebar
    const sidebarToggle = document.getElementById("sidebarToggle");
    if (sidebarToggle) {
        sidebarToggle.addEventListener("click", event => {
            event.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
        });
    }

    // Cerrar sesión
    const btnCerrarSesion = document.getElementById("btnCerrarSesion");
    const formCerrarSesion = document.getElementById("formCerrarSesion");
    if (btnCerrarSesion && formCerrarSesion) {
        btnCerrarSesion.addEventListener("click", function (event) {
            event.preventDefault();
            let inputSolicitud = formCerrarSesion.querySelector('input[type="hidden"][name="Solicitud"]');
            if (!inputSolicitud) {
                inputSolicitud = document.createElement("input");
                inputSolicitud.type = "hidden";
                inputSolicitud.name = "Solicitud";
                formCerrarSesion.appendChild(inputSolicitud);
            }
            inputSolicitud.value = btnCerrarSesion.value || "cerrar";
            formCerrarSesion.submit();
        });
    }
});
