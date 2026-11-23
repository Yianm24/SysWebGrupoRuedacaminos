<?php $esAdmin = (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] == 6) ? '1' : '0'; ?>
<div class="card-body p-0">
    <div class="table-responsive">
        <table id="tablaCambio" class="table table-hover align-middle mb-0 w-100" data-es-admin="<?= $esAdmin ?>">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">FECHA</th>
                    <th>HORA</th>
                    <th>MONEDA</th>
                    <th>TASA</th>
                    <?php if ($esAdmin === '1'): ?>
                        <th class="text-end pe-4">ACCIONES</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>