<?php
namespace App\Model;
use App\Config\Conexion;
use App\Traits\CambioMonedaTrait;

class CambioMoneda extends Conexion
{
    use CambioMonedaTrait;

    private $cod_cambio;
    private $tasa;
    private $fecha;
    private $cod_moneda;
    private $estado;

    public function __construct() {
        parent::__construct();
    }

    public function obt_TodasLasMonedas() {
        $sentencia = "SELECT cod_moneda, nombre, abreviatura FROM moneda WHERE estado = 1 AND abreviatura != 'VES'";
        $select = $this->conexion->prepare($sentencia);
        $select->execute();
        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function verificarTasaDuplicada($cod_moneda, $fecha, $id_actual = null) {
        if ($id_actual === null) {
            $sentencia = "SELECT COUNT(*) FROM cambio_moneda WHERE cod_moneda = ? AND DATE(fecha) = ? AND estado = 1";
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->bindValue(1, $cod_moneda);
            $stmt->bindValue(2, $fecha);
        } else {
            $sentencia = "SELECT COUNT(*) FROM cambio_moneda WHERE cod_moneda = ? AND DATE(fecha) = ? AND cod_cambio != ? AND estado = 1";
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->bindValue(1, $cod_moneda);
            $stmt->bindValue(2, $fecha);
            $stmt->bindValue(3, $id_actual);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function regDatosCambio(array $campos) {
        if (is_array($this->validarPost($campos))) {
            $datos = $this->validarPost($campos);
            date_default_timezone_set('America/Caracas');
        
            $this->tasa = $datos['tasa'];
            $this->cod_moneda = $datos['moneda'];
            $this->fecha = date('Y-m-d H:i:s');
            $this->estado = 1;
        } else {
            return 'error&msg=Registrar';
        }
        return $this->registrarCambio();
    }

    private function registrarCambio() {
        try {
            $sentencia = "INSERT INTO cambio_moneda (tasa, fecha, cod_moneda, estado) VALUES (?, ?, ?, ?)";
            $insert = $this->conexion->prepare($sentencia);
            $insert->bindValue(1, $this->tasa);
            $insert->bindValue(2, $this->fecha);
            $insert->bindValue(3, $this->cod_moneda);
            $insert->bindValue(4, $this->estado);
            $insert->execute();
            return 'success';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function obt_RegistrosCambios() {
        $sentencia ="SELECT c.cod_cambio, c.tasa, c.fecha, c.cod_moneda, m.abreviatura 
                    FROM cambio_moneda c 
                    INNER JOIN moneda m ON c.cod_moneda = m.cod_moneda 
                    WHERE c.estado = 1 
                    GROUP BY c.cod_cambio 
                    ORDER BY c.fecha DESC";
        $select = $this->conexion->prepare($sentencia);
        $select->execute();
        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function actDatosCambio(array $campos) {
        if (is_array($this->validarPost($campos))) {
            $datos = $this->validarPost($campos);
            $this->cod_cambio = $datos['id_cambio_editar'];
            $this->tasa = $datos['tasa_editar'];
            $this->cod_moneda = $datos['moneda_editar'];
        } else {
            return 'error&msg=Actualizar';
        }
        return $this->actualizarCambio();
    }

    private function actualizarCambio() {
        try {
            $sentencia = "UPDATE cambio_moneda SET tasa = ?, cod_moneda = ? WHERE cod_cambio = ?";
            $update = $this->conexion->prepare($sentencia);
            $update->bindValue(1, $this->tasa);
            $update->bindValue(2, $this->cod_moneda);
            $update->bindValue(3, $this->cod_cambio);
            $update->execute();
            return 'updated';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }

    public function elmDatosCambio(array $campos) {
        if (is_array($this->validarPost($campos))) {
            $datos = $this->validarPost($campos);
            $this->cod_cambio = $datos['id_cambio'];
        } else {
            return 'error&msg=Eliminar';
        }
        return $this->eliminarCambio();
    }

    private function eliminarCambio() {
        try {
            $sentencia = "UPDATE cambio_moneda SET estado = 0 WHERE cod_cambio = ?";
            $delete = $this->conexion->prepare($sentencia);
            $delete->bindValue(1, $this->cod_cambio);
            $delete->execute();
            return 'deleted';
        } catch (\PDOException $e) {
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }
} ?>