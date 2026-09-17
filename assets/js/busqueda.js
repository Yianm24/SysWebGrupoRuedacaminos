const inputBusqueda = document.getElementById('inputBusqueda');
    if (inputBusqueda) {
        inputBusqueda.addEventListener('input', function() {
            const textoBuscado = this.value.toLowerCase();
            const filas = document.querySelectorAll("table tbody tr");
            filas.forEach(fila => {
                const contenidoFila = fila.textContent.toLowerCase();
                fila.style.display = contenidoFila.includes(textoBuscado) ? "" : "none";
            });
        });
    }
    