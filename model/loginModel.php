<?php

require_once "mainModel.php";

class loginModelo extends mainModel
{

    /*--------- Modelo iniciar sesion ---------*/
    protected static function iniciar_sesion_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE corELeUsu=:Correo AND conSegUsu=:Clave");
        $sql->bindParam(":Correo", $datos['Correo']);
        $sql->bindParam(":Clave", $datos['Clave']);
        $sql->execute();
        return $sql;
    }
    protected static function iniciar_sesion_cliente_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE corELeUsu=:Correo AND conSegUsu=:Clave");
        $sql->bindParam(":Correo", $datos['Correo']);
        $sql->bindParam(":Clave", $datos['Clave']);
        $sql->execute();
        return $sql;
    }
}
