        </main>

        <footer class="bg-white text-center py-3 mt-auto border-top w-100 shadow-sm">
            <div class="container-fluid">
                <p class="mb-0 text-muted fw-semibold">&copy; <?= date('Y') ?> Grupo RuedaCaminos C.A.</p>
                <small class="text-muted">Sistema para Empresa de Envíos - Creado por Seccion 2103, Grupo 2</small>
            </div>
        </footer>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Toggle Sidebar
        const sidebarToggle = document.getElementById("sidebarToggle");
        if (sidebarToggle) {
            sidebarToggle.addEventListener("click", event => {
                event.preventDefault();
                document.body.classList.toggle("sb-sidenav-toggled");
            });
        }

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
</script>
</body>
</html>
