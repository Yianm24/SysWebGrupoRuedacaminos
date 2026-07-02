<?php
namespace App\Model;
use App\Config\Conexion;

class UnidadMedida extends Conexion{
    
    private $cod_unidadmedida;
    private $nombre;
    private $abreviatura;
    private $estado;

    function __construct($nombre = null, $abreviatura = null, $estado = null){
        parent::__construct();
        if ($nombre !== null) {
            $this->nombre = $nombre;
        }
        $this->abreviatura = $abreviatura;
        $this->estado = $estado;
    }

    public function obt_RegistrosUnidadMedida(){
        
        try {
            $sentencia = "SELECT * FROM unidad_medida";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            return $consulta->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de unidad de medida: " . $e->getMessage();
            return [];
        }
    }

}


?>