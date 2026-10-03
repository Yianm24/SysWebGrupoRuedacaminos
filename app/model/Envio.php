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
    private $cod_precio_kilometraje;
    private $estado;
    private $estatus_fragil;

    public function __construct()
    {
        parent::__construct();
    }

    public function regDatosEnvio($remitente, $destinatario, $municipio_despacho, $municipio_destino, $ubicacion_despacho, $ubicacion_destino, $precio_kilometraje, $monto_total, $ancho, $alto, $peso_total, $descripcion, $fecha, $estatus_fragil)
    {
        $this->cod_remitente = $remitente;
        $this->cod_destinatario = $destinatario;
        $this->cod_municipio_despacho = $municipio_despacho;
        $this->cod_municipio_destino = $municipio_destino;
        $this->ubicacion_despacho = $ubicacion_despacho;
        $this->ubicacion_destino = $ubicacion_destino;
        $this->fecha = $fecha;
        $this->ancho = $ancho;
        $this->alto = $alto;
        $this->descripcion_cont = $descripcion;
        $this->monto_total = $monto_total;
        $this->cod_precio_kilometraje = $precio_kilometraje;
        $this->peso_total = $peso_total;
        $this->estado = 1;
        $this->estatus_fragil=$estatus_fragil;

        return $this->registrarEnvio();
    }

    private function registrarEnvio()
    {
        try {
            $sentencia = "INSERT INTO marca (nombre,estado) VALUES (?, ?)";

            $insert = $this->conexion->prepare($sentencia);

            $insert->bindValue(1, $this->nombre);
            $insert->bindValue(2, $this->estado);
            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            return "<script>alert('Error al registrar la Marca: " . $e->getMessage() . "');</script>";
        }
    }


    public function registrarParticipantes($cod_remitente, $cod_destinatario, $cod_envio) {}
}
