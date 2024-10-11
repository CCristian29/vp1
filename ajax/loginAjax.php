<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['correo']) && isset($_POST['token'])) {
    require_once "../controller/loginControlador.php";
    $ins_login = new loginControlador();
    echo $ins_login->cerrar_sesion_usuario_controlador();
} 
else {
    session_start(['name' => 'virtual']);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "singin/");
    exit();
}
