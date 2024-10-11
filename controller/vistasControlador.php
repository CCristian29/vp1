<?php

require_once "./model/vistasModelo.php";

class vistasControlador extends vistasModelo{
    /*--- controlador obtener plantilla---*/
    public function obtener_plantilla_controlador()
    {
        return require_once "./views/plantilla.php";
    }

    /*--- controlador obtener vistas---*/
    public function obtener_vistas_controlador($modulo,$idioma)
    {
        if (isset($_GET['views'])) {
            $ruta = explode("/", $_GET['views']);
            if ($modulo=="dashboard") {
                if (isset($ruta[1]) && ($ruta[1]!="")) {
                    $vista = $ruta[1];
                } else {
                    $vista="";
                }
            } else {
                $vista = $ruta[0];
            }
            if ($vista!="") {
                $respuesta=vistasModelo::obtener_vistas_modelo($vista, $modulo,$idioma);
            } else {
                if ($modulo=="dashboard") {
                    $respuesta="login";
                } else {
                    $respuesta ="./views/contenidos/".$idioma."/web-login.php";
                }
            }
        } else {
            if ($modulo=="dashboard") {
                $respuesta="login";
            } else {
                $respuesta="./views/contenidos/".$idioma."/web-index.php"; 
            }
        }
        return $respuesta;
    }
}
