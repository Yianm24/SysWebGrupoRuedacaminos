<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">CEDULA DEL USUARIO</th>
                    <th class="ps-4">NOMBRE DEL USUARIO</th>
                    <th class="ps-4">ROL DEL USUARIO</th>
                    <th class="text-end pe-4">ACCIONES</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-medium text-secondary"><?= $dato['cedula']; ?></td>
                        <td class="ps-4 fw-medium text-secondary"><?= $dato['nombre']; ?></td>
                        <td class="ps-4 fw-medium text-secondary"><?= $dato['nombre_rol']; ?></td>
                        <td class="text-end pe-4">
                            <!--Elementos para Actualizar un vehiculo-->
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#actualizarUsuario"
                                datos-cod-usuario="<?php echo $dato['cod_usuario']; ?>"
                                datos-nombre="<?php echo $dato['nombre']; ?>"
                                datos-cedula="<?php echo $dato['cedula']; ?>"
                                datos-password="<?php echo $dato['password']; ?>"
                                datos-cod-rol="<?php echo $dato['cod_rol']; ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="#" id="formEliminar" method="POST" style="display: inline;">
                                <fieldset style="display: inline;">
                                    <!-- Elementos para eliminar un vehiculo -->
                                    <input type="hidden" name="cod_usuario" value="<?= $dato['cod_usuario'] ?>">
                                    <button type="submit" name="tipoSolicitud" value="eliminar" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Eliminar" > <i class="bi bi-trash"></i>
                                    </button>
                                </fieldset>
                            </form>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- 
<script>
const formulario = document.getElementById('formEliminar')
function confirmarEliminacion() {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: 'Sí, ¡eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) 
            Swal.fire({
    title: "Deleted!",
    text: "Your file has been deleted.",
    icon: "warning",
  });
    });
}


formulario.addEventListener('submit', function(event){
event.preventDefault(); // Evita que el formulario se envíe automáticamente
confirmarEliminacion();
window.location.href = "?url=metodopago"; // Redirige a la página de listado después de la confirmación
})

</script> -->