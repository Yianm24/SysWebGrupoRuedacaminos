<?php

namespace App\Controller;

use App\Model\Usuario;

$usuario = new Usuario();
$solicitud = $_POST['tipoSolicitud'] ?? '';

switch ($solicitud) {
    case 'acceder':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['cedula']) && !empty($_POST['password'])) {
                $resultado = $usuario->accesoDatosUsuario($_POST['cedula'], $_POST['password']);
                if ($resultado && password_verify($_POST['password'], $resultado[0]['password'])) {
                    header("Location: ?url=dashboard");
                    exit();
                } else {
                    echo "<script>alert('Error al acceder al usuario: " . $resultado . "');</script>";
                }
            } else {
                echo "<script>alert('Por favor, complete los campos obligatorios para continuar');</script>";
            }
        }
        break;
}
include 'app/view/layout/header.php';
include 'app/view/login/loginView.php';
include 'app/view/layout/footer.php';
