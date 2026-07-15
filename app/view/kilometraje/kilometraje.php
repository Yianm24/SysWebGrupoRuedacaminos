<main class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-12 mb-4">
            <header class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 text-primary fw-bold"><i class="bi bi-currency-dollar"></i> Precio de Kilometraje</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerPrecio">
                    <i class="bi bi-plus-circle"></i> Registrar
                </button> 
            </header>
            
            <?php 
                require 'componentes/modalRegistrar.php'; 
                require 'componentes/modalEditar.php'; 
            ?>

            <!--Mensajes y alertas-->
            <script src="assets/js/sweetalert2.all.min.js"></script>
            <?php if (isset($_GET['status'])): ?>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    setTimeout(function() {
                        <?php if ($_GET['status'] == 'success'): ?>
                            Swal.fire({ title: "Registro exitoso!", text: "Registro de precio de kilometraje realizado exitosamente", icon: "success" });
                        <?php elseif ($_GET['status'] == 'exists'): ?>
                            Swal.fire({ title: "¡Tarifa existente!", text: "Ya existe una tarifa registrada para el Kilometraje ingresado", icon: "warning" });
                        <?php elseif ($_GET['status'] == 'updated'): ?>
                            Swal.fire({ title: "Actualización exitosa!", text: "Actualización del Precio de kilometraje realizado exitosamente", icon: "success" });
                        <?php elseif ($_GET['status'] == 'deleted'): ?>
                            Swal.fire({ title: "¡Eliminado!", text: "Eliminación del Precio de Kilometraje realizado exitosamente", icon: "success" });
                        <?php endif; ?>
                    }, 100);
                });
            </script>
            <?php endif; ?>

            <section class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">Directorio de Precios</h4>
                    <div class="input-group" style="max-width: 250px;">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 text-muted" id="inputBusqueda" placeholder="Buscar tarifa...">
                    </div>
                </div>

                <?php require 'componentes/tabla.php'; ?>

                <footer class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center px-4 py-3">
                    <span class="text-muted small">Mostrando resultados</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm px-3 text-muted" disabled>Anterior</button>
                        <button class="btn btn-outline-secondary btn-sm px-3 text-muted">Siguiente</button>
                    </div>
                </footer>
            </section>
        </div>
    </div>
</main>
<script src="assets/js/kilometraje.js"></script>