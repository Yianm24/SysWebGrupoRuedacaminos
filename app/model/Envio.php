<?php

namespace App\Model;

use App\Config\Conexion;

class Envio extends Conexion
{

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

    public function obt_RegistrosEnvio()
    {
        try {
            $sentencia = "SELECT participante_envio.*, cliente.*, envio.*
            FROM participante_envio
            INNER JOIN cliente
            ON participante_envio.cod_cliente= cliente.cod_cliente
            INNER JOIN envio 
    		ON participante_envio.cod_envio = envio.cod_envio
            WHERE cliente.estado=1 and envio.estado=1 and participante_envio.rol_cliente='Remitente';";

            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function obt_DestinatariosEnvio()
    {
        try {
            $sentencia = "SELECT participante_envio.cod_envio, cliente.razon_social, cliente.apellido
            FROM participante_envio
            INNER JOIN cliente
            ON participante_envio.cod_cliente= cliente.cod_cliente
            INNER JOIN envio 
    		ON participante_envio.cod_envio = envio.cod_envio
            WHERE cliente.estado=1 and envio.estado=1 and participante_envio.rol_cliente='Destinatario';";

            $select = $this->conexion->prepare($sentencia);
            $select->execute();
            return $select->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function creDatosEnvio($remitente, $destinatario, $ancho, $alto, $descripcion, $fecha, $estatus_fragil, $peso_total, $distancia_total, $ubicacion_despacho, $ubicacion_destino)
    {
        $this->cod_remitente = $remitente;
        $this->cod_destinatario = $destinatario;
        $this->fecha = $fecha;
        $this->ancho = $ancho;
        $this->alto = $alto;
        $this->descripcion_cont = $descripcion;
        // $this->monto_total = 1000.5;
        $this->distancia_total = $distancia_total;
        $this->estado = 1;
        $this->estatus_fragil = $estatus_fragil;
        $this->peso_total = $peso_total;
        $this->ubicacion_despacho = $ubicacion_despacho;
        $this->ubicacion_destino = $ubicacion_destino;

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
            `distancia_total`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $insertEnvio = $this->conexion->prepare($sqlEnvio);
            $insertEnvio->execute([
                $this->fecha,
                $this->estatus_fragil,
                $this->estado,
                $this->descripcion_cont,
                $this->ancho,
                $this->alto,
                $this->peso_total,
                $this->distancia_total
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
            $sqlUbicacion = "INSERT INTO `ubicaciones_envio` (`cod_ubicacion`, `cod_envio`,`tipo_ubicacion`) 
                         VALUES (?, ?, ?)";
            $insertUbicacion = $this->conexion->prepare($sqlUbicacion);

            $insertUbicacion->execute([$this->ubicacion_despacho, $cod_envio, 'Despacho']);
            $insertUbicacion->execute([$this->ubicacion_destino, $cod_envio, 'Destino']);

            $this->conexion->commit();
            return true;
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            return "<script>alert('Error al crear el envío: " . addslashes($e->getMessage()) . "');</script>";
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
}
