<main class="container-fluid py-5 px-4">

    <div class="row">
        <div class="col-12 mb-4">
            <header class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 text-primary fw-bold"><i class="bi bi-box-seam"></i> Gestion de Envíos</h2>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" title="crear" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#carouselEnvio">
                        <i class="bi bi-dropbox"></i> Crear
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cotizarEnvio">
                        <i class="bi bi-currency-dollar"></i> Cotizar
                    </button>
                </div>
            </header>

            <!-- <?php //require 'componentes/modalCreate.php'; 
                    ?> -->
            <!-- <?php// require 'componentes/modalCotizar.php'; ?> -->
            <?php require 'componentes/modalCreateCarousel.php'; ?>
            <!-- <?php //require 'componentes/modalModificar.php'; ?> -->


            <section class="card shadow-sm border-0 pb-2">
                <div class="card-header bg-secondary text-white border-bottom-0 pt-2 pb-2 px-4 d-flex justify-content-center align-items-center">
                    <h4 class="mb-0 fw-bold">Listado</h4>
                    
                </div>

                <?php require 'componentes/tabla.php'; ?>

            </section>
        </div>
    </div>
</main>

