<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo RuedaCaminos C.A - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        
        /* Sidebar layout */
        #wrapper { display: flex; transition: all 0.3s ease-in-out; }
        #sidebar-wrapper { min-height: 100vh; width: 250px; background-color: #ffffff; border-right: 1px solid #eef0f3; transition: margin .25s ease-out; }
        #sidebar-wrapper .sidebar-heading { padding: 1.5rem 1.25rem; font-size: 1.5rem; font-weight: 800; color: #0d6efd; border-bottom: 1px solid #eef0f3; }
        #sidebar-wrapper .list-group { width: 100%; }
        
        #page-content-wrapper { min-width: 0; width: 100%; display: flex; flex-direction: column; }
        
        body.sb-sidenav-toggled #sidebar-wrapper { margin-left: -250px; }
        
        /* Mobile view toggle behavior */
        @media (max-width: 768px) {
            #sidebar-wrapper { margin-left: -250px; }
            body.sb-sidenav-toggled #sidebar-wrapper { margin-left: 0; }
        }

        .list-group-item { border: none; padding: 1rem 1.5rem; font-weight: 500; color: #495057; border-left: 4px solid transparent; }
        .list-group-item:hover { background-color: #f8f9fa; color: #0d6efd; }
        .list-group-item.active { background-color: #e9ecef; color: #0d6efd; border-color: #0d6efd; border-left: 4px solid #0d6efd; font-weight: 700; }

        .navbar { background-color: #ffffff; border-bottom: 1px solid #eef0f3; padding: 1rem; }
        
        .card { box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: none; border-radius: 12px; margin-bottom: 1.5rem; }
        .card-header { background-color: #ffffff; border-bottom: 1px solid #eef0f3; font-weight: 600; border-top-left-radius: 12px !important; border-top-right-radius: 12px !important; }
        .form-control, .form-select { border-radius: 8px; border-color: #ced4da; }
        .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
        .btn-primary, .btn-success { border-radius: 8px; padding: 10px 24px; font-weight: 600; }
        
        main { flex: 1; padding: 2rem; }
    </style>
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
            <a href="?url=envio" class="list-group-item list-group-item-action <?= $current_url == 'envio' ? 'active' : '' ?>">
                <i class="bi bi-box-seam me-2"></i> Envíos
            </a>
            <a href="?url=logistica" class="list-group-item list-group-item-action <?= $current_url == 'logistica' ? 'active' : '' ?>">
                <i class="bi bi-map-fill me-2"></i> Logística
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
