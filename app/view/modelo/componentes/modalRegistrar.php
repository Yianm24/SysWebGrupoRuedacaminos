<div class="modal fade" id="registrarModelo" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-rulers"></i> Registrar Nueva Modelo de Vehiculo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="input-group">
                        <select class="form-select" id="moneda" name="moneda" style="max-width: 80px;" aria-label="Moneda">
                            <?php
                            foreach ($registros as $dato): ?>
                                <option value="<?php echo $dato['cod_marca']; ?>"><?php echo $dato['nombre_marca']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="ej: Pago Movil">
                    </div>
                    
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="tipoSolicitud" value="registrar" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>