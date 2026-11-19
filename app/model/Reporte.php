<?php
    namespace App\model;

    use Dompdf\Dompdf;
    use Dompdf\Options;

    class Reporte {
        private $objDompdf;

        public function __construct()
        {
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('defaultFont', 'Helvetica');

            $this->objDompdf = new Dompdf($options);
        }

        public function ConstruirHtml($modulo, array $datos){
            $html = '';
            $nombreDoc = '';
            $fecha = date('d/m/Y H:i');
            switch($modulo){
                case 'envio':
                    $html = "
                    <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Helvetica, Arial, sans-serif; color: #1e293b; margin: 30px; }
                header { border-bottom: 2px solid #4f46e5; padding-bottom: 12px; margin-bottom: 20px; }
                h1 { color: #4f46e5; font-size: 20px; margin: 0; }
                .fecha { font-size: 11px; color: #64748b; margin-top: 4px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
                th, td { border: 1px solid #cbd5e1; padding: 10px; text-align: left; }
                th { background-color: #f1f5f9; color: #0f172a; font-weight: bold; }
                tr:nth-child(even) { background-color: #f8fafc; }
                .badge { font-weight: bold; padding: 3px 6px; border-radius: 4px; }
            </style>
        </head>
        <body>
            <header>
                <h1>Envios</h1>
                <div class='fecha'>Reporte generado el: {$fecha}</div>
            </header>
            <main>
                <table>
                    <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>REMITENTE</th>
                            <th>DESTINATARIO</th>
                            <th>DESTINO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>PESO TOTAL</th>
                            <th>STATUS</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>";

        foreach ($datos as $item) {
            $html .= "<tr>
                <td>{$item['cod_envio']}</td>
                <td>" . htmlspecialchars($item['rem_nombre'])." - ".htmlspecialchars($item['rem_apellido']) ."</td>
                <td>" . htmlspecialchars($item['dest_nombre'])." - ".htmlspecialchars($item['dest_apellido']) . "</td>
                <td>" . htmlspecialchars($item['direccion_destino']) . "</td>
                <td>" . htmlspecialchars($item['descrip_contenido']) . "</td>
                <td>" . htmlspecialchars($item['peso_total']) . "</td>
                <td>" . htmlspecialchars($item['estatus']) . "</td>
                <td>" . htmlspecialchars($item['fecha']) . "</td>
            </tr>";
        }
        $html .= "  </tbody>
                </table>
            </main>
        </body>
        </html>";
        $nombreDoc = "EnvioReporte";
                break;
                case 'pago':
                break;
            }
        
            //$html = 'PDF generado';

            return $this->GenerarReporte($html,$nombreDoc);
        }    
        
        private function GenerarReporte($html,string $nombreDoc){
            $this->objDompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
            $this->objDompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $this->objDompdf->render();

            // Output the generated PDF to Browser
            $this->objDompdf->stream($nombreDoc); 

        }

    
    }
?>