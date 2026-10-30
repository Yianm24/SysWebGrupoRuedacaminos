<div class="modal fade" id="modalChofer" tabindex="-1" aria-labelledby="miModalPequenoLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">

        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5">Seleccionar Chofer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <select class="form-select form-select-sm" aria-label="Seleccionar Empleado" name="cod_empleado" required>
                    <option selected>Empleados</option>
                    <?php if (!empty($datosForaneos['empleado'])): ?>
                        <?php foreach ($datosForaneos['empleado'] as $empleado): ?>
                            <option value="<?= $empleado['cod_empleado']; ?>"><?php echo $empleado['nombre'] . ' ' . $empleado['apellido']; ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay empleados con el cargo especificado</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Seleccionar</button>
            </div>

        </div>
    </div>
</div>