<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">CÉDULA</th>
                    <th>NOMBRE COMPLETO</th>
                    <th>TELÉFONO</th>
                    <th>EMERGENCIA</th>
                    <th>CARGO</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($registros)): ?>
                    <?php foreach ($registros as $fila): ?>
                        <tr>
                            <td class="ps-4 fw-medium"><?= $fila['cedula'] ?></td>
                            <td><span class="fw-medium"><?= $fila['nombre'] . ' ' . $fila['apellido'] ?></span></td>
                            <td class="text-secondary"><?= $fila['telefono'] ?></td>
                            <td class="text-secondary"><?= $fila['telefono_emergencia'] ?></td>
                            <td class="text-secondary"><?= ucfirst($fila['nombre_cargo']) ?></td>
                            <td class="pe-4 text-center">
                                <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline me-3 btn-editar" title="Editar"
                                    data-bs-toggle="modal" data-bs-target="#modalEditar" 
                                    data-id="<?= $fila['cod_empleado'] ?>" 
                                    data-cedula="<?= $fila['cedula'] ?>"
                                    data-nombre="<?= $fila['nombre'] ?>"
                                    data-apellido="<?= $fila['apellido'] ?>"
                                    data-telefono="<?= $fila['telefono'] ?>"
                                    data-emergencia="<?= $fila['telefono_emergencia'] ?>"
                                    data-cargo="<?= $fila['cod_cargo'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar" title="Eliminar"
                                    data-id="<?= $fila['cod_empleado'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No hay registros disponibles.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>