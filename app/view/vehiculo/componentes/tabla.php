<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light table-header-custom">
                <tr>
                    <th class="ps-4">PLACA</th>
                    <th>COLOR</th>
                    <th>TIPO VEHÍCULO</th>
                    <th>MODELO</th>
                    <th class="text-center">AÑO</th>
                    <th class="pe-4 text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $dato):?>
                    <tr>
                        <td class="ps-4 fw-medium"><?= $dato['placa'] ?></td>
                        <td>
                            <span class="fw-medium"><?= $dato['color'] ?></span>
                        </td>
                        <td class="text-secondary"><?php switch($dato['cod_tipovehiculo']) { case 1: echo "Grande"; break; case 2: echo "Mediano"; break; case 3: echo "Pequeño"; break; default: echo "Desconocido"; } ?></td>
                        <td class="text-secondary"><?php switch($dato['cod_modelo']) { case 1: echo "Fiat"; break; case 2: echo "Canguro"; break; case 3: echo "Fiorino"; break; default: echo "Desconocido"; } ?></td>
                        <td class="text-center">
                            <span class="fw-medium"><?= $dato['ano'] ?></span>
                        </td>
                        <td class="pe-4 text-center">

                            <!--Elementos para Actualizar un vehiculo-->
                            <input type="hidden" class="codigo_vehiculo" >    
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Actualizar" data-bs-toggle="modal" data-bs-target="#actualizarVehiculo"
                                datos-cod-vehiculo="<?php echo $dato['cod_vehiculo']; ?>"
                                datos-placa="<?php echo $dato['placa']; ?>"
                                datos-color="<?php echo $dato['color']; ?>"
                                datos-tipovehiculo="<?php echo $dato['cod_tipovehiculo']; ?>"
                                datos-modelo="<?php echo $dato['cod_modelo']; ?>"
                                datos-ano="<?php echo $dato['ano']; ?>"
                                >
                                <i class="bi bi-pencil"></i>
                            </button>
    
                            <form action="#" class="formEliminar" method="POST" style="display: inline;">
                                <fieldset style="display: inline;">
                                    <!-- Elementos para eliminar un vehiculo -->
                                    <input type="hidden" name="cod_vehiculo" value="<?= $dato['cod_vehiculo'] ?>">
                                    <button type="button" name="tipoSolicitud" value="eliminar" class="btn btn-link text-secondary p-0 m-0 align-baseline botonEliminar" title="Eliminar" >
                                        <i class="bi bi-trash"></i>
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
       const formulariosEliminar = document.querySelector('form.formEliminar');
    
        
    /*console.log("Formularios encontrados:", formulariosEliminar);
    formulariosEliminar.forEach((formulario, indice) => {
        console.log(`Formulario #${indice} encontrado:`, formulario);
    });
       
    const botonEliminar = document.querySelectorAll('.botonEliminar');
    botonEliminar.forEach((b) => {
        b.addEventListener("click", (event) => {
            console.log("Evento de clic detectado:", event.target);
        });
    });*/

    });
    



    /*console.log("botones encontrados a traves del evento clic");
    
    //console.log("botones encontrados a traves del evento clic");*/


    /*function alertaEliminarVehiculo() {
        console.log("Formulario a eliminar:", formulariosEliminar); // Verificar que se está seleccionando el formulario correcto
        //console.log("indice del formulario a eliminar:", formulariosEliminar.); // Verificar el índice del formulario
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, enviar el formulario
                //formulariosEliminar[0].submit();
            }
        });
        return false; // Evitar que el formulario se envíe inmediatamente
    }*/
    </script>