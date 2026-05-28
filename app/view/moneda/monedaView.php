<div class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-xl-5 col-lg-6 mb-4">
            <h2 class="mb-4 text-primary"><i class="bi bi-coin"></i> Gestión de Monedas</h2>
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Registrar Nueva Moneda</h5></div>
                <div class="card-body">
                    <form action="?url=moneda" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre de la Moneda</label>
                            <input type="text" class="form-control" name="nombre_moneda" required placeholder="Ej: Dólar, Bolívar">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Siglas</label>
                            <input type="text" class="form-control" name="siglas" required placeholder="Ej: USD, VES">
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-plus-circle"></i> Registrar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Monedas Registradas</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr><th class="ps-4">Siglas</th><th>Nombre</th><th class="text-center pe-4">Acciones</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 fw-bold text-secondary">VES</td>
                                    <td>Bolívar Soberano</td>
                                    <td class="text-center pe-4">
                                        <a href="#" class="text-secondary me-3" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary me-3" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold text-secondary">USD</td>
                                    <td>Dólar Americano</td>
                                    <td class="text-center pe-4">
                                        <a href="#" class="text-secondary me-3" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary me-3" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold text-secondary">EUR</td>
                                    <td>Euro</td>
                                    <td class="text-center pe-4">
                                        <a href="#" class="text-secondary me-3" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary me-3" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold text-secondary">USDT</td>
                                    <td>Dólar Tether</td>
                                    <td class="text-center pe-4">
                                        <a href="#" class="text-secondary me-3" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary me-3" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>