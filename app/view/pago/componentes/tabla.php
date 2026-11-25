<?php
$rolUsuario = (int)($_SESSION['usuario']['rol'] ?? 0);
$esAdmin = ($rolUsuario === 6);
$puedeRegistrar = in_array($rolUsuario, [2, 6], true);
?>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0"
                id="tablaPagos"
                data-es-admin="<?= $esAdmin ? '1' : '0' ?>"
                data-puede-registrar="<?= $puedeRegistrar ? '1' : '0' ?>">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">CÓDIGO ENVÍO</th>
                    <th class="text-center">ESTATUS</th>
                    <th>MONTO TOTAL</th>
                    <th>MONTO ABONADO</th>
                    <th class="text-center">CANTIDAD</th>
                    <th>MONTO RESTANTE</th>
                    <th class="text-center">ESTADO</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>