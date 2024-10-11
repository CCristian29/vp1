<?php
$peticionAjax = true;
require_once "../config/App.php";
include "../views/inc/session-start.php";

if (isset($_POST['modulo_producto'])) {
    require_once "../controller/productoControlador.php";
    $ins_producto = new productoControlador();
    // Manejo de agregar producto

    if($_POST['modulo_producto']=="actualizar"){
        echo $ins_producto->actualizar_datos_producto_controlador();
    }
    if($_POST['modulo_producto']=="agregar"){
        echo $ins_producto->agregar_producto_controlador();
    }
    if($_POST['modulo_producto']=="eliminar"){
        echo $ins_producto->eliminar_producto_controlador();
    }
} else {
    session_destroy();
    header("location:" . SERVERURL . "singin/");
}


