<?php
if ($_SESSION['rol_virtual'] != 1 && $_SESSION['rol_virtual'] !=2) {
    $lc->forzar_cierre_sesion_controlador();
    exit();
}
