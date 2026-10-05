<?php
namespace App\Controller;
use App\Config\Conexion;

class Despacho extends Conexion
{
    private $cod_despacho;
    private $cod_envio;
    private $cod_empleado;
    private $cod_vehiculo;
    private $fecha_salida;
    private $fecha_entrega;
    private $estatus;
    private $estado;

    public function __construct()
    {
        parent::__construct();
    }

}
?>