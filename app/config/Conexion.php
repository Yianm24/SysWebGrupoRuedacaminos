<?php
namespace App\Config;
use PDO;
use PDOException;

abstract class Conexion
{
    public $host = "localhost";
    public $namedb = "grupo_ruedacaminosbd";
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
}
