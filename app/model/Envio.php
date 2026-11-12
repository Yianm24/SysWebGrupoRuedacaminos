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
    private $ancho, $alto, $peso_total, $descripcion_cont;
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

    public function obt_EnviosPendientes()
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
                c_dest.tipo_documento AS dest_tipo_doc,
                c_dest.doc_identidad AS dest_doc,
                c_dest.razon_social AS dest_nombre,
                c_dest.apellido AS dest_apellido,
                c_dest.telefono AS dest_telefono,
                m_dest.nombre AS municipio_destino,
                est_dest.nombre AS estado_destino,
                u_dest.descripcion AS direccion_destino
            FROM envio e
            LEFT JOIN participante_envio pe_dest ON e.cod_envio = pe_dest.cod_envio AND pe_dest.rol_cliente = 'Destinatario'
            LEFT JOIN cliente c_dest ON pe_dest.cod_cliente = c_dest.cod_cliente
            LEFT JOIN ubicaciones_envio ue_dest ON e.cod_envio = ue_dest.cod_envio AND ue_dest.tipo_ubicacion = 'Destino'
            LEFT JOIN ubicacion u_dest ON ue_dest.cod_ubicacion = u_dest.cod_ubicacion
            LEFT JOIN municipio m_dest ON u_dest.cod_municipio = m_dest.cod_municipio
            LEFT JOIN estado est_dest ON m_dest.cod_estado = est_dest.cod_estado
            WHERE e.estatus = 'PENDIENTE'
            ORDER BY e.cod_envio DESC";

            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
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
                c_dest.tipo_documento AS dest_tipo_doc,
                c_dest.doc_identidad AS dest_doc,
                c_dest.razon_social AS dest_nombre,
                c_dest.apellido AS dest_apellido,
                c_dest.telefono AS dest_telefono,
                m_dest.nombre AS municipio_destino,
                est_dest.nombre AS estado_destino,
                u_dest.descripcion AS direccion_destino,
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

    // public function obt_DestinatariosEnvio()
    // {
    //     try {
    //         $sentencia = "SELECT participante_envio.cod_envio, cliente.razon_social, cliente.apellido
    //         FROM participante_envio
    //         INNER JOIN cliente
    //         ON participante_envio.cod_cliente= cliente.cod_cliente
    //         INNER JOIN envio 
    // 		ON participante_envio.cod_envio = envio.cod_envio
    //         WHERE cliente.estado=1 and envio.estado=1 and participante_envio.rol_cliente='Destinatario';";

    //         $select = $this->conexion->prepare($sentencia);
    //         $select->execute();
    //         return $select->fetchAll(\PDO::FETCH_ASSOC);
    //     } catch (\PDOException $e) {
    //         return [];
    //     }
    // }


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
            $this->descripcion_cont = $resultTrait[2];
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

            // 1. Inserción en la tabla 'envio'
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
                $this->descripcion_cont,
                $this->ancho,
                $this->alto,
                $this->peso_total,
                $this->distancia_total,
                $this->monto_total
            ]);

            // Obtener el ID autogenerado del envío
            $cod_envio = $this->conexion->lastInsertId();

            // 2. Inserción de participantes (Remitente y Destinatario)
            $sqlParticipante = "INSERT INTO `participante_envio` (`cod_cliente`, `cod_envio`, `rol_cliente`) 
                            VALUES (?, ?, ?)";
            $insertParticipante = $this->conexion->prepare($sqlParticipante);

            $insertParticipante->execute([$this->cod_remitente, $cod_envio, 'Remitente']);
            $insertParticipante->execute([$this->cod_destinatario, $cod_envio, 'Destinatario']);

            // 3. Inserción de ubicaciones (Despacho y Destino) en 'ubicaciones_envio'
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

            // Obtiene el ID autoincremental generado por el INSERT anterior
            $idInsertado = $this->conexion->lastInsertId();

            $this->conexion->commit();

            return $idInsertado;
        } catch (\PDOException $e) {
            // Si hay error, deshace los cambios
            $this->conexion->rollBack();
            return null; // O manejar el error según necesites
        }
    }


    public function modDatosEnvio(array $tipo_cliente, array $campos, $fecha, $estatus_fragil, $ubicacion_despacho, $ubicacion_destino)
    {

        $this->cod_remitente = $this->extraerDatosParticipante($tipo_cliente[0], "remitente", "rem");
        $this->cod_destinatario = $this->extraerDatosParticipante($tipo_cliente[1], "destinatario", "dest");


        if (is_array($this->validarPost($campos, "envio"))) {

            $array = $this->validarPost($campos, "estado");
            $this->cod_envio = $array['cod_envio'];
            $this->fecha = $fecha;
            $this->ancho = $array['ancho'];
            $this->alto = $array['alto'];
            $this->descripcion_cont = $array['descripcion'];
            $this->monto_total = $this->calcularCosteEnvio($array['kilometraje']);
            $this->distancia_total = $array['kilometraje'];
            $this->estado = 1;
            $this->estatus_fragil = $estatus_fragil;
            $this->peso_total = $array['peso_total'];
            $this->ubicacion_despacho = $ubicacion_despacho;
            $this->ubicacion_destino = $ubicacion_destino;
        } else {

            return 'error&msg=Registrar';
        }

        return $this->modificar_envio();
    }

    private function modificar_envio()
    {
        try {
            $this->conexion->beginTransaction();

            // 1. Actualización en la tabla 'envio'
            $sqlEnvio = "UPDATE `envio` SET 
            `fecha` = ?, 
            `estatus_fragil` = ?, 
            `estado` = ?, 
            `descrip_contenido` = ?, 
            `anchura` = ?, 
            `altura` = ?, 
            `peso_total` = ?, 
            `distancia_total` = ?, 
            `monto_total` = ? 
            WHERE `cod_envio` = ?";

            $updateEnvio = $this->conexion->prepare($sqlEnvio);
            $updateEnvio->execute([
                $this->fecha,
                $this->estatus_fragil,
                $this->estado,
                $this->descripcion_cont,
                $this->ancho,
                $this->alto,
                $this->peso_total,
                $this->distancia_total,
                $this->monto_total,
                $this->cod_envio
            ]);

            // 2. Actualización de participantes (Remitente y Destinatario)
            $sqlParticipante = "UPDATE `participante_envio` 
                            SET `cod_cliente` = ? 
                            WHERE `cod_envio` = ? AND `rol_cliente` = ?";
            $updateParticipante = $this->conexion->prepare($sqlParticipante);

            $updateParticipante->execute([$this->cod_remitente, $this->cod_envio, 'Remitente']);
            $updateParticipante->execute([$this->cod_destinatario, $this->cod_envio, 'Destinatario']);

            // 3. Actualización de ubicaciones (Despacho y Destino)
            $sqlUbicacion = "UPDATE `ubicaciones_envio` 
                         SET `cod_ubicacion` = ? 
                         WHERE `cod_envio` = ? AND `tipo_ubicacion` = ?";
            $updateUbicacion = $this->conexion->prepare($sqlUbicacion);

            $updateUbicacion->execute([$this->ubicacion_despacho, $this->cod_envio, 'Despacho']);
            $updateUbicacion->execute([$this->ubicacion_destino, $this->cod_envio, 'Destino']);

            $this->conexion->commit();
            return 'success';
        } catch (\PDOException $e) {
            // Revertir los cambios si ocurre algún error en cualquiera de las consultas
            $this->conexion->rollBack();
            return 'error: ' . $e->getMessage();
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


    public function modEnvio(array $campos)
    {

        $array = $this->validarPost($campos, 'envio');
    }
}
