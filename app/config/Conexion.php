<?php

namespace App\Config;

use PDO;
use PDOException;

abstract class Conexion
{
    public $host = "localhost";
    public $namedb = "grupo_ruedacaminos";
    public $userdb = "root";
    public $passwd = "";
    protected $conexion;

    public function __construct()
    {
        //$this->getConnection();
        $this->conexion = $this->getConnection();
    }

    public function getConnection(): PDO
    {
        try {

            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->namedb . ";charset=utf8";
            $conexion = new PDO($dsn, $this->userdb, $this->passwd);

            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            die('No se pudo conectar a la base de datos, error:' . $error->getMessage());
        }
        return $conexion;
    }


    public function formatearPalabra($palabra)
    {
        // 1. Primero pasamos toda la palabra a minúsculas
        $enMinusculas = strtolower($palabra);

        // 2. Luego convertimos la primera letra a mayúscula
        $resultado = ucfirst($enMinusculas);

        return $resultado;
    }

    // public function buscarId(){

    // echo "<script>const inputBusqueda = document.getElementById('inputBusqueda');
    // if (inputBusqueda) {
    //     inputBusqueda.addEventListener('input', function() {
    //         const textoBuscado = this.value.toLowerCase();
    //         const filas = document.querySelectorAll(\"table tbody tr\");
    //         filas.forEach(fila => {
    //             const contenidoFila = fila.textContent.toLowerCase();
    //             fila.style.display = contenidoFila.includes(textoBuscado) ? \"\" : \"none\";
    //         });
    //     });
    // }</script>";

    // }
}
