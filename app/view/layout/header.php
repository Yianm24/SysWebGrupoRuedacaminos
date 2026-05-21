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
            <a href="?url=empleado" class="list-group-item list-group-item-action <?= $current_url == 'empleado' ? 'active' : '' ?>">
                <i class="bi bi-person-fill me-2"></i> Empleado
            </a>
            <a href="?url=calculadora" class="list-group-item list-group-item-action <?= $current_url == 'calculadora' ? 'active' : '' ?>">
                <i class="bi bi-calculator me-2"></i> Calculadora
            </a>
            <a href="?url=envio" class="list-group-item list-group-item-action <?= $current_url == 'envio' ? 'active' : '' ?>">
                <i class="bi bi-box-seam me-2"></i> Envíos
            </a>
            <a href="?url=pago" class="list-group-item list-group-item-action <?= $current_url == 'pago' ? 'active' : '' ?>">
                <i class="bi bi-wallet2 me-2"></i> Pagos
            </a>
            <a href="?url=flota" class="list-group-item list-group-item-action <?= $current_url == 'flota' ? 'active' : '' ?>">
                <i class="bi bi-tools me-2"></i> Flota
            </a>
            <!-- <a href="?url=seguimiento" class="list-group-item list-group-item-action <?= $current_url == 'seguimiento' ? 'active' : '' ?>">
                <i class="bi bi-geo-alt-fill me-2"></i> Seguimiento
            </a> -->
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
            <div class="container-fluid">
                <button class="btn btn-light border" id="sidebarToggle"><i class="bi bi-list fs-5"></i></button>
                <div class="ms-auto d-flex align-items-center">
                    <span class="text-muted fw-bold"><i class="bi bi-person-circle fs-5 me-2 text-primary"></i> Maria Laura</span>
                </div>
            </div>
        </nav>
        
        <main class="container-fluid">
