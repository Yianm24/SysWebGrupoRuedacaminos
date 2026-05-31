<main class="container-fluid py-5 px-4">

    

    <div class="row">
        <div class="col-12 mb-4">
            <header class="d-flex justify-content-end mb-3">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#carouselEnvio">
                        <i class="bi bi-person-plus"></i> Crear Envío
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cotizarEnvio">
                        <i class="bi bi-currency-dollar"></i> Cotizar Envío
                    </button>
                </div>
            </header>

            <?php require 'componentes/modalCreate.php'; ?>
            <?php require 'componentes/modalCotizar.php'; ?>
            <?php require 'componentes/modalCreateCarousel.php'; ?>

            <section class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">Directorio</h4>
                    <div class="input-group" style="max-width: 250px;">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 text-muted" placeholder="Buscar Envio...">
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

<script src="assets/js/cliente.js"></script>