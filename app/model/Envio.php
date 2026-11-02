<?php

namespace App\Model;

use App\Config\Conexion;
use App\Traits\EnvioTrait;
use App\Traits\ValidadorTrait;

class Envio extends Conexion
{

    use ValidadorTrait;
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


    private function calcularCosteEnvio(float $kilometraje, $precioKm = 2.36): float
    {
        try {
            $montofinal = $kilometraje * $precioKm;
            return $montofinal;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function creDatosEnvio(array $tipo_cliente, array $campos, $fecha, $estatus_fragil, $ubicacion_despacho, $ubicacion_destino)
    {

        $this->cod_remitente = $this->extraerDatosParticipante($tipo_cliente[0], "remitente", "rem");
        $this->cod_destinatario = $this->extraerDatosParticipante($tipo_cliente[1], "destinatario", "dest");


        if (is_array($this->validarPost($campos, "envio"))) {

            $array = $this->validarPost($campos, "estado");
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
            return 'success';
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            return "exception&msg=" . urlencode($e->getMessage());
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

    public function elmDatosEnvio(array $campos)
    {

        if (is_array($this->validarPost($campos, "envio"))) {
            $array = $this->validarPost($campos, "envio");
            $this->cod_envio = $array['cod_envio'];
        } else {
            return 'error&msg=Eliminar';
        }
        return $this->eliminarEnvio();
    }

    private function eliminarEnvio()
    {

        try {
            $sentencia = "UPDATE `Envio` SET estado = 0 WHERE cod_envio = ?";
            $delete = $this->conexion->prepare($sentencia);

            $delete->bindValue(1, $this->cod_envio);
            $delete->execute();

            return "deleted";
        } catch (\PDOException $e) {
            return  "exception&msg=" . urlencode($e->getMessage());
        }
    }


    public function modEnvio(array $campos)
    {

        $array = $this->validarPost($campos, 'envio');
    }
}
