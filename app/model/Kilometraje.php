<?php
namespace App\Model;
use App\Config\Conexion;
use App\Traits\KilometrajeTrait;

class Kilometraje extends Conexion
{
    use KilometrajeTrait;

    private $cod_preciokilometraje;
    private $kilometraje;
    private $monto_tarifa;
    private $estado;

    public function __construct() {
        parent::__construct();
    }
    
    public function obt_RegistrosKilometraje() {
        $sentencia = "SELECT * FROM precio_kilometraje WHERE estado = 1";
        $select = $this->conexion->prepare($sentencia);
        $select->execute();
        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function verificarTarifaDuplicada($kilometraje, $id_actual = null) {
        if ($id_actual === null) {
            $sentencia = "SELECT COUNT(*) FROM precio_kilometraje WHERE kilometraje = ? AND estado = 1";
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->bindValue(1, $kilometraje);
        } else {
            $sentencia = "SELECT COUNT(*) FROM precio_kilometraje WHERE kilometraje = ? AND cod_preciokilometraje != ? AND estado = 1";
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->bindValue(1, $kilometraje);
            $stmt->bindValue(2, $id_actual);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function regDatosKilometraje(array $campos) {
        if (is_array($this->validarPost($campos))) {
            $datos = $this->validarPost($campos);
            $this->kilometraje = $datos['kilometraje'];
            $this->monto_tarifa =$datos['precio_kilometraje'];
            $this->estado = 1;
        } else {
            return 'error&msg=Registrar';
        }
        return $this->registrarKilometraje();
    }

    private function registrarKilometraje() {
        try {
            $sentencia = "INSERT INTO precio_kilometraje (kilometraje, monto_tarifa, estado) VALUES (?, ?, ?)";
            $insert = $this->conexion->prepare($sentencia);
            $insert->bindValue(1, $this->kilometraje);
            $insert->bindValue(2, $this->monto_tarifa);
            $insert->bindValue(3, $this->estado);
            $insert->execute();
            return 'success';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function actDatosKilometraje(array $campos) {
        if (is_array($this->validarPost($campos))) {
            $datos = $this->validarPost($campos);
            $this->cod_preciokilometraje = $datos['id_tarifa_editar'];
            $this->kilometraje = $datos['kilometraje_editar'];
            $this->monto_tarifa = $datos['precio_kilometraje_editar'];
        } else {
            return 'error&msg=Actualizar';
        }
        return $this->actualizarKilometraje();
    }

    private function actualizarKilometraje() {
        try {
            $sentencia = "UPDATE precio_kilometraje SET kilometraje = ?, monto_tarifa = ? WHERE cod_preciokilometraje = ?";
            $update = $this->conexion->prepare($sentencia);
            $update->bindValue(1, $this->kilometraje);
            $update->bindValue(2, $this->monto_tarifa);
            $update->bindValue(3, $this->cod_preciokilometraje);
            $update->execute();
            return 'updated';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function elmDatosKilometraje(array $campos) {
        if (is_array($this->validarPost($campos))) {
            $datos = $this->validarPost($campos);
            $this->cod_preciokilometraje = $datos['id_tarifa'];
        } else {
            return 'error&msg=Eliminar';
        }   
        return $this->eliminarKilometraje();
    }

    private function eliminarKilometraje() {
        try {
            $sentencia = "UPDATE precio_kilometraje SET estado = 0 WHERE cod_preciokilometraje = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->bindValue(1, $this->cod_preciokilometraje);
            $delete->execute();
            return 'deleted';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }
}