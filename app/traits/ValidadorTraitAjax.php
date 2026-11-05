<?php

namespace App\Traits;

trait ValidadorTraitAjax
{

    // 1. Verifica que la petición sea POST y que los campos requeridos no estén vacíos
    public function validarPost(array $camposRequeridos)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return json_encode(['status'=>'empty', 'message'=>'Metodo invalido.']);
        }

        $array = [];

        foreach ($camposRequeridos as $campo) {
            if (empty(trim($campo))) {
                return json_encode(['status'=>'empty', 'message'=>'Uno o más campos están vacíos.']);
            }
            $array[] = $this->input($campo, null);
        }
        return $array;
    }

    // 2. Obtiene el dato limpio del POST
    public function input(string $campo, $default = null)
    {
        return (!empty($campo)) ? htmlspecialchars(trim($campo)) : $default;
    }
}
