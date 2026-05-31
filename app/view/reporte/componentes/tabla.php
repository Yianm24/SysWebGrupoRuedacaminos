<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">CODIGO ENVIO</th>
                    <th class="text-center">FECHA</th>
                    <th class="text-center">REMITENTE</th>
                    <th class="text-center">MONTO</th>
                    <th class="text-center">GENERAR REPORTE</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <!-- <?php //foreach ($result as $value): ?> -->
                    <tr>
                        <td class="ps-4 fw-medium"></td>
                        <td>
                            <span class="fw-medium"></span>
                        </td>
                        <td class="text-secondary"></td>

                        <td class="text-center">
                            <span class="fw-medium"></span>
                        </td>
                         <td class="text-center">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#registerPago">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </button>
                        </td>
                        <td class="pe-4 text-center">
                            
                            <a href="#" class="text-secondary me-2 text-decoration-none" title="Ver Detalles"
                                data-bs-toggle="modal" data-bs-target="#modalDetalles">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php //endforeach; ?>
            </tbody>
        </table>
    </div>
</div>