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
            $sentencia = "SELECT * FROM unidad_medida WHERE estado = 1";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            return $consulta->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de unidad de medida: " . $e->getMessage();
            return [];
        }
    }

    public function actUnidadMedida($cod_unidadmedida, $nombre, $abreviatura, $tipo)
    {
        $this->cod_unidadmedida = $cod_unidadmedida;
        $this->nombre = $nombre;
        $this->abreviatura = $abreviatura;
        $this->tipo = $tipo;

        return $this->actualizarUnidadMedida();
    }
   
    private function actualizarUnidadMedida()
    {
        try {
            $sentencia = "UPDATE `unidad_medida` SET nombre = ?, abreviatura = ?, tipo = ? WHERE cod_unidad = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->abreviatura);
            $update->bindValue(3, $this->tipo);
            $update->bindValue(4, $this->cod_unidadmedida);

            $update->execute();

        } catch (\PDOException $e) {
            return "Error al actualizar la unidad de medida: " . $e->getMessage();
        }
    }

    public function elmDatosUnidadMedida(int $cod_unidadmedida)
    {
        $this->cod_unidadmedida = $cod_unidadmedida;

        return $this->eliminarUnidadMedida();
    }

    private function eliminarUnidadMedida()
    {
        try {
            $sentencia = "UPDATE `unidad_medida` SET estado = 0 WHERE cod_unidad = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_unidadmedida);
            $delete->execute();

            return "Unidad de medida eliminada exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar la unidad de medida: " . $e->getMessage();
        }
    }

}


?>