<div class="modal fade" id="modalModelo" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="cod-modelo" name="cod_modelo">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Modelo</label>
                        <input type="text" class="form-control" id="nombre_modelo" name="nombre_modelo" placeholder="Ej: Toyota" required>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" id="marca" name="marca">
                            <option selected>Marca</option>
                            <?php foreach ($marcasRegistros as $registro): ?>
                                <option value=<?= $registro['cod_marca'] ?>><?= $registro['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
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