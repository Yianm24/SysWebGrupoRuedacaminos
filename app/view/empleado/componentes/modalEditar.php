<?php if (!isset($listaCargos)) $listaCargos = []; ?>

<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">          
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">     
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="editarModalLabel"><i class="bi bi-pencil-square"></i> Editar Empleado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>
 
            <form action="?url=empleado" method="POST" id="formEditarEmpleado">
                <div class="modal-body">
                    <input type="hidden" name="tipoSolicitud" value="actualizar">
                    <input type="hidden" name="id_empleado_editar" id="id_empleado_editar" value="">
                    
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="cedula_editar" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="cedula_editar" name="cedula_editar" required>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="nombre_editar" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre_editar" name="nombre_editar" required>
                        </div>
                        <div class="col-md-4">
                            <label for="apellido_editar" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido_editar" name="apellido_editar" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="telefono_editar" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono_editar" name="telefono_editar" required>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="telefono_emergencia_editar" class="form-label">Telf. Emergencia</label>
                            <input type="tel" class="form-control" id="telefono_emergencia_editar" name="telefono_emergencia_editar" required>
                        </div>
                        <div class="col-md-4">
                            <label for="cod_cargo_editar" class="form-label">Cargo</label>
                            <select class="form-select" id="cod_cargo_editar" name="cod_cargo_editar" required>
                                <option value="" disabled>Seleccionar...</option>
                                <?php foreach ($listaCargos as $cargo): ?>
                                    <option value="<?= $cargo['cod_cargo'] ?>"><?= ucfirst($cargo['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                </footer>
            </form>
        </div>
    </div>
</div>