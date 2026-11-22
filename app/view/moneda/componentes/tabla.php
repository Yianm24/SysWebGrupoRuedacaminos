<div class="card-body p-0">
    <div class="table-responsive">
        <table id="tablaMoneda" class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">ABREVIATURA</th>
                    <th>NOMBRE</th>
                    <?php if ($_SESSION['usuario']['rol'] == '6'): ?>
                        <th>ESTADO</th>
                        <th class="text-end pe-4">ACCIONES</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>