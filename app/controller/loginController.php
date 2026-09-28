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
                //var_dump($resultado);
                if (!$resultado) {
                    header("Location: ?url=login&status=incorrect&msg=Cédula incorrecta");
                    exit();
                    //echo "<script>alert('Cedula incorrecta');</script>";
                    //break;
                }
                /*echo $resultado['password']; */
                //Funcion para verificar la contraseña ingresada con la almacenada en la base de datos
                if (password_verify($_POST['password'], $resultado['password'])) {
                    $_SESSION['usuario'] = [
                        'codigo' => $resultado['cod_usuario'],
                        'cedula' => $resultado['cedula'],
                        'nombre' => $resultado['nombre'],
                        'rol' => $resultado['cod_rol'],
                    ];
                    header("Location: ?url=dashboard");
                    exit();
                } else {
                    header("Location: ?url=login&status=incorrect&msg=Contraseña incorrecta");
                    exit();
                }
            } else {
                header("Location: ?url=login&status=incorrect&msg=Por favor, complete los campos obligatorios para continuar");
                exit();
            }
        }
        break;
    case 'cerrar':
        session_unset();
        session_destroy();
        header("Location: ?url=login");
        break;
}
include 'app/view/layout/header.php';
include 'app/view/login/loginView.php';
include 'app/view/layout/footer.php';
