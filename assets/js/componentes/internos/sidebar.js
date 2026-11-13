document.addEventListener("DOMContentLoaded", function() {
        // Toggle Sidebar
        const sidebarToggle = document.getElementById("sidebarToggle");
        if (sidebarToggle) {
            sidebarToggle.addEventListener("click", event => {
                event.preventDefault();
                document.body.classList.toggle("sb-sidenav-toggled");
            });
        }
    });