<?php

namespace App\Model;

use App\Config\Conexion;

class Despacho extends Conexion
{
    private $cod_despacho;
    private $enviosSelect;
    private $cod_empleado;
    private $cod_vehiculo;
    private $fecha_salida;
    private $fecha_entrega;
    private $estatus;
    private $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function obt_RegistrosDespacho(): array
    {
        try {
            $sentencia = "SELECT 
                d.cod_despacho,
                d.fecha_salida,
                d.fecha_entrega,
                COALESCE(d.estatus, 'PENDIENTE') AS estatus,
                d.estado,
                e.cod_empleado,
                e.nombre AS nombre_chofer,
                e.apellido AS apellido_chofer,
                e.cedula AS cedula_chofer,
                e.telefono AS telefono_chofer,
                v.cod_vehiculo,
                v.placa AS placa_vehiculo,
                v.peso_max,
                m.nombre AS modelo_vehiculo,
                COUNT(env.cod_envio) AS total_envios,
                COALESCE(SUM(env.peso_total), 0) AS peso_total_despacho
            FROM despacho d
            INNER JOIN empleado e ON d.cod_empleado = e.cod_empleado
            INNER JOIN vehiculo v ON d.cod_vehiculo = v.cod_vehiculo
            LEFT JOIN modelo m ON v.cod_modelo = m.cod_modelo
            LEFT JOIN envio env ON d.cod_despacho = env.cod_despacho AND env.estado = 1
            WHERE d.estado = 1
            GROUP BY d.cod_despacho, d.fecha_salida, d.fecha_entrega, d.estatus, d.estado,
                     e.cod_empleado, e.nombre, e.apellido, e.cedula, e.telefono,
                     v.cod_vehiculo, v.placa, v.peso_max, m.nombre
            ORDER BY d.cod_despacho DESC";

            $stmt = $this->conexion->prepare($sentencia);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    /* public function regDatosDespacho($cod_empleado, $cod_vehiculo, $fecha_salida, array $envios_seleccionados = [])
    {
        if (empty($cod_empleado) || empty($cod_vehiculo) || empty($fecha_salida)) {
            return json_encode(['status' => 'empty', 'message' => 'Uno o más campos están vacíos.']);
        }else{
        $this->enviosSelect = $envios_seleccionados;
        $this->cod_vehiculo = $cod_vehiculo;
        $this->fecha_salida = $fecha_salida;
        $this->cod_empleado = $cod_empleado;
        }
        return $this->regDespacho();
    }

    private function regDespacho()
    {
        try {
            $this->conexion->beginTransaction();

            $sql = "INSERT INTO despacho (cod_empleado, cod_vehiculo, fecha_salida, estatus, estado) 
                    VALUES (?, ?, ?, 'PENDIENTE', 1)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$this->cod_empleado,$this->cod_vehiculo,$this->fecha_salida]);

            $cod_despacho = (int)$this->conexion->lastInsertId();

            if (!empty($this->enviosSelect)) {
                $sqlEnvio = "UPDATE envio SET cod_despacho = ?, estatus = 'EN DESPACHO' 
                             WHERE cod_envio = ? AND estado = 1 AND (estatus = 'PENDIENTE' OR estatus IS NULL)";
                $stmtEnvio = $this->conexion->prepare($sqlEnvio);

                foreach ($this->enviosSelect as $cod_envio) {
                    $cod = (int)$cod_envio;
                    if ($cod > 0) {
                        $stmtEnvio->execute([$cod_despacho, $cod]);
                    }
                }
            }

            $this->conexion->commit();
            return json_encode(['status' => 'success', 'message' => 'El despacho ha sido registrado correctamente.']);
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    } */

    public function regDatosDespacho($cod_empleado, $cod_vehiculo, $fecha_salida, array $envios_seleccionados = [])
    {
        if (empty($cod_empleado) || empty($cod_vehiculo) || empty($fecha_salida)) {
            return json_encode(['status' => 'empty', 'message' => 'Uno o más campos están vacíos.']);
        }

        // Asignamos los datos a las propiedades de la clase
        $this->cod_empleado = $cod_empleado;
        $this->cod_vehiculo = $cod_vehiculo;
        $this->fecha_salida = $fecha_salida;
        $this->enviosSelect = $envios_seleccionados; 

        return $this->regDespacho();
    }

    private function regDespacho()
    {
        try {
            $this->conexion->beginTransaction();

            $sql = "INSERT INTO despacho (cod_empleado, cod_vehiculo, fecha_salida, estatus, estado) 
                    VALUES (?, ?, ?, 'PENDIENTE', 1)";
            $stmt = $this->conexion->prepare($sql);
            
            $stmt->execute([$this->cod_empleado, $this->cod_vehiculo, $this->fecha_salida]);

            $cod_despacho = (int)$this->conexion->lastInsertId();

            // Ingresar cod_depacho a los envíos si seleccionados
            if (!empty($this->enviosSelect) && is_array($this->enviosSelect)) {
                $sqlEnvio = "UPDATE envio SET cod_despacho = ?, estatus = 'EN DESPACHO' 
                             WHERE cod_envio = ? AND estado = 1 AND (estatus = 'PENDIENTE' OR estatus IS NULL)";
                $stmtEnvio = $this->conexion->prepare($sqlEnvio);

                foreach ($this->enviosSelect as $cod_envio) {
                    $cod = (int)$cod_envio;
                    if ($cod > 0) {
                        $stmtEnvio->execute([$cod_despacho, $cod]);
                    }
                }
            }

            $this->conexion->commit();
            
            $cantidadAsignada = is_array($this->enviosSelect) ? count($this->enviosSelect) : 0;
            return json_encode([
                'status' => 'success', 
                'message' => "El despacho ha sido registrado correctamente con $cantidadAsignada envíos."
            ]);
            
        } catch (\PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return json_encode(['status' => 'exception', 'message' => $e->getMessage()]);
        }
    }

    /* private function regDespacho()
    {
        try {
            $sentencia = "INSERT INTO `despacho`(`cod_vehiculo`, `fecha_salida`, `estado`) VALUES ('[value-1]','[value-2]','[value-3]')";
            $insert = $this->conexion->prepare($sentencia);
            $insert->bindValue(1, $this->cod_vehiculo);
            $insert->bindValue(2, $this->fecha_salida);
            $insert->bindValue(3, $this->estado);
            $resultado = $insert->execute();

            return $resultado;
        } catch (\PDOException $e) {
            urlencode($e);
            return header("Location: ?url=despacho&status=bdError&msg='$e'");
        }
    } */
}
