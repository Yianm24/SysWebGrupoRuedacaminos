<?php

namespace App\Traits;

trait ValidadorTrait
{

    // 1. Verifica que la petición sea POST y que los campos requeridos no estén vacíos
    public function validarPost(array $camposRequeridos, string $modulo='dashboard')
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }

        $array = [];
        
        echo $modulo;
        foreach ($camposRequeridos as $campo) {
            if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
                header("Location: ?url={$modulo}&status=empty");
            exit();
            }
            $array["{$campo}"] = $this->input($campo, null);
        }
        return $array;
    }

    // 2. Obtiene el dato limpio del POST
    public function input(string $campo, $default = null)
    {
        return isset($_POST[$campo]) ? htmlspecialchars(trim($_POST[$campo])) : $default;
    }
}
