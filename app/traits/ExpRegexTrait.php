<?php

namespace App\Traits;

trait ExpRegexTrait
{

    private $patrones = [
        // solo-letras: Solo letras (incluye tildes y ñ) y espacios
        'solo-letras' => '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',

        // formato-placa: Solo letras y números
        'formato-placa' => '/^[a-zA-Z\d]+$/',

        // solo-numeros: Solo números
        'solo-numeros' => '/^\d+$/',

        // numeros-decimales: Números con opcionales separadores/decimales
        'numeros-decimales' => '/^[0-9]+([.,][0-9]+)*$/',

        // correo-electronico: Formato estándar de email sin espacios
        'correo-electronico' => '/^[^\s@]+@[^\s@]+\.[^\s@]+$/',

        // letra-num-ceb: Letras, números o caracteres especiales ASCII
        'letra-num-ceb' => '/^[a-zA-Z0-9\s!-\/:-?\[-`{-~]+$/'
    ];

    public function ExplorarDatos(array $datosAValidar)
    {
        
        foreach ($datosAValidar as $patron => $dato) { 
            
            if (!$this->ValidarDatos($this->patrones[$patron], $dato)) {
                return json_encode(['status' => 'error', 'message' => "El campo con el valor '$dato' no cumple con el formato requerido"]);
            } 
        }
        return true;
    }

    private function ValidarDatos(string $patron, string $dato): bool
    {
        return preg_match($patron, $dato) === 1;
    }

    
}