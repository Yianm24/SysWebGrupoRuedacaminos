<main class="container-fluid py-5 px-4 flex-grow-1">
    <div class="row">
        <div class="col-12 mb-4">
            <header class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 text-primary fw-bold"><i class="bi bi-person-fill me-2"></i> Gestión de Empleados</h2>
                <button type="button" class="btn btn-primary" title="Registrar" data-bs-toggle="modal" data-bs-target="#modalEmpleado">
                    <i class="bi bi-person-plus"></i> Registrar
                </button>
            </header>

            <?php require 'componentes/modalEmpleado.php'; ?>

            <section class="card shadow-sm border-0 pb-2">
                <div class="card-header bg-secondary text-white border-bottom-0 pt-2 pb-2 px-4 d-flex justify-content-center align-items-center">
                    <h4 class="mb-0 fw-bold">Listado</h4>
                </div>

                <?php require 'componentes/tabla.php'; ?>
            </section>
        </div>
    </div>
</main>