<div class="container-fluid py-5 px-4">
    <div class="row">

        <div class="col-xl-5 col-lg-6 mb-4">

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2 class="mb-4 text-primary"><i class="bi bi-person-plus"></i> Registro de Vehiculo</h2>

                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Información del Vehiculo</h5>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="placa" class="form-label">Placa</label>
                                        <input type="text" class="form-control" id="placa" name="placa" placeholder="Ej: ABC12D" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="color" class="form-label">Color:</label>
                                        <input type="text" class="form-control" id="color" name="color" required>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="col-md-6">

                                            <label for="tipo_punto" class="form-label">Ubicación destino</label>
                                            <select class="form-select" id="ubicacion" name="ubicacion_select" required>
                                                <option value="" selected disabled>Seleccionar Ubicación...</option>
                                                <option value="1">Caracas</option>
                                                <option value="2">Valencia</option>
                                                <option value="3">Maracaibo</option>
                                                <option value="4">Barquisimeto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="estado_operativo" class="form-label">Estado Operativo</label>
                                        <select class="form-select" id="estado_operativo" name="estado_operativo" required>
                                            <option value="disponible">Disponible</option>
                                            <option value="en_ruta">En Ruta</option>
                                            <option value="en_taller">En Taller</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="input-group ">
                                            <select class="form-select" id="marca">
                                                <option selected>Marca</option>
                                                <option value="1">Fiat</option>
                                                <option value="2">Mitsubishi</option>
                                                <option value="3">Renoult</option>
                                            </select>
                                            <select class="form-select" id="modelo">
                                                <option selected>Modelo</option>
                                                <option value="1">Fiesta</option>
                                                <option value="2">Canguro</option>
                                                <option value="3">Fiorino</option>
                                            </select>
                                            <input type="text" class="form-control" id="year" name="year" placeholder="Año:" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-wrench-adjustable"></i> Guardar Registro</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6 mb-4">

            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">Directorio</h4>
                    <div class="input-group" style="max-width: 250px;">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 text-muted" placeholder="Buscar Vehiculo...">
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light table-header-custom">
                                <tr>
                                    <th class="ps-4">PLACA</th>
                                    <th>ESTADO</th>
                                    <th>MARCA</th>
                                    <th>MODELO</th>
                                    <th>AÑO</th>
                                    <th>COLOR</th>
                                    <th>TIPO</th>
                                    <th class="pe-4 text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 fw-medium">ABC12D</td>
                                    <td>
                                        <span class="fw-medium">Disponible</span>
                                    </td>
                                    <td class="text-secondary">Fiat</td>
                                    <td class="text-secondary">Fiorino</td>
                                    <td class="text-secondary">2023</td>
                                    <td class="text-secondary">Blanco</td>
                                    <td class="text-secondary">Camioneta pequeña</td>
                                    <td class="pe-4 text-center">
                                        <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary text-decoration-none" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-medium">AFE16P</td>
                                    <td>
                                        <span class="fw-medium">En Taller</span>
                                    </td>
                                    <td class="text-secondary">Renault</td>
                                    <td class="text-secondary">Canguro</td>
                                    <td class="text-secondary">2020</td>
                                    <td class="text-secondary">Blanco</td>
                                    <td class="text-secondary">Camion</td>
                                    <td class="pe-4 text-center">
                                        <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary text-decoration-none" title="Eliminar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center px-4 py-3">
                    <span class="text-muted small">Mostrando 4 de 4 clientes</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm px-3 text-muted" disabled>Anterior</button>
                        <button class="btn btn-outline-secondary btn-sm px-3 text-muted">Siguiente</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="assets/js/cliente.js"></script>