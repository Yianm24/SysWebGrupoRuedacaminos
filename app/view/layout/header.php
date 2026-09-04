<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo RuedaCaminos C.A - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!--Estilos custom-->
    <link href="assets/css/styles.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="assets/icons/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body>

    <?php
    $current_url = isset($_GET['url']) ? $_GET['url'] : 'dashboard';
    ?>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="shadow-sm">
            <div class="sidebar-heading">
                <img src="app/view/img/logo2.png" alt="Logo" class="img-fluid mt-2" style="max-width: 50px;">RuedaCaminos
            </div>
            <ul class="nav nav-pills flex-column mb-auto gap-2">

                <div class="list-group list-group-flush mt-2">

                    <li class="nav-item btn-group ms-2 mb-2 d-flex shadow-sm">

                        <button type="button" class="btn list-group-item list-group-item-action text-start w-100 <?= $current_url == 'dashboard' ? 'active' : '' ?>" onclick="window.location.href='?url=dashboard'">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </button>
                    </li>

                    <li class="nav-item btn-group ms-2 mb-2 d-flex shadow-sm">

                        <button type="button" class="btn list-group-item list-group-item list-group-item-action text-start w-100 <?= $current_url == 'cliente' ? 'active' : '' ?>" onclick="window.location.href='?url=cliente'">
                            <i class="bi bi-people-fill me-2"></i> Cliente
                        </button>
                    </li>

                    <li class="nav-item ms-2 mb-2">
                        <div class="btn-group d-flex shadow-sm">
                            <button type="button" class="btn list-group-item list-group-item-action text-start w-100 <?= $current_url == 'envio' ? 'active' : '' ?>" onclick="window.location.href='?url=envio'">
                                <i class="bi bi-box-seam me-2"></i> Envío
                            </button>

                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split flex-shrink-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Icono de Menú Desplegable</span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow w-100">
                                <li>
                                    <a href="?url=kilometraje" class="list-group-item list-group-item-action <?= $current_url == 'kilometraje' ? 'active' : '' ?>">
                                        <i class="bi bi-currency-dollar me-2"></i> Precio Kilometraje
                                    </a>
                                </li>

                                <li>
                                    <a href="?url=unidadesmedida" class="list-group-item list-group-item-action <?= $current_url == 'unidadesmedida' ? 'active' : '' ?>">
                                        <i class="bi bi-rulers me-2"></i> Unidad de Medida
                                    </a>
                                </li>

                                <li>
                                    <a href="?url=estado" class="list-group-item list-group-item-action <?= $current_url == 'estado' ? 'active' : '' ?>">
                                        <i class="bi bi-map me-2"></i> Estado
                                    </a>
                                </li>

                                <li>
                                    <a href="?url=municipio" class="list-group-item list-group-item-action <?= $current_url == 'municipio' ? 'active' : '' ?>">
                                        <i class="bi bi-geo-alt me-2"></i> Municipio
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item ms-2 mb-2">
                        <div class="btn-group d-flex shadow-sm">
                            <button type="button" class="btn list-group-item list-group-item-action text-start w-100 <?= $current_url == 'empleado' ? 'active' : '' ?>" onclick="window.location.href='?url=empleado'">
                                <i class="bi bi-person-fill me-2"></i> Empleado
                            </button>

                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split flex-shrink-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Icono de Menú Desplegable</span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow w-100">
                                <li>
                                    <a href="?url=cargo" class="list-group-item list-group-item-action <?= $current_url == 'cargo' ? 'active' : '' ?>">
                                        <i class="bi bi-person-vcard me-2"></i> Cargo
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item ms-2 mb-2">
                        <div class="btn-group d-flex shadow-sm">
                            <button type="button" class="btn list-group-item list-group-item-action text-start w-100  <?= $current_url == 'vehiculo' ? 'active' : '' ?>" onclick="window.location.href='?url=vehiculo'">
                                <i class="bi bi-truck me-2"></i> Vehículo
                            </button>

                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split flex-shrink-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Icono de Menú Desplegable</span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow w-100">
                                <li>
                                    <a href="?url=marca" class="list-group-item list-group-item-action <?= $current_url == 'marca' ? 'active' : '' ?>">
                                        <i class="bi bi-ev-front me-2"></i> Marca
                                    </a>
                                </li>

                                <li>
                                    <a href="?url=modelo" class="list-group-item list-group-item-action <?= $current_url == 'modelo' ? 'active' : '' ?>">
                                        <i class="bi bi-car-front me-2"></i>Modelo
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item btn-group ms-2 mb-2 d-flex shadow-sm">

                        <button type="button" class="btn list-group-item list-group-item-action text-start w-100 <?= $current_url == 'reporte' ? 'active' : '' ?>" onclick="window.location.href='?url=reporte'">
                            <i class="bi bi-file-earmark-bar-graph me-2"></i> Reporte
                        </button>
                    </li>

                    <li class="nav-item btn-group ms-2 mb-2 d-flex shadow-sm">
                        <button type="button" class="btn list-group-item list-group-item-action text-start w-100 <?= $current_url == 'despacho' ? 'active' : '' ?>" onclick="window.location.href='?url=despacho'">
                            <i class="bi bi-boxes me-2"></i> Despacho
                        </button>
                    </li>

                    <li class="nav-item ms-2 mb-2">
                        <div class="btn-group d-flex shadow-sm">
                            <button type="button" class="btn list-group-item list-group-item-action text-start w-100 <?= $current_url == 'cambiomoneda' ? 'active' : '' ?>" onclick="window.location.href='?url=cambiomoneda'">
                                <i class="bi bi-currency-exchange me-2"></i> Cambio Moneda
                            </button>
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split flex-shrink-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Icono de Menú Desplegable</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow w-100">
                                <li>
                                    <a href="?url=moneda" class="list-group-item list-group-item-action <?= $current_url == 'moneda' ? 'active' : '' ?>">
                                        <i class="bi bi-coin me-2"></i> Moneda
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item ms-2 mb-2">
                        <div class="btn-group d-flex shadow-sm">
                            <button type="button" class="btn list-group-item list-group-item-action text-start w-100 <?= $current_url == 'pago' ? 'active' : '' ?>" onclick="window.location.href='?url=pago'">
                                <i class="bi bi-wallet2 me-2"></i> Pago
                            </button>

                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split flex-shrink-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Icono de Menú Desplegable</span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow w-100">
                                <li>
                                    <a href="?url=metodopago" class="list-group-item list-group-item-action <?= $current_url == 'metodopago' ? 'active' : '' ?>">
                                        <i class="bi bi-credit-card me-2"></i> Método de Pago
                                    </a>
                                </li>

                                <li>
                                    <a href="?url=banco" class="list-group-item list-group-item-action <?= $current_url == 'banco' ? 'active' : '' ?>">
                                        <i class="bi bi-bank me-2"></i> Banco
                                    </a>
                                </li>

                                <li>
                                    <a href="?url=cuenta" class="list-group-item list-group-item-action <?= $current_url == 'cuenta' ? 'active' : '' ?>">
                                        <i class="bi bi-cash-coin me-2"></i> Cuenta
                                    </a>
                                </li>



                            </ul>
                        </div>
                    </li>

                    <li class="nav-item ms-2 mb-2">
                        <div class="btn-group d-flex shadow-sm">

                            <button type="button" class="btn list-group-item list-group-item-action text-start w-100 <?= $current_url == 'usuario' ? 'active' : '' ?>" onclick="window.location.href='?url=usuario'">
                                <i class="bi bi-person-fill me-2"></i> Usuario
                            </button>

                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split flex-shrink-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Icono de Menú Desplegable</span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow w-100">
                                <li>
                                    <a href="?url=rol" class="list-group-item list-group-item-action <?= $current_url == 'rol' ? 'active' : '' ?>">
                                        <i class="bi bi-person-badge me-2"></i> Rol
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                </div>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" class="d-flex flex-column min-vh-100 w-100">
            <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-light border" id="sidebarToggle"><i class="bi bi-list fs-5"></i></button>
                    <div class="ms-auto d-flex align-items-center">
                        <span class="text-muted fw-bold"><i class="bi bi-person-circle fs-5 me-2 text-primary"></i> Maria Laura</span>
                    </div>
                </div>
            </nav>

            <main class="container-fluid">