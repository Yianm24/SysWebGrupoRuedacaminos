<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">CÓDIGO ENVIO</th>
                    <th class="text-center">ESTADO</th>
                    <th>MONTO TOTAL</th>
                    <th>ULTIMO ABONO</th>
                    <th>MONTO RESTANTE</th>
                    <th class="text-center">AÑADIR PAGO</th>
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
                        <td class="text-secondary"></td>
                        <td class="text-center">
                            <span class="badge">
                            </span>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerPago">
                                <i class="bi bi-person-plus"></i> Registrar Pago
                            </button>
                        </td>
                        <td class="pe-4 text-center">
                            
                            <a href="#" class="text-secondary me-2 text-decoration-none" title="Ver Detalles"
                                data-bs-toggle="modal" data-bs-target="#modalDetalles">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"
                                data-bs-toggle="modal" data-bs-target="#modalRegistrar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="?url=cliente&type=delete&id=<?//= $value['id'] ?>" class="text-secondary text-decoration-none" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este cliente?');"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php //endforeach; ?>
            </tbody>
        </table>
    </div>
</div>