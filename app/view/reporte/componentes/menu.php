<div class="row my-3 mx-3">
    <div class="col-md-12">
        <div class="card-header bg-white text-center border-bottom-0">
            <h5 class="mb-0 fs-2">Opciones de Reporte</h5>
        </div>

        <form id="formReporteIngresoFiltro" action="?url=reporte" method="POST">
            <input type="hidden" name="tipoSolicitud" value="ingresos">
            <input type="hidden" id="periodoIngreso" name="periodo" value="mes">
            <input type="hidden" id="fechaInicioIngreso" name="fecha_inicio" value="">
            <input type="hidden" id="fechaFinIngreso" name="fecha_fin" value="">

            <div class="card-body">
                <div class="col-md-10 input-group btn-group-lg">
                    <div class="me-2">
                        <button type="submit" id="reporteEnvio" name="tipoSolicitud" class="btn btn-primary" value="envios">
                            Envios Realizados
                        </button>
                    </div>

                    <div class="btn-group ms-2">
                        <button type="button" id="reportePago" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Ingresos Obtenidos
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button type="button" class="dropdown-item btn-filtro-ingreso" data-periodo="semana">
                                    Semanal
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item btn-filtro-ingreso" data-periodo="mes">
                                    Mensual
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#customReporte">
                                    Personalizado
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>