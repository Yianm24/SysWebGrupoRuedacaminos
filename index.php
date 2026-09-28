<?php
    session_start();
    
    require 'vendor/autoload.php';

    use App\Controller\FrontController;

    $frontController = new FrontController();

?>