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
        try {
            $sentencia = "SELECT * FROM precio_kilometraje ORDER BY estado DESC, cod_preciokilometraje DESC";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function verificarTarifaDuplicada($kilometraje, $id_actual = null) {
        $kmNormalizado = number_format((float)$kilometraje, 2, '.', '');
        if ($id_actual === null || $id_actual === '') {
            $sentencia = "SELECT COUNT(*) FROM precio_kilometraje WHERE CAST(kilometraje AS DECIMAL(10,2)) = CAST(? AS DECIMAL(10,2))";
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->bindValue(1, $kmNormalizado);
        } else {
            $sentencia = "SELECT COUNT(*) FROM precio_kilometraje WHERE CAST(kilometraje AS DECIMAL(10,2)) = CAST(? AS DECIMAL(10,2)) AND cod_preciokilometraje != ?";
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->bindValue(1, $kmNormalizado);
            $stmt->bindValue(2, $id_actual);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function regDatosKilometraje(array $campos) {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $kmLimpio = $resultadoTrait[0];
            $precioLimpio = $resultadoTrait[1];

            if ($this->verificarTarifaDuplicada($kmLimpio)) {
                return json_encode(['status' => 'exists', 'message' => 'Ya existe una tarifa registrada para este kilometraje.']);
            }

            if (strlen($kmLimpio) < 1 || strlen($kmLimpio) > 10 || strlen($precioLimpio) < 1 || strlen($precioLimpio) > 10) {
                return json_encode(['status' => 'error', 'message' => 'El kilometraje o el monto supera el límite permitido.']);
            }

            $valKm = $this->ExplorarDatos(['numeros-decimales' => $kmLimpio]);
            if ($valKm !== true) return $valKm;

            $valPrecio = $this->ExplorarDatos(['numeros-decimales' => $precioLimpio]);
            if ($valPrecio !== true) return $valPrecio;

            $kmFloat = (float)$kmLimpio;
            $precioFloat = (float)$precioLimpio;

            if ($kmFloat < 1 || $kmFloat > 99999.99) {
                return json_encode(['status' => 'error', 'message' => 'El kilometraje debe estar entre 1,00 y 99.999,99']);
            }

            if ($precioFloat <= 0 || $precioFloat > 99999.99) {
                return json_encode(['status' => 'error', 'message' => 'El monto de la tarifa debe ser mayor a 0,00 y no superar 99.999,99']);
            }

            $this->kilometraje = $kmLimpio;
            $this->monto_tarifa = $precioLimpio;
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
            return json_encode(['status' => 'success', 'message' => 'La tarifa ha sido registrada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function actDatosKilometraje(array $campos) {
        $codTarifaEntrada = $campos[0] ?? '';
        $kmEntrada = $campos[1] ?? '';
        $precioEntrada = $campos[2] ?? '';
        $estadoEntrada = $campos[3] ?? '1';

        $resultadoTrait = $this->validarPost([$codTarifaEntrada, $kmEntrada, $precioEntrada]);
        if (is_array($resultadoTrait)) {
            $codTarifa = $resultadoTrait[0];
            $kmLimpio = $resultadoTrait[1];
            $precioLimpio = $resultadoTrait[2];
            $estadoRecibido = is_numeric($estadoEntrada) ? (int)$estadoEntrada : 1;

            if (!in_array($estadoRecibido, [0, 1], true)) {
                return json_encode(['status' => 'error', 'message' => 'El estatus seleccionado no es válido.']);
            }

            if ($estadoRecibido === 0 && $this->contarTarifasActivasExcluyendo($codTarifa) < 1) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'No se puede inactivar este kilometraje, debe existir al menos una tarifa activa para calcular el costo del envío.'
                ]);
            }

            if ($this->verificarTarifaDuplicada($kmLimpio, $codTarifa)) {
                return json_encode(['status' => 'exists', 'message' => 'Ya existe una tarifa registrada para este kilometraje.']);
            }

            if (strlen($kmLimpio) < 1 || strlen($kmLimpio) > 10 || strlen($precioLimpio) < 1 || strlen($precioLimpio) > 10) {
                return json_encode(['status' => 'error', 'message' => 'El kilometraje o el monto supera el límite permitido.']);
            }

            $valKm = $this->ExplorarDatos(['numeros-decimales' => $kmLimpio]);
            if ($valKm !== true) return $valKm;

            $valPrecio = $this->ExplorarDatos(['numeros-decimales' => $precioLimpio]);
            if ($valPrecio !== true) return $valPrecio;

            $kmFloat = (float)$kmLimpio;
            $precioFloat = (float)$precioLimpio;

            if ($kmFloat < 1 || $kmFloat > 99999.99) {
                return json_encode(['status' => 'error', 'message' => 'El kilometraje debe estar entre 1,00 y 99.999,99']);
            }

            if ($precioFloat <= 0 || $precioFloat > 99999.99) {
                return json_encode(['status' => 'error', 'message' => 'El monto de la tarifa debe ser mayor a 0,00 y no superar 99.999,99']);
            }

            $this->cod_preciokilometraje = $codTarifa;
            $this->kilometraje = $kmLimpio;
            $this->monto_tarifa = $precioLimpio;
            $this->estado = $estadoRecibido;
        } else {
            return $resultadoTrait;
        }
        return $this->actualizarKilometraje();
    }

    private function actualizarKilometraje() {
        try {
            $sentencia = "UPDATE precio_kilometraje SET kilometraje = ?, monto_tarifa = ?, estado = ? WHERE cod_preciokilometraje = ?";
            $update = $this->conexion->prepare($sentencia);
            $update->bindValue(1, $this->kilometraje);
            $update->bindValue(2, $this->monto_tarifa);
            $update->bindValue(3, $this->estado);
            $update->bindValue(4, $this->cod_preciokilometraje);
            $update->execute();
            return json_encode(['status' => 'updated', 'message' => 'La tarifa ha sido modificada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    private function contarTarifasActivasExcluyendo($id_tarifa) {
        $sql = "SELECT COUNT(*) FROM precio_kilometraje WHERE estado = 1 AND cod_preciokilometraje != ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(1, $id_tarifa);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
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
            if ($this->contarTarifasActivasExcluyendo($this->cod_preciokilometraje) < 1) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'No se pudo eliminar este kilometraje, debe existir al menos una tarifa registrada para calcular el costo del envío.'
                ]);
            }

            $sentencia = "UPDATE precio_kilometraje SET estado = 0 WHERE cod_preciokilometraje = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->bindValue(1, $this->cod_preciokilometraje);
            $delete->execute();
            return json_encode(['status' => 'deleted', 'message' => 'La tarifa ha sido eliminada correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}