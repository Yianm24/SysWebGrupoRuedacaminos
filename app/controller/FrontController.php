<?php

    namespace App\Controller;

    class FrontController {

        private $dir;
        private $controller;        
        private $url;

        public function __construct() {

            if (isset($_REQUEST["url"])) {
                $this->url = $_REQUEST["url"];
                $this->dir = 'app/controller/';
                $this->controller = 'Controller.php';
                $this->getURL();
            } else {
                echo "<script>location='?url=dashboard'</script>";
            }
        }

        private function getURL() {
            if(file_exists($this->dir.$this->url.$this->controller)) {
                require_once($this->dir.$this->url.$this->controller);
            } else {
                echo "<h2>Error 404: Módulo no encontrado</h2>";
                echo "<p>El controlador para '{$this->url}' no existe.</p>";
                echo "<a href='?url=dashboard'>Volver al inicio</a>";
            }
        }

    }

?>
