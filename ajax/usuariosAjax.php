<?php
$peticionAjax = true;
require_once "../config/App.php";
include "../views/inc/session-start.php";


if (isset($_POST['modulo_cliente'])) {
    require_once "../controller/usuariosControlador.php";
    $ins_usuario = new usuariosControlador();

    /*----agregar un usuario-----*/
    if ($_POST['modulo_cliente'] == "agregar") {
        echo $ins_usuario->agregar_usuario_controlador();
    }
    /*--------- Eliminar un usuario ---------*/
    if ($_POST['modulo_cliente'] == "eliminar") {
        echo $ins_usuario->eliminar_usuario_controlador();
    }

    /*--------- Actualizar un usuario ---------*/
    if ($_POST['modulo_cliente'] == "actualizar") {
        echo $ins_usuario->actualizar_datos_cliente_controlador();
    }
    if (isset($_POST['modulo_cliente'])) {
        switch ($_POST['modulo_cliente']) {
            case "restablecer_clave":
                $ins_usuario->restablecer_clave_controlador();
                break;
            case "verificar_codigo":
                $ins_usuario->verificar_codigo_controlador();
                break;
            case "cambiar_clave":
                $ins_usuario->cambiar_clave_controlador();
                break;
            default:
                // Manejar otros casos si los hay
                break;
        }
    }
} else {
    session_destroy();
    header("location:" . SERVERURL . DASHBOARD);
    exit();
}
