<div class="card-body p-0">
    <div class="table-responsive">
        <table id="tablaEnvio" class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <!-- <th class="ps-4">CODIGO</th> -->
                    <th>REMITENTE</th>
                    <th>DESTINATARIO</th>
                    <th>DESTINO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>PESO TOTAL</th>
                    <th>STATUS</th>
                    <th>FECHA</th>
                    <?php if ($_SESSION['usuario']['rol'] == '6'): ?>
                        <th class="pe-4 text-center">ACCIONES</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>