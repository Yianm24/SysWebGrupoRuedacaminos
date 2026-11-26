<?php $esAdmin = (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] == 6) ? '1' : '0'; ?>
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 w-100" id="tablaEmpleado" data-es-admin="<?= $esAdmin ?>">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">CÉDULA</th>
                    <th>NOMBRE COMPLETO</th>
                    <th>TELÉFONO</th>
                    <th>EMERGENCIA</th>
                    <th>CARGO</th>
                    <th class="text-center">ESTADO</th>
                    <?php if ($esAdmin === '1'): ?>
                        <th class="pe-4 text-center">ACCIONES</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>