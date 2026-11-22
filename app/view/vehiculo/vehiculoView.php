<main class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-12 mb-4">
            <header class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 text-primary fw-bold"><i class="bi bi-truck me-2"></i> Gestión de Vehiculos</h2>
                <button type="button" class="btn btn-primary" title="Registrar" data-bs-toggle="modal" data-bs-target="#modalVehiculo">
                    <i class="bi bi-plus-circle"></i> Registrar
                </button> 
            </header>
            
            <?php require 'componentes/modal.php'; ?>

            <section class="card shadow-sm border-0 pb-2">
                <div class="card-header bg-secondary text-white border-bottom-0 pt-2 pb-2 px-4 d-flex justify-content-center align-items-center">
                    <h4 class="mb-0 fw-bold">Vehiculos Registrados</h4>
                </div>

                <?php require 'componentes/tabla.php'; ?>
            </section>
        </div>
    </div>
</main>