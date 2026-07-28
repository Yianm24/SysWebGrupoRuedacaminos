<?php
namespace App\Model;
use App\Config\Conexion;

class Marca extends Conexion{
    
    private $cod_marca;
    private $nombre;
    private $estado;

    function __construct(){
        parent::__construct();
    }

    public function verificarMarcaExiste($nombre) {
        $sentencia = "SELECT COUNT(*) FROM marca WHERE nombre = ? AND estado = 1";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

    public function verificarMarcaDuplicada($nombre,$cod_marca) {
        $sentencia = "SELECT COUNT(*) FROM marca WHERE nombre = ? AND cod_marca != ? AND estado = 1;";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2,$cod_marca);
        $count->execute();
        return $count->fetchColumn() > 0;
    }

     public function regDatosMarca($nombre)
    {
        $this->nombre = $nombre;
        $this->estado = 1;

        return $this->registrarMarca();
    }

    private function registrarMarca()
    {
        try {
            $sentencia = "INSERT INTO marca (nombre,estado) VALUES (?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado);
            $resultado = $insert->execute();

            return $resultado;

        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar la Marca: " . $e->getMessage() . "');</script>";
        }
    }

    public function obt_RegistrosMarca(){
        
        try {
            $sentencia = "SELECT * FROM marca WHERE estado = 1";
            $consulta = $this->conexion->prepare($sentencia);
            $consulta->execute();
            return $consulta->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de unidad de medida: " . $e->getMessage();
            return [];
        }
    }

    public function actMarca($cod_marca,$nombre)
    {
        $this->cod_marca = $cod_marca;
        $this->nombre = $nombre;

        return $this->actualizarMarca();
    }
   
    private function actualizarMarca()
    {
        try {
            $sentencia = "UPDATE `marca` SET nombre = ? WHERE cod_marca = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_marca);

            $update->execute();

        } catch (\PDOException $e) {
            return "Error al actualizar el registro de la marca: " . $e->getMessage();
        }
    }

    public function elmDatosMarca(int $cod_marca)
    {
        $this->cod_marca = $cod_marca;

        return $this->eliminarMarca();
    }

    private function eliminarMarca()
    {
        try {
            $sentencia = "UPDATE `marca` SET estado = 0 WHERE cod_marca = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_marca);
            $delete->execute();

            return "Marca de vehiculo eliminada exitosamente";
        } catch (\PDOException $e) {
            return "Error al eliminar la Marca: " . $e->getMessage();
        }
    }

}


?>