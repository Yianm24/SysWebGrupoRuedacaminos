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
        
        <div class="col-xl-5 col-lg-6 mb-4">
            
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2 class="mb-4 text-primary"><i class="bi bi-currency-dollar"></i> Gestión de Precios por Kilometraje</h2>
                    
                    <div id="alertaSistema" class="alert <?php echo $alertaClase; ?> alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi <?php echo $alertaIcono; ?> me-2"></i> <strong><?php echo $alertaMensaje; ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Información de la Tarifa</h5>
                        </div>
                        <div class="card-body">
                            <form id="formPrecioKilometraje" action="#" method="POST">
                                <input type="hidden" name="action" value="registrar">

                                <div id="natural-fields">
                                    <div class="row mb-3">
                                        <div class="col-md-12 mb-3">
                                            <label for="codigo_tipovehiculo" class="form-label">Tipo de Vehículo</label>
                                            <select class="form-select" id="codigo_tipovehiculo" name="codigo_tipovehiculo" required>
                                                <option value="" selected disabled>Seleccione un vehículo...</option>
                                                <option value="1">Camión NPR - Capacidad Alta</option>
                                                <option value="2">Furgón - Capacidad Media</option>
                                                <option value="3">Pick-Up - Capacidad Baja</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="precio_kilometraje" class="form-label">Precio por Kilómetro ($)</label>
                                            <input type="number" step="0.01" min="0.1" class="form-control" id="precio_kilometraje" name="precio_kilometraje" placeholder="0.00" required>
                                            <div class="form-text">Debe ser un valor numérico y mayor a 0.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary" id="btnGuardar">
                                        <i class="bi bi-save"></i> Guardar Tarifa
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tarifas Registradas</h5>
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0" id="inputBusqueda" placeholder="Buscar tarifa...">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tablaPrecios">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Código</th>
                                    <th>Tipo Vehículo</th>
                                    <th>Precio ($/Km)</th>
                                    <th class="text-center pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 fw-bold text-secondary">T-001</td>
                                    <td class="text-secondary">Camión NPR - Capacidad Alta</td>
                                    <td class="text-secondary">$ 2.50</td>
                                    <td class="pe-4 text-center">
                                        <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary text-decoration-none btn-eliminar" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalConfirmacion" data-id="1" data-codigo="1"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold text-secondary">T-002</td>
                                    <td class="text-secondary">Furgón - Capacidad Media</td>
                                    <td class="text-secondary">$ 1.80</td>
                                    <td class="pe-4 text-center">
                                        <a href="#" class="text-secondary me-2 text-decoration-none" title="Editar"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="text-secondary text-decoration-none btn-eliminar" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalConfirmacion" data-id="2" data-codigo="2"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center px-4 py-3">
                    <span class="text-muted small">Mostrando 2 de 2 tarifas</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm px-3 text-muted" disabled>Anterior</button>
                        <button class="btn btn-outline-secondary btn-sm px-3 text-muted">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
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

    document.getElementById('inputBusqueda').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelector("#tablaPrecios tbody").rows;
        
        for (let i = 0; i < rows.length; i++) {
            let col1 = rows[i].cells[0].textContent.toUpperCase();
            let col2 = rows[i].cells[1].textContent.toUpperCase();
            
            if (col1.indexOf(filter) > -1 || col2.indexOf(filter) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    });
</script>