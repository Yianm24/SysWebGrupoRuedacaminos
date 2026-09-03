<?php
namespace App\Model;
use App\Config\Conexion;

class Estado extends Conexion{
    
    private $cod_estado;
    private $nombre;
    private $estado;

    function __construct(){
        parent::__construct();
    }

    public function verificarEstadoDuplicada($nombre,$cod_estado=null) {
        if ($cod_estado === null) {
            $sentencia = "SELECT COUNT(*) FROM Estado WHERE nombre = ? AND estado = 1;";
        }else{
            $sentencia = "SELECT COUNT(*) FROM Estado WHERE nombre = ? AND cod_estado != ? AND estado = 1;";
        }
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2,$cod_estado);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

     public function regDatosEstado($nombre)
    {
        $this->nombre = $nombre;
        $this->estado = 1;

        return $this->registrarEstado();
    }

    private function registrarEstado()
    {
        try {
            $sentencia = "INSERT INTO Estado (nombre,estado) VALUES (?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado);
            $resultado = $insert->execute();

            return $resultado;

        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar la Estado: " . $e->getMessage() . "');</script>";
        }
    }

    public function obt_RegistrosEstado(){
        
        try {
            $sentencia = "SELECT * FROM Estado WHERE estado = 1";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            return $consulta->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de unidad de medida: " . $e->getMessage();
            return [];
        }
    }

    public function actEstado($cod_estado,$nombre)
    {
        $this->cod_estado = $cod_estado;
        $this->nombre = $nombre;

        return $this->actualizarEstado();
    }
   
    private function actualizarEstado()
    {
        try {
            $sentencia = "UPDATE `Estado` SET nombre = ? WHERE cod_estado = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_estado);

            $update->execute();

        } catch (\PDOException $e) {
            return "Error al actualizar el registro de la Estado: " . $e->getMessage();
        }
    }

    public function elmDatosEstado(int $cod_estado)
    {
        $this->cod_estado = $cod_estado;

        return $this->eliminarEstado();
    }

    private function eliminarEstado()
    {
        try {
            $sentencia = "UPDATE `Estado` SET estado = 0 WHERE cod_estado = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_estado);
            $delete->execute();

            return "Estado de vehiculo eliminada exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar la Estado: " . $e->getMessage();
        }
    }

}


?>