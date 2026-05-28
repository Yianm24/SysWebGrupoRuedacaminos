<div class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-xl-5 col-lg-6 mb-4">
            <h2 class="mb-4 text-primary"><i class="bi bi-credit-card"></i> Métodos de Pago</h2>
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h5 class="mb-0">Registrar Nuevo Método</h5></div>
                <div class="card-body">
                    <form action="?url=metodopago" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Método</label>
                            <input type="text" class="form-control" name="nombre_metodo" placeholder="Ej: Pago Móvil, Zelle, Transferencia" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Registrar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white"><h4 class="mb-0 fw-bold">Métodos Disponibles</h4></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nombre del Método</th>
                                    <th class="text-center pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">Pago Móvil</td>
                                    <td class="text-center pe-4">
                                        <a href="#" class="text-secondary me-2" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">Zelle</td>
                                    <td class="text-center pe-4">
                                        <a href="#" class="text-secondary me-2" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">Transferencia Bancaria</td>
                                    <td class="text-center pe-4">
                                        <a href="#" class="text-secondary me-2" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-medium text-secondary">Efectivo</td>
                                    <td class="text-center pe-4">
                                        <a href="#" class="text-secondary me-2" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary" title="Eliminar"><i class="bi bi-trash"></i></a>
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