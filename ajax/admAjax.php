<?php
$peticionAjax = true;
require_once "../config/App.php";
include "../views/inc/session-start.php";


if (isset($_POST['modulo_administrador'])){
    require_once "../controller/adminiControlador.php";
    $ins_administrador = new adminiControlador();

        /*----agregar un administrador-----*/
        if ($_POST['modulo_administrador']=="registrar") {
            echo $ins_administrador->agregar_administrador_controlador();
        }
        if ($_POST['modulo_administrador']=="actualizar") {
            echo $ins_administrador->actualizar_datos_admini_controlador();
        }
         // eliminar administrador
        if ($_POST['modulo_administrador']=="eliminar") {
            echo $ins_administrador->eliminar_admini_controlador();
        }
} else {
    session_destroy();
    header("location:" . SERVERURL . "singin/");
}


