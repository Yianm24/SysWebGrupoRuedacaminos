<main class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-12 mb-4">
            <header class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 text-primary fw-bold"><i class="bi bi-people-fill me-2"></i> Gestión de Clientes</h2>
                <button type="button" class="btn btn-primary" title="Registrar" data-bs-toggle="modal" data-bs-target="#modalCliente">
                    <i class="bi bi-person-plus"></i> Registrar
                </button>
            </header>

            <?php
            require 'componentes/modalRegistrar.php';
            require 'componentes/modalEditarNatural.php';
            require 'componentes/modalEditarJuridico.php';
            ?>

            <section class="card shadow-sm border-0 pb-2">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">Listado</h4>
                    <div class="input-group" style="max-width: 250px;">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 text-muted" id="inputBusqueda" placeholder="Buscar Cliente...">
                    </div>
                </div>

                <?php require 'componentes/tabla.php'; ?>

            </section>
        </div>
    </div>
</main>