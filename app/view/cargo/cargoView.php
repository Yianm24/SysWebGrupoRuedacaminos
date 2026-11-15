<main class="container-fluid py-5 px-4 flex-grow-1">
    <div class="row">
        <div class="col-12 mb-4">
            
            <header class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 text-primary fw-bold"><i class="bi bi-person-vcard me-2"></i> Gestión de Cargos</h2>
                <button type="button" class="btn btn-primary" title="Registrar" data-bs-toggle="modal" data-bs-target="#modalCargo">
                    <i class="bi bi-plus-circle"></i> Registrar
                </button> 
            </header>
            
            <?php require 'componentes/modalCargo.php'; ?>

            <section class="card shadow-sm border-0 h-100">
                <!-- DataTables generará los controles automáticamente dentro de este card-body -->
                <div class="card-body p-4"> 
                    <?php require 'componentes/tabla.php' ?>
                </div>
            </section>
            
        </div>
    </div>
</main>