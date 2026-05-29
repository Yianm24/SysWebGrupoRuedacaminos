<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">FECHA ENVIO</th>
                    <th class="text-center">VEHICULO</th>
                    <th class="text-center">NUMERO DE ENVIOS</th>
                    <th class="text-center">ASIGNAR CHOFER</th>
                    <th class="text-center">GENERAR HOJA DESPACHO</th>
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
                            <select class="form-select" id="metodos" name="metodos" required>
                                <option value="" selected disabled>Choferes...</option>
                                <option value="1">Ruben Perez</option>
                                <option value="2">Carlos Rodriguez</option>
                                <option value="3">Luis Martinez</option>
                            </select>
                        </td>
                         <td class="text-center">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#registerPago">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </button>
                        </td>
                        <td class="pe-4 text-center">
                            
                            <a href="#" class="text-secondary me-2 text-decoration-none" title="Ver Envios"
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