<?php

namespace App\Traits;

trait ValidadorTrait
{

    // 1. Verifica que la petición sea POST y que los campos requeridos no estén vacíos
    public function validarPost(array $camposRequeridos, string $mensajeError = 'empty')
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }

        $array = [];

        foreach ($camposRequeridos as $campo) {
            if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
                $this->mostrarAlerta($mensajeError);
                return false;
            }
            $array["{$campo}"] = $this->input($campo, null);
        }
        return $array;
    }


    // 3. Centraliza las alertas JS
    public function mostrarAlerta(string $mensaje): void
    {
        header("Location: ?url=estado&status={$mensaje}");
    }

    // 4. Obtiene el dato limpio del POST
    public function input(string $campo, $default = null)
    {
        return isset($_POST[$campo]) ? htmlspecialchars(trim($_POST[$campo])) : $default;
    }
}
