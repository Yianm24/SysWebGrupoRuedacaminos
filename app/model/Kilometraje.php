<?php
namespace App\Model;
use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;
use App\Traits\ExpRegexTrait;

class Kilometraje extends Conexion
{
    use ValidadorTraitAjax, ExpRegexTrait;

    private $cod_preciokilometraje;
    private $kilometraje;
    private $monto_tarifa;
    private $estado;

    public function __construct() {
        parent::__construct();
    }
    
    public function obt_RegistrosKilometraje() {
        try{
            $sentencia = "SELECT * FROM precio_kilometraje WHERE estado = 1";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
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
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            if (strlen($resultadoTrait[0]) < 1 || strlen($resultadoTrait[0]) > 8) {
                return json_encode(['status' => 'error', 'message' => 'El kilometraje supera el límite permitido.']);
            }
            if (strlen($resultadoTrait[1]) < 1 || strlen($resultadoTrait[1]) > 8) {
                return json_encode(['status' => 'error', 'message' => 'El kilometraje supera el límite permitido.']);
            }

            $valKm = $this->ExplorarDatos(['numeros-decimales' => $resultadoTrait[0]]);
            if ($valKm !== true) return $valKm;

            $valPrecio = $this->ExplorarDatos(['numeros-decimales' => $resultadoTrait[1]]);
            if ($valPrecio !== true) return $valPrecio;

            $this->kilometraje = $resultadoTrait[0];
            $this->monto_tarifa = $resultadoTrait[1];
            $this->estado = 1;
        } else {
            return $resultadoTrait;
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
            return "exception";
        }
    }

    public function actDatosKilometraje(array $campos) {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            if (strlen($resultadoTrait[1]) < 1 || strlen($resultadoTrait[1]) > 8) {
                return json_encode(['status' => 'error', 'message' => 'El kilometraje supera el límite permitido.']);
            }
            if (strlen($resultadoTrait[2]) < 1 || strlen($resultadoTrait[2]) > 8) {
                return json_encode(['status' => 'error', 'message' => 'El kilometraje supera el límite permitido.']);
            }

            $valKm = $this->ExplorarDatos(['numeros-decimales' => $resultadoTrait[1]]);
            if ($valKm !== true) return $valKm;

            $valPrecio = $this->ExplorarDatos(['numeros-decimales' => $resultadoTrait[2]]);
            if ($valPrecio !== true) return $valPrecio;

            $this->cod_preciokilometraje = $resultadoTrait[0];
            $this->kilometraje = $resultadoTrait[1];
            $this->monto_tarifa = $resultadoTrait[2];
        } else {
            return $resultadoTrait;
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
            return "exception";
        }
    }

    public function elmDatosKilometraje(array $campos) {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $this->cod_preciokilometraje = $resultadoTrait[0];
        } else {
            return $resultadoTrait;
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
            return "exception";
        }
    }
}