<?php
namespace App\Model;
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

    public function regDatosDespacho($cod_vehiculo, $fecha_salida){
        $this->cod_vehiculo = $cod_vehiculo;
        $this->fecha_salida = $fecha_salida;
        $this->estado = 1;

        return $this->regDespacho();
    }

    private function regDespacho(){
        try {
        $sentencia = "INSERT INTO `despacho`(`cod_vehiculo`, `fecha_salida`, `estado`) VALUES ('[value-1]','[value-2]','[value-3]')";
        $insert = $this->conexion->prepare($sentencia);
        $insert->bindValue(1,$this->cod_vehiculo);
        $insert->bindValue(2,$this->fecha_salida);
        $insert->bindValue(3,$this->estado);
        $resultado = $insert->execute();

        return $resultado;
        } catch (\PDOException $e) {
            urlencode($e);
            return header("Location: ?url=despacho&status=bdError&msg='$e'");

        }
        
    }

}
?>