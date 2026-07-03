<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">Fecha</th>
                    <th>Hora</th>
                    <th>Moneda</th>
                    <th>Tasa</th>
                    <th class="pe-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $tasaAnterior = null;
                if (!empty($registros)): 
                    foreach ($registros as $fila): ?>
                    <tr>
                        <td class="ps-4 text-secondary"><?= date('d/m/Y', strtotime($fila['fecha'])) ?></td>
                        <td class="fw-medium"><?= date('h:i A', strtotime($fila['fecha'])) ?></td>
                        <td class="fw-medium"><?= $fila['abreviatura'] ?></td>
                        <td class="fw-bold">
                            <?= number_format($fila['tasa'], 2) ?> VES
                            <?php if ($tasaAnterior !== null): 
                                $color = ($fila['tasa'] >= $tasaAnterior) ? "text-success" : "text-danger";
                                $icono = ($fila['tasa'] >= $tasaAnterior) ? "bi-arrow-up" : "bi-arrow-down";
                            ?>
                                <small class="<?= $color ?> ms-1"><i class="bi <?= $icono ?>"></i></small>
                            <?php endif; $tasaAnterior = $fila['tasa']; ?>
                        </td>
                        <td class="pe-4 text-center">
                            <a href="#" class="text-secondary me-2 btn-editar" title="Editar"
                            data-bs-toggle="modal" data-bs-target="#modalEditarCambio" 
                            data-id="<?= $fila['cod_cambio'] ?>" 
                            data-tasa="<?= $fila['tasa'] ?>"
                            data-moneda="<?= $fila['cod_moneda'] ?>">
                            <i class="bi bi-pencil"></i>
                            </a>

                            <a href="#" class="text-secondary btn-eliminar" 
                            data-id="<?= $fila['cod_cambio'] ?>">
                            <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; 
                else: echo "<tr><td colspan='5' class='text-center'>No hay registros.</td></tr>"; 
                endif; ?>
            </tbody>
        </table>
    </div>
</div>