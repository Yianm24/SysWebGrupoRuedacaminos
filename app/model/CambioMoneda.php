<?php
namespace App\Model;
use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;
use App\Traits\ExpRegexTrait;

class CambioMoneda extends Conexion
{
    use ValidadorTraitAjax, ExpRegexTrait;

    private $cod_cambio;
    private $tasa;
    private $fecha;
    private $cod_moneda;
    private $estado;

    public function __construct() {
        parent::__construct();
    }

    public function obt_TodasLasMonedas() {
        try {
            $sentencia = "SELECT cod_moneda, nombre, abreviatura FROM moneda WHERE estado = 1 AND abreviatura != 'VES'";
            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function obtenerFechaPorId($cod_cambio) {
        try {
            $sentencia = "SELECT DATE(fecha) AS fecha_dia FROM cambio_moneda WHERE cod_cambio = ? LIMIT 1";
            $stmt = $this->conexion->prepare($sentencia);
            $stmt->execute([$cod_cambio]);
            $fila = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $fila ? $fila['fecha_dia'] : null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function verificarTasaDuplicada($cod_moneda, $fecha, $id_actual = null) {
        if ($id_actual === null || $id_actual === '') {
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

    public function verificarUsoEnPagos($cod_cambio) {
        try {
            $stmt = $this->conexion->prepare("SELECT cod_moneda, fecha FROM cambio_moneda WHERE cod_cambio = ?");
            $stmt->execute([$cod_cambio]);
            $cambio = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($cambio) {
                $sql = "SELECT COUNT(*) FROM pago p INNER JOIN detalle_pago dp ON p.cod_detallepago = dp.cod_detallepago INNER JOIN metodo_pago mp ON dp.cod_metodopago = mp.cod_metodo WHERE mp.cod_moneda = ? AND p.fecha = DATE(?) AND p.estado = 1";
                $check = $this->conexion->prepare($sql);
                $check->execute([$cambio['cod_moneda'], $cambio['fecha']]);
                return $check->fetchColumn() > 0;
            }
            return false;
        } catch (\PDOException $e) {
            return true;
        }
    }

    public function obt_RegistrosCambiosServerSide() {
        try {
            $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
            $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
            $length = isset($_POST['length']) ? intval($_POST['length']) : 5;
            $searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

            $columnas = [
                0 => 'c.fecha',
                1 => 'c.fecha',
                2 => 'm.abreviatura',
                3 => 'c.tasa'
            ];

            $orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
            $orderColumn = $columnas[$orderColumnIndex] ?? 'c.fecha';
            $orderDir = (isset($_POST['order'][0]['dir']) && strtoupper($_POST['order'][0]['dir']) === 'ASC') ? 'ASC' : 'DESC';

            $sqlBase = " FROM cambio_moneda AS c
                        INNER JOIN moneda AS m ON c.cod_moneda = m.cod_moneda
                        WHERE c.estado = 1";

            $stmtTotal = $this->conexion->query("SELECT COUNT(*) AS total " . $sqlBase);
            $recordsTotal = (int) $stmtTotal->fetch(\PDO::FETCH_ASSOC)['total'];

            $sqlSearch = "";
            $params = [];

            if ($searchValue !== '') {
                $sqlSearch = " AND (m.abreviatura LIKE :search OR m.nombre LIKE :search OR CAST(c.tasa AS CHAR) LIKE :search OR DATE_FORMAT(c.fecha, '%d/%m/%Y') LIKE :search) ";
                $params[':search'] = "%{$searchValue}%";
            }

            $stmtFiltered = $this->conexion->prepare("SELECT COUNT(*) AS total " . $sqlBase . $sqlSearch);
            foreach ($params as $key => $val) {
                $stmtFiltered->bindValue($key, $val, \PDO::PARAM_STR);
            }
            $stmtFiltered->execute();
            $recordsFiltered = (int) $stmtFiltered->fetch(\PDO::FETCH_ASSOC)['total'];

            $sqlData = "SELECT c.cod_cambio, c.cod_moneda, c.tasa, c.fecha, m.abreviatura,
                            (
                                SELECT c2.tasa FROM cambio_moneda AS c2
                                WHERE c2.cod_moneda = c.cod_moneda AND c2.estado = 1
                                AND c2.fecha < c.fecha ORDER BY c2.fecha DESC LIMIT 1
                            ) AS tasa_anterior
                        " . $sqlBase
                        . $sqlSearch
                        . " ORDER BY {$orderColumn} {$orderDir} ";

            if ($length != -1) {
                $sqlData .= " LIMIT :start, :length";
            }

            $stmtData = $this->conexion->prepare($sqlData);
            foreach ($params as $key => $val) {
                $stmtData->bindValue($key, $val, \PDO::PARAM_STR);
            }

            if ($length != -1) {
                $stmtData->bindValue(':start', $start, \PDO::PARAM_INT);
                $stmtData->bindValue(':length', $length, \PDO::PARAM_INT);
            }

            $stmtData->execute();
            $data = $stmtData->fetchAll(\PDO::FETCH_ASSOC);

            return json_encode([
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            ]);
        } catch (\PDOException $e) {
            return json_encode([
                "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "error" => $e->getMessage()
            ]);
        }
    }

    public function regDatosCambio(array $campos) {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            if (strlen($resultadoTrait[0]) < 1 || strlen($resultadoTrait[0]) > 10) {
                return json_encode(['status' => 'error', 'message' => 'La tasa supera el límite numérico permitido.']);
            }
            $valTasa = $this->ExplorarDatos(['numeros-decimales' => $resultadoTrait[0]]);
            if ($valTasa !== true) return $valTasa;

            $valMoneda = $this->ExplorarDatos(['solo-numeros' => $resultadoTrait[1]]);
            if ($valMoneda !== true) return $valMoneda;

            date_default_timezone_set('America/Caracas');
            $this->tasa = $resultadoTrait[0];
            $this->cod_moneda = $resultadoTrait[1];
            $this->fecha = date('Y-m-d H:i:s');
            $this->estado = 1;
        } else {
            return $resultadoTrait;
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
            return "exception";
        }
    }

    public function actDatosCambio(array $campos) {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            if (strlen($resultadoTrait[1]) < 1 || strlen($resultadoTrait[1]) > 10) {
                return json_encode(['status' => 'error', 'message' => 'La tasa supera el límite numérico permitido.']);
            }
            $valTasa = $this->ExplorarDatos(['numeros-decimales' => $resultadoTrait[1]]);
            if ($valTasa !== true) return $valTasa;

            $valMoneda = $this->ExplorarDatos(['solo-numeros' => $resultadoTrait[2]]);
            if ($valMoneda !== true) return $valMoneda;

            $this->cod_cambio = $resultadoTrait[0];
            $this->tasa = $resultadoTrait[1];
            $this->cod_moneda = $resultadoTrait[2];
        } else {
            return $resultadoTrait;
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
            return "exception";
        }
    }

    public function elmDatosCambio(array $campos) {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {
            $this->cod_cambio = $resultadoTrait[0];

            if ($this->verificarUsoEnPagos($this->cod_cambio)) {
                return json_encode(['status' => 'error', 'message' => 'No se puede eliminar esta tasa porque ya fue usada en uno o más registros de pagos.']);
            }
        } else {
            return $resultadoTrait;
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
            return "exception";
        }
    }
}
?>