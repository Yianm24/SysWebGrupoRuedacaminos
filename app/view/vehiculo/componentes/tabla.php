<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">PLACA</th>
                    <th>COLOR</th>
                    <th>MARCA</th>
                    <th>MODELO</th>
                    <th class="text-center">AÑO</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $value): ?> 
                    <tr>
                        <td class="ps-4 fw-medium"><?= $value['placa'] ?></td>
                        <td>
                            <span class="fw-medium"><?= $value['color'] ?></span>
                        </td>
                        <td class="text-secondary"></td>
                        <td class="text-secondary"></td>
                        <td class="text-center">
                            <span class="fw-medium"><?= $value['ano'] ?></span>
                        </td>
                        <td class="pe-4 text-center">
                            <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"
                                data-bs-toggle="modal" data-bs-target="#registerModal">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="?url=cliente&type=delete&id=<?//= $value['id'] ?>" class="text-secondary text-decoration-none" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este cliente?');"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>