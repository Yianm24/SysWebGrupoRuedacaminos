<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="tablaPrecios">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">CÓDIGO</th>
                    <th>TIPO VEHÍCULO</th>
                    <th>PRECIO ($/Km)</th>
                    <th class="text-center pe-4">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($registros)) {
                    foreach ($registros as $fila): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">T-<?= $fila['cod_preciokilometraje'] ?></td>
                            <td class="text-secondary"><?= $fila['nombre_vehiculo'] ?? 'Sin definir' ?></td>
                            <td class="text-secondary">$ <?= number_format($fila['monto_tarifa'], 2) ?></td>
                            <td class="pe-4 text-center">
                                <a href="#" class="text-secondary me-3 btn-editar" data-bs-toggle="modal" data-bs-target="#modalEditar" data-id="<?= $fila['cod_preciokilometraje'] ?>" data-vehiculo="<?= $fila['nombre_vehiculo'] ?? 'Sin definir' ?>" data-precio="<?= $fila['monto_tarifa'] ?>"><i class="bi bi-pencil"></i></a>
                                <a href="#" class="text-secondary btn-eliminar" data-id="<?= $fila['cod_preciokilometraje'] ?>" data-bs-toggle="modal" data-bs-target="#modalConfirmacion"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; 
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No hay registros disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
