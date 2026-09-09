<?php if (!isset($listaCargos)) $listaCargos = []; ?>
<div class="modal fade" id="registerEmpleado" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">          
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">     
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="registerModalLabel"><i class="bi bi-person-plus"></i> Registro de Empleado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>
 
            <form action="?url=empleado" method="POST" id="formRegistroEmpleado">
                <div class="modal-body">
                    <input type="hidden" name="tipoSolicitud" value="registrar">
                    
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="cedula" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Ej: 12345678" required>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Juan" required>
                        </div>
                        <div class="col-md-4">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ej: Pérez" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="04141234567" required>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="telefono_emergencia" class="form-label">Telf. Emergencia</label>
                            <input type="tel" class="form-control" id="telefono_emergencia" name="telefono_emergencia" placeholder="04147778654">
                        </div>
                        <div class="col-md-4">
                            <label for="cod_cargo" class="form-label">Cargo</label>
                            <select class="form-select" id="cod_cargo" name="cod_cargo" required>
                                <option value="" selected disabled>Seleccionar...</option>
                                <?php foreach ($listaCargos as $cargo): ?>
                                    <option value="<?= $cargo['cod_cargo'] ?>"><?= ucfirst($cargo['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Registrar</button>
                </footer>
            </form>
        </div>
    </div>
</div>