<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4 text-primary"><i class="bi bi-map-fill"></i> Módulo de Logística y Rutas</h2>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Asignación de Envío</h5>
            </div>
            <div class="card-body">
                <form action="#" method="POST">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ubicacion" class="form-label">Código Envío</label>
                            <select class="form-select" id="ubicacion" name="ubicacion" required>
                                <option value="" selected disabled>Seleccionar Envío...</option>
                                <option value="1">Caracas</option>
                                <option value="2">Valencia</option>
                                <option value="3">Maracaibo</option>
                                <option value="4">Barquisimeto</option>
                            </select>
                        </div>
                    </div>

                    <h5 class="mt-4 mb-3 border-bottom pb-2">Asignación de Recursos</h5>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="vehiculo" class="form-label">Vehículo</label>
                            <select class="form-select" id="vehiculo" name="vehiculo" required>
                                <option value="" selected disabled>Seleccionar Vehículo...</option>
                                <option value="1">Camión NPR - ABC12D</option>
                                <option value="2">Furgón - XYZ987</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="chofer" class="form-label">Chofer</label>
                            <select class="form-select" id="chofer" name="chofer" required>
                                <option value="" selected disabled>Seleccionar Chofer...</option>
                                <option value="1">Juan Pérez</option>
                                <option value="2">Pedro Gómez</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-pin-map-fill"></i> Asignar Ruta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>