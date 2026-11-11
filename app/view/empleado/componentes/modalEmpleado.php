<?php if (!isset($listaCargos)) $listaCargos = []; ?>
<div class="modal fade" id="modalEmpleado" tabindex="-1" aria-hidden="true">          
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">     
            <header class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </header>

            <form action="?url=empleado" method="POST" id="formEmpleado">
                <div class="modal-body">
                    <input type="hidden" name="" id="id_empleado" value="">
                    
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="cedula" class="form-label">Cédula</label>
                            <input type="text" class="form-control solo-numeros" id="cedula" name="cedula" placeholder="Ej: 12345678" minlength="7" maxlength="9" required>
                            <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control solo-letras" id="nombre" name="nombre" placeholder="Ej: Juan" minlength="3" maxlength="25" required>
                            <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control solo-letras" id="apellido" name="apellido" placeholder="Ej: Pérez" minlength="3" maxlength="25" required>
                            <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control solo-numeros" id="telefono" name="telefono" placeholder="04141234567" minlength="11" maxlength="11" required>
                            <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="telefono_emergencia" class="form-label">Telf. Emergencia (Opcional)</label>
                            <input type="text" class="form-control solo-numeros opcional" id="telefono_emergencia" name="telefono_emergencia" placeholder="04147778654" minlength="11" maxlength="11">
                            <span class="mensaje-error text-danger font-monospace small" style="display:none;"></span>
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
                    <button type="submit" name="tipoSolicitud" id="btnSubmitModal" value="" class="btn btn-primary" disabled></button>
                </footer>
            </form>
        </div>
    </div>
</div>