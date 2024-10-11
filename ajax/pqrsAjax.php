<?php
$peticionAjax = true;
require_once "../controller/pqrsControlador.php";
require_once "../config/App.php";

session_start(['name' => 'virtual']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ins_pqrs = new pqrsControlador();

    if (isset($_POST['idpqrs'])) {
        echo $ins_pqrs->cambiar_estado_pqrs_controlador();
    } elseif (isset($_POST['Nombre']) && isset($_POST['Correo']) && isset($_POST['Tipo']) && isset($_POST['Descripcion'])) {
        echo $ins_pqrs->agregar_pqrs_controlador();
    } else {
        echo "Solicitud no válida.";
    }
} else {
    session_unset();
    session_destroy();
    header("location:" . SERVERURL . "singin/");
    exit();
}
?>

 