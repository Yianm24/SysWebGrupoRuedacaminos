<?php
namespace App\Model;
use App\Config\Conexion;

class UnidadMedida extends Conexion{
    
    private $cod_unidadmedida;
    private $nombre;
    private $abreviatura;
    private $tipo;
    private $estado;

    function __construct($nombre = null, $abreviatura = null, $tipo = null, $estado = null){
        parent::__construct();
        if ($nombre !== null) {
            $this->nombre = $nombre;
        }
        $this->abreviatura = $abreviatura;
        $this->tipo = $tipo;
        $this->estado = $estado;
    }

     public function regDatosUnidadMedida($nombre, $abreviatura, $tipo)
    {
        $this->nombre = $nombre;
        $this->abreviatura = $abreviatura;
        $this->tipo = $tipo;
        $this->estado = 1;

        return $this->registrarUnidadMedida();
    }

    private function registrarUnidadMedida()
    {
        try {
            $sentencia = "INSERT INTO unidad_medida (nombre, abreviatura, tipo) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->abreviatura);
            $insert->bindValue(3, $this->tipo);

            $resultado = $insert->execute();

            return $resultado;

        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar la unidad de medida: " . $e->getMessage() . "');</script>";
        }
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