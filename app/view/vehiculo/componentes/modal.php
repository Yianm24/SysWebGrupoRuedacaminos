<div class="modal fade" id="modalVehiculo" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST" id="formFlota">
                <div class="modal-body">
                    <input type="hidden" name="cod_vehiculo" id="cod-vehiculo">

                    <fieldset class="row mb-3">

                        <div class="col-md-6">
                            <label for="placa" class="form-label">Placa:</label>
                            <input type="text" class="form-control" id="placa" name="placa" placeholder="Ej: ABC12D" required>
                        </div>
                        <div class="col-md-6">
                            <label for="color" class="form-label">Color:</label>
                            <input type="text" class="form-control" id="color" name="color" required>
                        </div>

                    </fieldset>

                    <fieldset class="row mb-3">

                        <div class="col-md-12">
                            <div class="input-group ">
                                <select class="form-select" id="modelo" name="modelo">
                                    <option value="" selected>Modelo</option>
                                    <?php foreach ($modelosRegistros as $registro): ?>
                                        <option value=<?= $registro['cod_modelo'] ?> required ><?= $registro['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <input class="form-control" list="ano-options" id="anio" name="anio" placeholder="Año" required>
                                <datalist id="ano-options">
                                    <?php
                                    $anoActual = date("Y");
                                    for ($i = $anoActual; $i >= 1950; $i--) {
                                        echo "<option value='$i' " . ($i ? 'selected' : '') . ">$i</option>";
                                    }
                                    ?>
                                </datalist>
                            </div>
                        </div>

                    </fieldset>

                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">Dimensiones:</legend>
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="number" class="form-control" id="anchura" name="anchura" step="0.01" placeholder="Anchura (m)" required>
                                <input type="number" class="form-control" id="altura" name="altura" step="0.01" placeholder="Altura (m)" required>
                                <input type="number" class="form-control" id="peso_max" name="peso_max" step="0.01" placeholder="Peso máximo (kg)" required>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button name="tipoSolicitud" value="" type="submit" class="btn btn-primary"></button>
                </footer>
            </form>
        </div>
    </div>
</div>