<?php

namespace App\Traits;

trait KilometrajeTrait
{
    public function validarPost(array $camposRequeridos)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }

        $array = [];
        
        foreach ($camposRequeridos as $campo) {
            if (!isset($_POST[$campo]) || empty(trim($_POST[$campo]))) {
                header("Location: ?url=kilometraje&status=empty");
                return false;
            }
            $array["{$campo}"] = $this->input($campo, null);
        }
        return $array;
    }

    public function input(string $campo, $default = null)
    {
        return isset($_POST[$campo]) ? htmlspecialchars(trim($_POST[$campo])) : $default;
    }
}