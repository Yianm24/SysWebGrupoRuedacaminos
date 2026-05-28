<div class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-xl-5 col-lg-6 mb-4">
            <h2 class="mb-4 text-primary"><i class="bi bi-rulers"></i> Unidad de Medida</h2>
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h5>Registrar Unidad</h5></div>
                <div class="card-body">
                    <form action="?url=unidadmedida" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre_unidad" placeholder="Ej: Kilogramos" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Abreviatura</label>
                            <input type="text" class="form-control" name="abreviatura" placeholder="Ej: KG" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h5>Listado de Unidades Registradas</h5></div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr><th class="ps-4">Abrev.</th><th>Nombre</th><th>Tipo</th><th class="text-center pe-4">Acciones</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">CM</td>
                                <td>Centímetros</td>
                                <td><span class="badge bg-light text-dark border">Distancia</span></td>
                                <td class="text-center pe-4">
                                    <a href="#" class="text-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="text-secondary"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">KG</td>
                                <td>Kilogramos</td>
                                <td><span class="badge bg-light text-dark border">Peso</span></td>
                                <td class="text-center pe-4">
                                    <a href="#" class="text-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="text-secondary"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">LT</td>
                                <td>Litros</td>
                                <td><span class="badge bg-light text-dark border">Volumen</span></td>
                                <td class="text-center pe-4">
                                    <a href="#" class="text-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="text-secondary"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">KM</td>
                                <td>Kilómetros</td>
                                <td><span class="badge bg-light text-dark border">Distancia</span></td>
                                <td class="text-center pe-4">
                                    <a href="#" class="text-secondary me-2"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="text-secondary"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>