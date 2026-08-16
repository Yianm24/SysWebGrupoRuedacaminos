<div class="modal fade" id="modalMetodoPago" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=metodopago" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="cod-metodo" name="cod_metodo">
                    <div class="input-group">
                        <select class="form-select" id="moneda" name="moneda" style="max-width: 80px;" aria-label="Moneda">
                            <!-- <option  id="chancleta" selected>cualquier cosa</option> -->
                            <?php
                            foreach ($regMoneda as $dato): ?>
                                <option value="<?php echo $dato['cod_moneda']; ?>"><?php echo $dato['abreviatura']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="ej: Pago Movil">
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="" class="btn btn-primary"></button>
                </footer>
            </form>
        </div>
    </div>
</div>