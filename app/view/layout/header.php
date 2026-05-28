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
        <div class="list-group list-group-flush mt-2">
            <a href="?url=dashboard" class="list-group-item list-group-item-action <?= $current_url == 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a href="?url=cliente" class="list-group-item list-group-item-action <?= $current_url == 'cliente' ? 'active' : '' ?>">
                <i class="bi bi-people-fill me-2"></i> Clientes
            </a>
            <a href="?url=envio" class="list-group-item list-group-item-action <?= $current_url == 'envio' ? 'active' : '' ?>">
                <i class="bi bi-box-seam me-2"></i> Envíos
            </a>
            <a href="?url=despacho" class="list-group-item list-group-item-action <?= $current_url == 'despacho' ? 'active' : '' ?>">
                <i class="bi bi-boxes me-2"></i> Despacho
            </a>
            <a href="?url=pago" class="list-group-item list-group-item-action <?= $current_url == 'pago' ? 'active' : '' ?>">
                <i class="bi bi-wallet2 me-2"></i> Pagos
            </a>
            <a href="?url=reportes" class="list-group-item list-group-item-action <?= $current_url == 'reportes' ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-bar-graph me-2"></i> Generar Reportes
            </a>
            <a href="?url=empleado" class="list-group-item list-group-item-action <?= $current_url == 'empleado' ? 'active' : '' ?>">
                <i class="bi bi-person-fill me-2"></i> Empleado/Usuarios
            </a>
            <a href="?url=flota" class="list-group-item list-group-item-action <?= $current_url == 'flota' ? 'active' : '' ?>">
                <i class="bi bi-truck me-2"></i> Flota
            </a>
            <a href="?url=metodospago" class="list-group-item list-group-item-action <?= $current_url == 'metodospago' ? 'active' : '' ?>">
                <i class="bi bi-wallet2 me-2"></i> Métodos de Pago
            </a>
            <a href="?url=bancos" class="list-group-item list-group-item-action <?= $current_url == 'bancos' ? 'active' : '' ?>">
                <i class="bi bi-wallet2 me-2"></i> Bancos
            </a>
            <a href="?url=moneda" class="list-group-item list-group-item-action <?= $current_url == 'moneda' ? 'active' : '' ?>">
                <i class="bi bi-currency-dollar me-2"></i> Moneda
            </a>
            <a href="?url=cambiomoneda" class="list-group-item list-group-item-action <?= $current_url == 'cambiomoneda' ? 'active' : '' ?>">
                <i class="bi bi-currency-dollar me-2"></i> Cambio Moneda
            </a>
             <a href="?url=unidadesmedida" class="list-group-item list-group-item-action <?= $current_url == 'unidadesmedida' ? 'active' : '' ?>">
                <i class="bi bi-rulers me-2"></i> Unidad de Medida
            </a>
            <a href="?url=kilometraje" class="list-group-item list-group-item-action <?= $current_url == 'kilometraje' ? 'active' : '' ?>">
                <i class="bi bi-currency-dollar me-2"></i> Precio Kilometraje
            </a>
            <a href="?url=rol" class="list-group-item list-group-item-action <?= $current_url == 'rol' ? 'active' : '' ?>">
                <i class="bi bi-person-badge me-2"></i> Roles
            </a>
            
        </div>
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
