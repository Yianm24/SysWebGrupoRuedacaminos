<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold text-primary">Dashboard Resumen</h2>
        <p class="text-muted">Bienvenido al sistema Grupo RuedaCaminos C.A. Aquí tienes un vistazo general de las operaciones.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold mb-2">Envíos Agendados</h6>
                        <h2 class="mb-0">24</h2>
                    </div>
                    <div>
                        <i class="bi bi-box-seam fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-white border-opacity-25 text-end">
                <a href="?url=seguimiento" class="text-white text-decoration-none small">Ver detalles <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold mb-2">Ingresos Mes</h6>
                        <h2 class="mb-0">$4,250</h2>
                    </div>
                    <div>
                        <i class="bi bi-wallet2 fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-white border-opacity-25 text-end">
                <a href="?url=pago" class="text-white text-decoration-none small">Ver detalles <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-dark h-100 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold mb-2">Vehículos en Ruta</h6>
                        <h2 class="mb-0">8</h2>
                    </div>
                    <div>
                        <i class="bi bi-truck fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-dark border-opacity-25 text-end">
                <a href="?url=flota" class="text-dark text-decoration-none small">Ver detalles <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white h-100 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold mb-2">Nuevos Clientes</h6>
                        <h2 class="mb-0">12</h2>
                    </div>
                    <div>
                        <i class="bi bi-people-fill fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-white border-opacity-25 text-end">
                <a href="?url=cliente" class="text-white text-decoration-none small">Ver detalles <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-activity text-primary me-2"></i>Últimos Envíos Registrados</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th># Tracking</th>
                                <th>Cliente</th>
                                <th>Destino</th>
                                <!-- <th>Estatus</th> -->
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="fw-bold text-primary">ENV-10042</span></td>
                                <td>Corporación XYZ, C.A.</td>
                                <td>Valencia</td>
                                <!-- <td><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">En Tránsito</span></td> -->
                                <td>$150.00</td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-primary">ENV-10041</span></td>
                                <td>Pedro Pérez</td>
                                <td>Maracaibo</td>
                                <!-- <td><span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Entregado</span></td> -->
                                <td>$45.00</td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-primary">ENV-10040</span></td>
                                <td>Inversiones ABC</td>
                                <td>Barquisimeto</td>
                                <!-- <td><span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Incidencia</span></td> -->
                                <td>$210.00</td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-primary">ENV-10039</span></td>
                                <td>Maria López</td>
                                <td>Caracas</td>
                                <!-- <td><span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Entregado</span></td> -->
                                <td>$12.50</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-wrench-adjustable text-warning me-2"></i>Alertas de Flota</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning border-start border-warning border-4 mb-3" role="alert">
                    <div class="d-flex">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div>
                            <h6 class="alert-heading fw-bold mb-1">Camión NPR - ABC12D</h6>
                            <p class="mb-0 small">Mantenimiento preventivo programado para mañana.</p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger border-start border-danger border-4 mb-0" role="alert">
                    <div class="d-flex">
                        <i class="bi bi-x-circle-fill fs-4 me-3"></i>
                        <div>
                            <h6 class="alert-heading fw-bold mb-1">Furgón - XYZ987</h6>
                            <p class="mb-0 small">En taller por reemplazo de cauchos y frenos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
