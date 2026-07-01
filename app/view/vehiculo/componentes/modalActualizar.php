<div class="modal fade" id="actualizarVehiculo" tabindex="-1" aria-labelledby="actualizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-person-plus"></i> Actualización de Vehículo </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="#" method="POST" id="formFlota">
                <?php /*foreach ($registros as $dato):
                    if ($dato['cod_vehiculo'] == $_POST['cod_vehiculo']) {
                        echo $dato['cod_vehiculo'] . "<br>";
                        echo $dato['placa'] . "<br>";
                        echo $dato['color'] . "<br>";
                        echo $dato['ano'] . "<br>";
                        echo "encontrado";
                    }*/
                        //var_dump($datosEditable);

                    ?>
                    <?php //endforeach; ?>  
                                    
                <div class="modal-body">
                    <input type="hidden" id="cod-vehiculo" name="cod-vehiculo" >
                    <fieldset class="row mb-3">
                        
                            <div class="col-md-6">
                                <label for="placa" class="form-label">Placa</label>
                                <input type="text" class="form-control" id="placa" name="placa" placeholder="Ej: ABC12D" required>
                            </div>
                            <div class="col-md-6">
                                <label for="color" class="form-label">Color:</label>
                                <input type="text" class="form-control" id="color" name="color" required>
                            </div>

                    </fieldset>

                    <fieldset>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="input-group ">
                                    <input class="form-control" list="ano-options" id="ano" name="ano" placeholder="Año" required>
                                    <datalist id="ano-options">
                                    <?php
                                    $anoActual = date("Y");
                                        for ($i = $anoActual; $i >= 1950; $i--) {
                                        echo "<option value='$i' " . ( $i ? 'selected' : '') . ">$i</option>";
                                        }
                                    ?>
                                    </datalist>
                                    <select class="form-select" id="tipo-vehiculo" name="tipo-vehiculo">
                                        <option >TipoVehiculo</option>
                                        <option value="1">Grande</option>
                                        <option value="2">Mediano</option>
                                        <option value="3">Pequeño</option>
                                    </select>
                                    <select class="form-select" id="modelo" name="modelo">
                                        <option >Modelo</option>
                                        <option value="1">Fiesta</option>
                                        <option value="2">Canguro</option>
                                        <option value="3">Fiorino</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                 
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button name="tipoSolicitud" value="actualizar" type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Actualizar</button>
                </footer>
            </form>
        </div>
    </div>
</div>