<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">NOMBRE DEL MÉTODO</th>
                    <th class="ps-4">MONEDA AFILIADA</th>
                    <th class="text-end pe-4">ACCIONES</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($registros as $dato): ?>
                    <tr>
                        <td class="ps-4 fw-medium text-secondary"><?= $dato['nombre']; ?></td>
                        <td class="ps-4 fw-medium text-secondary"><?= $dato['nombremoneda']; ?></td>
                        <td class="text-end pe-4">
                            <!--Elementos para Actualizar un vehiculo-->
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#modalMetodoPago"
                                datos-cod-metodo="<?php echo $dato['cod_metodo']; ?>"
                                datos-nombre="<?php echo $dato['nombre']; ?>"
                                datos-cod-moneda="<?php echo $dato['cod_moneda']; ?>"
                                datos-estado="<?php echo $dato['estado']; ?>">

                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="#" class="text-secondary btn-eliminar"
                                datos-cod-metodo="<?= $dato['cod_metodo'] ?>">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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


    formulario.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita que el formulario se envíe automáticamente
        confirmarEliminacion();
        window.location.href = "?url=metodopago"; // Redirige a la página de listado después de la confirmación
    })
</script>