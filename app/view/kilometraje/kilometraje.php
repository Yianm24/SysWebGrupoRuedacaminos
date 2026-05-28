<?php
$status = isset($_GET['status']) ? $_GET['status'] : '';
$alertaClase = 'd-none';
$alertaMensaje = '';
$alertaIcono = '';

if ($status === 'success_registro') {
    $alertaClase = 'alert-success'; $alertaMensaje = 'Registro de Precio de Kilometraje realizado exitosamente.'; $alertaIcono = 'bi-check-circle-fill';
} elseif ($status === 'success_eliminacion') {
    $alertaClase = 'alert-success'; $alertaMensaje = 'Eliminación del Precio de Kilometraje realizado exitosamente.'; $alertaIcono = 'bi-check-circle-fill';
} elseif ($status === 'error_duplicado') {
    $alertaClase = 'alert-danger'; $alertaMensaje = 'El tipo de vehículo ya posee una tarifa registrada.'; $alertaIcono = 'bi-x-circle-fill';
} elseif ($status === 'error_vinculado') {
    $alertaClase = 'alert-danger'; $alertaMensaje = 'No se puede eliminar la tarifa, se encuentra vinculada a servicios en curso.'; $alertaIcono = 'bi-x-circle-fill';
} elseif ($status === 'error_validacion') {
    $alertaClase = 'alert-warning'; $alertaMensaje = 'Datos ingresados no cumplen con los estándares exigidos.'; $alertaIcono = 'bi-exclamation-triangle-fill';
}
?>

<div class="container-fluid py-5 px-4">
    <div class="row">
        <div class="col-12 mb-4">
            
            <header class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 text-primary fw-bold"><i class="bi bi-currency-dollar"></i> Precios por Kilometraje</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerPrecio">
                    <i class="bi bi-plus-circle"></i> Registrar Tarifa
                </button> 
            </header>

            <div id="alertaSistema" class="alert <?php echo $alertaClase; ?> alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi <?php echo $alertaIcono; ?> me-2"></i> <strong><?php echo $alertaMensaje; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            
            <?php require 'componentes/modalRegistrar.php'; ?>

            <section class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">Directorio de Tarifas</h4>
                    <div class="input-group" style="max-width: 250px;">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 text-muted" id="inputBusqueda" placeholder="Buscar tarifa...">
                    </div>
                </div>

                <?php require 'componentes/tabla.php'; ?>

                <footer class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center px-4 py-3">
                    <span class="text-muted small">Mostrando resultados</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm px-3 text-muted" disabled>Anterior</button>
                        <button class="btn btn-outline-secondary btn-sm px-3 text-muted">Siguiente</button>
                    </div>
                </footer>
            </section>
            
        </div>
    </div>
</div> <div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-danger" id="modalConfirmacionLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-0 fs-5">¿Estás seguro que deseas eliminar esta tarifa de la lista?</p>
                <small class="text-muted">Si está vinculada a envíos en curso, el sistema bloqueará la acción.</small>
            </div>
            <div class="modal-footer border-top-0 justify-content-center">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <form action="#" method="POST" class="m-0">
                    <input type="hidden" name="action" value="eliminar">
                    <input type="hidden" name="id_tarifa" id="id_tarifa_eliminar" value="">
                    <input type="hidden" name="codigo_tipovehiculo" id="codigo_tipovehiculo_eliminar" value="">
                    <button type="submit" class="btn btn-danger fw-bold px-4">Sí, Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Validar el Formulario de Registro
    document.getElementById('formPrecioKilometraje').addEventListener('submit', function(event) {
        const precioInput = document.getElementById('precio_kilometraje').value;
        const alerta = document.getElementById('alertaSistema');
        
        if (precioInput === "" || isNaN(precioInput) || Number(precioInput) <= 0) {
            event.preventDefault(); 
            alerta.classList.remove('d-none', 'alert-success');
            alerta.classList.add('alert-danger');
            alerta.innerHTML = '<i class="bi bi-x-circle-fill me-2"></i> <strong>Error:</strong> Datos ingresados no cumplen con los estándares exigidos.';
            document.getElementById('precio_kilometraje').focus();
        }
    });

    // Envío al Modal para borrado lógico
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function() {
            document.getElementById('id_tarifa_eliminar').value = this.getAttribute('data-id');
            document.getElementById('codigo_tipovehiculo_eliminar').value = this.getAttribute('data-codigo');
        });
    });

    // Filtro de búsqueda
    document.getElementById('inputBusqueda').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelector("#tablaPrecios tbody").rows;
        
        for (let i = 0; i < rows.length; i++) {
            // Ignorar filas comentadas o sin celdas
            if(rows[i].cells.length > 1) {
                let col1 = rows[i].cells[0].textContent.toUpperCase();
                let col2 = rows[i].cells[1].textContent.toUpperCase();
                
                if (col1.indexOf(filter) > -1 || col2.indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    });
</script>