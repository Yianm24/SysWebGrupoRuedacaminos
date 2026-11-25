<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\EnvioTrait;
use App\Traits\ValidadorTraitAjax;

class Envio extends Conexion
{

    use ValidadorTraitAjax;
    use EnvioTrait;

    private $cod_remitente, $cod_destinatario;
    private $cod_envio;
    private $ancho, $alto, $peso_total, $descripcion;
    private $monto_total;
    // private $cod_municipio_despacho, $cod_municipio_destino;
    private $ubicacion_despacho, $ubicacion_destino;
    private $fecha;
    private $cod_precio_kilometraje, $distancia_total;
    private $estado;
    private $estatus_fragil;

    public function __construct()
    {
        parent::__construct();
    }

    public function obt_RegistrosEnvio()
    {
        try {
            $sentencia = "SELECT 
                e.cod_envio,
                e.fecha,
                e.monto_total,
                e.estado,
                e.cod_despacho,
                COALESCE(e.estatus, 'PENDIENTE') AS estatus,
                e.peso_total,
                e.anchura,
                e.altura,
                e.descrip_contenido,
                e.distancia_total,
                e.estatus_fragil,
                c_rem.tipo_documento AS rem_tipo_doc,
                c_rem.doc_identidad AS rem_doc,
                c_rem.razon_social AS rem_nombre,
                c_rem.apellido AS rem_apellido,
                c_rem.telefono AS rem_telefono,
                c_rem.email AS rem_correo,
                c_dest.tipo_documento AS dest_tipo_doc,
                c_dest.doc_identidad AS dest_doc,
                c_dest.razon_social AS dest_nombre,
                c_dest.apellido AS dest_apellido,
                c_dest.telefono AS dest_telefono,
                c_dest.email AS dest_correo,
                u_dest.cod_ubicacion AS cod_ubicacion_destino,
                u_dest.cod_municipio AS cod_municipio_destino,
                m_dest.nombre AS municipio_destino,
                est_dest.nombre AS estado_destino,
                u_dest.descripcion AS direccion_destino,
                u_orig.cod_ubicacion AS cod_ubicacion_origen,
                u_orig.cod_municipio AS cod_municipio_origen,
                m_orig.nombre AS municipio_origen,
                est_orig.nombre AS estado_origen,
                u_orig.descripcion AS direccion_origen,
                d.fecha_salida AS despacho_fecha,
                d.estatus AS despacho_estatus
            FROM envio e
            LEFT JOIN participante_envio pe_rem ON e.cod_envio = pe_rem.cod_envio AND pe_rem.rol_cliente = 'Remitente'
            LEFT JOIN cliente c_rem ON pe_rem.cod_cliente = c_rem.cod_cliente
            LEFT JOIN participante_envio pe_dest ON e.cod_envio = pe_dest.cod_envio AND pe_dest.rol_cliente = 'Destinatario'
            LEFT JOIN cliente c_dest ON pe_dest.cod_cliente = c_dest.cod_cliente
            LEFT JOIN ubicaciones_envio ue_dest ON e.cod_envio = ue_dest.cod_envio AND ue_dest.tipo_ubicacion = 'Destino'
            LEFT JOIN ubicacion u_dest ON ue_dest.cod_ubicacion = u_dest.cod_ubicacion
            LEFT JOIN municipio m_dest ON u_dest.cod_municipio = m_dest.cod_municipio
            LEFT JOIN estado est_dest ON m_dest.cod_estado = est_dest.cod_estado
            LEFT JOIN ubicaciones_envio ue_orig ON e.cod_envio = ue_orig.cod_envio AND ue_orig.tipo_ubicacion = 'Despacho'
            LEFT JOIN ubicacion u_orig ON ue_orig.cod_ubicacion = u_orig.cod_ubicacion
            LEFT JOIN municipio m_orig ON u_orig.cod_municipio = m_orig.cod_municipio
            LEFT JOIN estado est_orig ON m_orig.cod_estado = est_orig.cod_estado
            LEFT JOIN despacho d ON e.cod_despacho = d.cod_despacho
            WHERE 1
            ORDER BY e.cod_envio DESC";

            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            $registros = json_encode($select->fetchAll(\PDO::FETCH_ASSOC));
            return $registros;
        } catch (\PDOException $e) {
            return [];
        }
    }

    private function calcularCosteEnvio(float $kilometraje, $precioKm = 2.36): float
    {
        try {
            $montofinal = $kilometraje * $precioKm;
            return $montofinal;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function creDatosEnvio(array $remitente, array $destinatario, array $campos, $fecha, $estatus_fragil, $ubicacion_despacho, $ubicacion_destino)
    {

        $this->cod_remitente = $this->extraerDatosParticipante($remitente);
        $this->cod_destinatario = $this->extraerDatosParticipante($destinatario);

        $resultTrait = $this->validarPost($campos);
        if (is_array($resultTrait)) {

            $this->fecha = $fecha;
            $this->ancho = $resultTrait[0];
            $this->alto = $resultTrait[1];
            $this->descripcion = $resultTrait[2];
            $this->monto_total = $this->calcularCosteEnvio($resultTrait[4]);
            $this->distancia_total = $resultTrait[4];
            $this->estado = 1;
            $this->estatus_fragil = $estatus_fragil;
            $this->peso_total = $resultTrait[3];
            $this->ubicacion_despacho = $ubicacion_despacho;
            $this->ubicacion_destino = $ubicacion_destino;
        } else {

            return $resultTrait;
        }

        return $this->crearEnvio();
    }


    private function crearEnvio()
    {
        try {
            $this->conexion->beginTransaction();

            $sqlEnvio = "INSERT INTO `envio` (
            `fecha`, 
            `estatus_fragil`, 
            `estado`, 
            `descrip_contenido`, 
            `anchura`, 
            `altura`, 
            `peso_total`, 
            `distancia_total`,
            `monto_total`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)";

            $insertEnvio = $this->conexion->prepare($sqlEnvio);
            $insertEnvio->execute([
                $this->fecha,
                $this->estatus_fragil,
                $this->estado,
                $this->descripcion,
                $this->ancho,
                $this->alto,
                $this->peso_total,
                $this->distancia_total,
                $this->monto_total
            ]);

            $cod_envio = $this->conexion->lastInsertId();

            $sqlParticipante = "INSERT INTO `participante_envio` (`cod_cliente`, `cod_envio`, `rol_cliente`) 
                            VALUES (?, ?, ?)";
            $insertParticipante = $this->conexion->prepare($sqlParticipante);

            $insertParticipante->execute([$this->cod_remitente, $cod_envio, 'Remitente']);
            $insertParticipante->execute([$this->cod_destinatario, $cod_envio, 'Destinatario']);

            $sqlUbicacion = "INSERT INTO `ubicaciones_envio` (`cod_ubicacion`, `cod_envio`,`tipo_ubicacion`) VALUES (?, ?, ?)";
            $insertUbicacion = $this->conexion->prepare($sqlUbicacion);

            $insertUbicacion->execute([$this->ubicacion_despacho, $cod_envio, 'Despacho']);
            $insertUbicacion->execute([$this->ubicacion_destino, $cod_envio, 'Destino']);

            $this->conexion->commit();
            return json_encode(['status' => 'success', 'message' => 'El envio ha sido creado correctamente.']);
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    public function registrarUbicacion($descripcion, $cod_municipio)
    {
        try {
            $this->conexion->beginTransaction();

            $sentencia = "INSERT INTO ubicacion (descripcion, cod_municipio, estado) VALUES (?, ?, ?)";
            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $descripcion);
            $insert->bindValue(2, $cod_municipio);
            $insert->bindValue(3, 1);
            $insert->execute();
            $idInsertado = $this->conexion->lastInsertId();

            $this->conexion->commit();

            return $idInsertado;
        } catch (\PDOException $e) {

            $this->conexion->rollBack();
            return null;
        }
    }

    private function modificarUbicacion($cod_ubi, $descripcion, $cod_municipio)
    {
        try {
            $this->conexion->beginTransaction();

            $sentencia = "UPDATE ubicacion SET descripcion=?,cod_municipio=? WHERE cod_ubicacion=?";
            $update = $this->conexion->prepare($sentencia);

            $update->bindValue(1, $descripcion);
            $update->bindValue(2, $cod_municipio);
            $update->bindValue(3, $cod_ubi);
            $update->execute();
            $idInsertado = $this->conexion->lastInsertId();

            $this->conexion->commit();

          //  return $idInsertado;
        } catch (\PDOException $e) {

            $this->conexion->rollBack();
        // return null;
        }
    }

    public function elmDatosEnvio(array $campos)
    {
        $resultTrait = $this->validarPost($campos);
        if (is_array($resultTrait)) {
            $this->cod_envio = $resultTrait[0];
        } else {
            return $resultTrait;
        }
        return $this->eliminarEnvio();
    }

    private function eliminarEnvio()
    {

        try {
            $sentencia = "UPDATE `Envio` SET estado = 0 , estatus='ANULADO' WHERE cod_envio = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_envio);
            $delete->execute();

            return json_encode(['status' => 'deleted', 'message' => 'El envio ha sido eliminado correctamente.']);
        } catch (\PDOException $e) {
            return  json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function modDatosEnvio(array $campos, $estatus_fragil, array $camposDespacho, array $camposDestino)
    {
        $resultadoTrait = $this->validarPost($campos);
        $resultTraitDespacho = $this->validarPost($camposDespacho);
        $resultTraitDestino = $this->validarPost($camposDestino);

        //valida si inputs de despacho estan vacios
        if (!is_array($resultTraitDespacho)) {
            return $resultTraitDespacho;
        }
        //valida si inputs de destino estan vacios
        if (!is_array($resultTraitDestino)) {
            return $resultTraitDestino;
        }

        if (is_array($resultadoTrait)) {

            $this->cod_envio = $resultadoTrait[0];
            $this->ancho = $resultadoTrait[1];
            $this->alto = $resultadoTrait[2];
            $this->descripcion = $resultadoTrait[3];
            $this->peso_total = $resultadoTrait[4];
            $this->distancia_total = $resultadoTrait[5];
            $this->estatus_fragil = $estatus_fragil;
            $this->monto_total = $this->calcularCosteEnvio($resultadoTrait[5]);

            $this->modificarUbicacion($resultTraitDespacho[0], $resultTraitDespacho[1], $resultTraitDespacho[2]);

            $this->modificarUbicacion($resultTraitDestino[0], $resultTraitDestino[1], $resultTraitDestino[2]);
        } else {
            return $resultadoTrait;
        }

        return $this->modificarEnvio();
    }

    private function modificarEnvio()
    {
        try {
            $checkStmt = $this->conexion->prepare("SELECT estatus, cod_despacho, estado FROM envio WHERE cod_envio = ?");
            $checkStmt->execute([$this->cod_envio]);
            $envio = $checkStmt->fetch(\PDO::FETCH_ASSOC);

            if (!$envio || $envio['estado'] != 1) {
                return  json_encode(['status' => 'error', 'message' => 'El envio se encuentra inactivo']);
            }

            if ($envio['estatus'] !== 'PENDIENTE' || !empty($envio['cod_despacho'])) {
                return  json_encode(['status' => 'error', 'message' => 'Solo se pueden modificar envios que se encuentren PENDIENTES']);
            }


            $this->conexion->beginTransaction();

            $sql = "UPDATE envio SET 
                descrip_contenido = ?, 
                anchura = ?, 
                altura = ?, 
                peso_total = ?, 
                distancia_total = ?, 
                monto_total = ?, 
                estatus_fragil = ?
                WHERE cod_envio = ?";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                $this->descripcion,
                $this->ancho,
                $this->alto,
                $this->peso_total,
                $this->distancia_total,
                $this->monto_total,
                $this->estatus_fragil,
                $this->cod_envio
            ]);

            $this->conexion->commit();
            return json_encode(['status' => 'updated', 'message' => 'El envio ha sido modificiado correctamente.']);
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return "exception&msg=" . urlencode($e->getMessage());
        }
    }
}
