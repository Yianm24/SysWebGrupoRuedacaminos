<?php

namespace App\Model;

use App\Config\Conexion;

class Envio extends Conexion
{

    private $cod_remitente, $cod_destinatario;
    private $cod_envio;
    private $ancho, $alto, $peso_total, $descripcion_cont;
    private $monto_total;
    private $cod_municipio_despacho, $cod_municipio_destino;
    private $ubicacion_despacho, $ubicacion_destino;
    private $fecha;
    private $cod_precio_kilometraje, $distancia_total;
    private $estado;
    private $estatus_fragil;

    public function __construct()
    {
        parent::__construct();
    }

    // public function regDatosEnvio($remitente, $destinatario, $municipio_despacho, $municipio_destino, $ubicacion_despacho, $ubicacion_destino, $precio_kilometraje, $monto_total, $ancho, $alto, $peso_total, $descripcion, $fecha, $estatus_fragil)
    // {
    //     $this->cod_remitente = $remitente;
    //     $this->cod_destinatario = $destinatario;
    //     $this->cod_municipio_despacho = $municipio_despacho;
    //     $this->cod_municipio_destino = $municipio_destino;
    //     $this->ubicacion_despacho = $ubicacion_despacho;
    //     $this->ubicacion_destino = $ubicacion_destino;
    //     $this->fecha = $fecha;
    //     $this->ancho = $ancho;
    //     $this->alto = $alto;
    //     $this->descripcion_cont = $descripcion;
    //     $this->monto_total = $monto_total;
    //     $this->cod_precio_kilometraje = $precio_kilometraje;
    //     $this->peso_total = $peso_total;
    //     $this->estado = 1;
    //     $this->estatus_fragil=$estatus_fragil;

    //     return $this->registrarEnvio();
    // }

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

    public function creDatosEnvio($remitente, $destinatario, $ancho, $alto, $descripcion, $fecha, $estatus_fragil,$peso_total)
    {
        $this->cod_remitente = $remitente;
        $this->cod_destinatario = $destinatario;
        $this->fecha = $fecha;
        $this->ancho = $ancho;
        $this->alto = $alto;
        $this->descripcion_cont = $descripcion;
        // $this->monto_total = 1000.5;
        // $this->peso_total = 10.80;
        // $this->distancia_total = 500;
        $this->estado = 1;
        $this->estatus_fragil = $estatus_fragil;
        $this->peso_total = $peso_total;
        return $this->crearEnvio();
    }

    private function crearEnvio()
    {
        try {
            $this->conexion->beginTransaction();

            $sqlEnvio = "INSERT INTO `envio`(`fecha`, `estatus_fragil`, `estado`, `descrip_contenido`, `anchura`, `altura`,`peso_total`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

            $insertEnvio = $this->conexion->prepare($sqlEnvio);
            $insertEnvio->bindValue(1, $this->fecha);
            $insertEnvio->bindValue(2, $this->estatus_fragil);
            $insertEnvio->bindValue(3, $this->estado);
            $insertEnvio->bindValue(4, $this->descripcion_cont);
            $insertEnvio->bindValue(5, $this->ancho);
            $insertEnvio->bindValue(6, $this->alto);
            $insertEnvio->bindValue(7, $this->peso_total);
            $insertEnvio->execute();

            $cod_envio = $this->conexion->lastInsertId();

            $sqlParticipante = "INSERT INTO `participante_envio`(`cod_cliente`, `cod_envio`, `rol_cliente`) 
                            VALUES (?, ?, ?)";
            $insertParticipante = $this->conexion->prepare($sqlParticipante);

            $insertParticipante->execute([$this->cod_remitente, $cod_envio, 'Remitente']);                  // 6. Ejecutamos para el Destinatario$insertParticipante->execute([$this->cod_destinatario,$cod_envio, 'Destinatario']);

            $insertParticipante = $this->conexion->prepare($sqlParticipante);

            $insertParticipante->execute([$this->cod_destinatario, $cod_envio, 'Destinatario']);
            $this->conexion->commit();

            return true;
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }

            return "<script>alert('Error al crear el envío: " . $e->getMessage() . "');</script>";
        }
    }
}
