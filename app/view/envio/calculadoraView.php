<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4 text-primary"><i class="bi bi-calculator"></i> Calculadora de Precio Envios</h2>
        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Calcular Precio de Envios</h5>
            </div>
            <div class="card-body border-bottom">
                <form action="#" method="POST">
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="categoria_vehiculo" class="form-label">Datos de Paqueteria</label>
                            <div class="input-group ">
                            <input type="number" step="0.01" class="form-control" id="alto" name="alto" placeholder="Alto:" required>
                            <input type="number" step="0.01" class="form-control" id="largo" name="largo" placeholder="Largo:" required>
                            <input type="number" step="0.01" class="form-control" id="ancho" name="ancho" placeholder="Ancho:" required>
                            <input type="text" class="form-control" id="peso" name="peso" placeholder="Peso:" required>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                        
                            <label for="categoria_vehiculo" class="form-label">Tipo Vehiculo a Utilizar</label>
                                        <select class="form-select" id="categoria_vehiculo" name="categoria_vehiculo" required>
                                            <option value="pequeño">Camioneta pequeña</option>
                                            <option value="grande">Camioneta grande</option>
                                            <option value="gigante">Camion</option>
                                        </select>
                        </div>
                    <div class="col-md-4">
                        
                            <label for="tipo_punto" class="form-label">Ubicación destino</label>
                            <select class="form-select" id="ubicacion" name="ubicacion_select" required>
                                <option value="" selected disabled>Seleccionar Ubicación...</option>
                                <option value="1">Caracas</option>
                                <option value="2">Valencia</option>
                                <option value="3">Maracaibo</option>
                                <option value="4">Barquisimeto</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                             <label for="ubicacion" class="form-label">Ubicación despacho</label>
                            <select class="form-select" id="ubicacion" name="ubicacion_select" required>
                                <option value="" selected disabled>Seleccionar Ubicación...</option>
                                <option value="1">Caracas</option>
                                <option value="2">Valencia</option>
                                <option value="3">Maracaibo</option>
                                <option value="4">Barquisimeto</option>
                            </select>
                        </div>
                        </div>
               <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-wrench-adjustable"></i> Guardar Registro</button>
                    </div>
            </div>
           
            <div class="card-body">
                <div class="container text-center">
                    <div class="row bg-white ">
                        <div class="col align-self-center">
                            <h5 class="mb-0">Precio de envio aqui</h5>
                        </div>
                    </div>
                </div>
                    

                    

                    
                </form>
            </div>
        </div>
    </div>
</div>

