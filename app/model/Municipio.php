<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\ValidadorTraitAjax;

class Municipio extends Conexion
{

    use ValidadorTraitAjax;

    private $cod_municipio;
    private $nombre;
    private $cod_estado;
    private $estado;



    public function __construct()
    {
        parent::__construct();
    }

    private function verificarMunicipioDuplicado($nombre, $cod_estado)
    {
        $this->formatearPalabra($nombre);
        $sentencia = "SELECT COUNT(*) FROM municipio WHERE nombre = ? AND cod_estado = ?";
        $count = $this->conexion->prepare($sentencia);
        $count->bindValue(1, $nombre);
        $count->bindValue(2, $cod_estado);
        $count->execute();
        return $count->fetchColumn() > 0;
    }


    public function obt_RegistrosMunicipio()
    {
        $draw        = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
        $start       = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length      = isset($_POST['length']) ? intval($_POST['length']) : 5;
        $searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

        $columnas = [
            0 => 'mun.nombre',
            1 => 'est.nombre'
        ];

        $orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 1;
        $orderColumn      = $columnas[$orderColumnIndex] ?? 'est.nombre';
        $orderDir         = (isset($_POST['order'][0]['dir']) && strtoupper($_POST['order'][0]['dir']) === 'DESC') ? 'DESC' : 'ASC';

            $sqlBase = " FROM municipio AS mun
             INNER JOIN estado AS est ON mun.cod_estado = est.cod_estado
             WHERE mun.estado = 1";

        $stmtTotal = $this->conexion->query("SELECT COUNT(*) " . $sqlBase);
        $recordsTotal = (int) $stmtTotal->fetchColumn();


        $sqlSearch = "";
        $params = [];

        if ($searchValue !== '') {
            $sqlSearch = " AND (mun.nombre LIKE :search OR est.nombre LIKE :search) ";
            $params[':search'] = "%{$searchValue}%";
        }

        $stmtFiltered = $this->conexion->prepare("SELECT COUNT(*) " . $sqlBase . $sqlSearch);
        foreach ($params as $key => $val) {
            $stmtFiltered->bindValue($key, $val, \PDO::PARAM_STR);
        }
        $stmtFiltered->execute();
        $recordsFiltered = (int) $stmtFiltered->fetchColumn();

        $sqlData = "SELECT mun.cod_municipio, mun.nombre AS Municipio, mun.cod_estado, mun.estado, est.nombre AS Estado "
            . $sqlBase
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

        foreach ($data as &$datos) {
            $datos['botones'] = '<div class="text-end pe-4">
                            <button type="button" class="btn btn-link text-secondary p-0 m-0 align-baseline" title="Modificar" data-bs-toggle="modal" data-bs-target="#modalMunicipio"
                                 datos-cod-municipio="' . $datos['cod_municipio'] . '"
                                 datos-nombre="' . $datos['Municipio'] . '"
                                 datos-cod-estado="' . $datos['cod_estado'] . '"
                                 datos-estado="' . $datos['estado'] . '"
                                 >
                                 <i class="bi bi-pencil"></i>
                             </button>
                         <a href="#" class="text-secondary btn-eliminar"
                                 datos-cod-municipio="' . $datos['cod_municipio'] . '" >
                                 <i class="bi bi-trash"></i>
                         </a>
                     </div>';
        }
        unset($datos);
                return json_encode([
            "draw"            => $draw,
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data
        ]);
    }

    public function obt_MunicipiosSelect()
    {
        try {
            $sentencia = "SELECT municipio.cod_municipio ,municipio.nombre as nombre_municipio, estado.nombre AS nombre_estado, 
            estado.cod_estado
            FROM municipio
            INNER JOIN estado 
            ON municipio.cod_estado= estado.cod_estado
            WHERE municipio.estado=1";

            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            $registros = json_encode($select->fetchAll(\PDO::FETCH_ASSOC));
            return $registros;
        } catch (\PDOException $e) {
            echo "Error al obtener los registros de unidad de medida: " . $e->getMessage();
            return [];
        }
    }

    public function regDatosMunicipio(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);

        if ($this->verificarMunicipioDuplicado($this->formatearPalabra($resultadoTrait[0]), $resultadoTrait[1])) {
            return json_encode(['status' => 'exists', 'message' => 'El Municipio se encuentra registrado']);
        }

        if (is_array($resultadoTrait)) {

            $this->nombre = $this->formatearPalabra($resultadoTrait[0]);
            $this->cod_estado = $resultadoTrait[1];
            $this->estado = 1;
        } else {
            return $resultadoTrait;
        }
        return $this->registrarMunicipio();
    }

    private function registrarMunicipio()
    {
        try {
            $sentencia = "INSERT INTO municipio (nombre,cod_estado,estado) VALUES (?, ?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->cod_estado);
            $insert->bindValue(3, $this->estado);

            $insert->execute();

            return json_encode(['status' => 'success', 'message' => 'El Municipio ha sido registrado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function modDatosMunicipio(array $campos)
    {

        $resultadoTrait = $this->validarPost($campos);

        if ($this->verificarMunicipioDuplicado($this->formatearPalabra($resultadoTrait[1]), $resultadoTrait[2])) {
            return json_encode(['status' => 'exists', 'message' => 'El Municipio se encuentra registrado']);
        }

        if (is_array($this->validarPost($resultadoTrait))) {

            $this->cod_municipio = $resultadoTrait[0];
            $this->nombre = $this->formatearPalabra($resultadoTrait[1]);
            $this->cod_estado = $resultadoTrait[2];
        } else {
            return $resultadoTrait;
        }
        return $this->modificarMunicipio();
    }


    private function modificarMunicipio()
    {
        try {
            $sentencia = "UPDATE `municipio` SET nombre = ?, cod_estado = ? WHERE cod_municipio = ?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $this->nombre);
            $update->bindValue(2, $this->cod_estado);
            $update->bindValue(3, $this->cod_municipio);

            $update->execute();
            return json_encode(['status' => 'updated', 'message' => 'El Municipio ha sido modificado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }


    public function elmDatosMunicipio(array $campos)
    {
        $resultadoTrait = $this->validarPost($campos);
        if (is_array($resultadoTrait)) {


            $this->cod_municipio = $resultadoTrait[0];
        } else {
            return $resultadoTrait;
        }

        return $this->eliminarMunicipio();
    }

    private function eliminarMunicipio()
    {
        try {
            $sentencia = "UPDATE `municipio` SET estado = 0 WHERE cod_municipio = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_municipio);
            $delete->execute();

            return json_encode(['status' => 'deleted', 'message' => 'El Municipio ha sido eliminado correctamente.']);
        } catch (\PDOException $e) {
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }
}
