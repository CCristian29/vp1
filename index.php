<?php 

    require_once "./config/App.php";
    require_once "./controller/vistasControlador.php";

    $plantilla = new vistasControlador();
    $plantilla->obtener_plantilla_controlador();