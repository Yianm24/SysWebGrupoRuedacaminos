<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">FECHA</th>
                    <th>HORA</th>
                    <th>MONEDA</th>
                    <th>TASA</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($registros)): 
                    $registros = array_values($registros);
                    
                    foreach ($registros as $index => $fila): 
                        
                        $tasaComparar = $fila['tasa'];

                        for ($i = $index + 1; $i < count($registros); $i++) {
                            if (isset($registros[$i]['cod_moneda']) && $registros[$i]['cod_moneda'] == $fila['cod_moneda']) {
                                $tasaComparar = $registros[$i]['tasa'];
                                break;
                            }
                        }
                        
                        $color = "";
                        $icono = "";
                        if ($fila['tasa'] > $tasaComparar) {
                            $color = "text-success";
                            $icono = "bi-arrow-up";
                        } elseif ($fila['tasa'] < $tasaComparar) {
                            $color = "text-danger";
                            $icono = "bi-arrow-down";
                        } else {
                            $color = "text-secondary";
                            $icono = "bi-dash"; 
                        }
                ?>
                    <tr>
                        <td class="ps-4 fw-medium"><?= date('d/m/Y', strtotime($fila['fecha'])) ?></td>
                        <td class="text-secondary"><?= date('h:i A', strtotime($fila['fecha'])) ?></td>
                        <td class="text-secondary"><?= $fila['abreviatura'] ?></td>
                        <td class="fw-bold">
                            <?= number_format($fila['tasa'], 2) ?> VES
                            <?php if($icono != "bi-dash"): ?>
                                <small class="<?= $color ?> ms-1"><i class="bi <?= $icono ?>"></i></small>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-center">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline me-3 btn-editar" title="Editar"
                            data-bs-toggle="modal" data-bs-target="#modalEditarCambio" 
                            data-id="<?= $fila['cod_cambio'] ?>" 
                            data-tasa="<?= $fila['tasa'] ?>"
                            data-moneda="<?= $fila['cod_moneda'] ?>">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline btn-eliminar" title="Eliminar"
                            data-id="<?= $fila['cod_cambio'] ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; 
                else: echo "<tr><td colspan='5' class='text-center'>No hay registros.</td></tr>"; 
                endif; ?>
            </tbody>
        </table>
    </div>
</div>