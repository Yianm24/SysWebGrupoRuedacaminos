<div class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-xl-5 col-lg-6 mb-4">
            <h2 class="mb-4 text-primary"><i class="bi bi-currency-exchange"></i> Tasa de Cambio</h2>
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Establecer Tasa</h5>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        <div class="mb-3">
                            <label for="moneda" class="form-label">Moneda</label>
                            <select class="form-select" id="moneda" name="moneda" required>
                                <option value="" selected disabled>Seleccionar...</option>
                                <option value="1">USD (Dólar)</option>
                                <option value="2">EUR (Euro)</option>
                                <option value="3">USDT (Dólar Tether)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tasa" class="form-label">Valor Tasa (VES)</label>
                            <input type="number" step="0.01" class="form-control" id="tasa" name="tasa" placeholder="0.00" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-arrow-repeat"></i> Actualizar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                    <h4 class="mb-0 fw-bold">Historial de Tasas</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Fecha</th>
                                    <th>Hora</th>
                                    <th>Moneda</th>
                                    <th>Tasa</th>
                                    <th class="pe-4 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 text-secondary">27/05/2026</td>
                                    <td class="fw-medium">01:10 PM</td>
                                    <td class="fw-medium">USD</td>
                                    <td class="fw-bold">
                                        549.04 VES 
                                        <small class="text-success ms-1">
                                            <i class="bi bi-arrow-up"></i> 0.87%
                                        </small>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <a href="#" class="text-secondary me-2" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 text-secondary">27/05/2026</td>
                                    <td class="fw-medium">01:10 PM</td>
                                    <td class="fw-medium">EUR</td>
                                    <td class="fw-bold">
                                        627.70 VES 
                                        <small class="text-success ms-1">
                                            <i class="bi bi-arrow-up"></i> 1.25%
                                        </small>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <a href="#" class="text-secondary me-2" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 text-secondary">27/05/2026</td>
                                    <td class="fw-medium">01:10 PM</td>
                                    <td class="fw-medium">USDT</td>
                                    <td class="fw-bold">
                                        737.75 VES 
                                        <small class="text-danger ms-1">
                                            <i class="bi bi-arrow-down"></i> 0.07%
                                        </small>
                                    </td>
                                    <td class="pe-4 text-center">
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