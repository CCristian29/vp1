<?php

require_once "mainModel.php";

class pqrsModelo extends mainModel
{
    protected static function agregar_pqrs_model($pqrs)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO pqrs (nombre, correo, tipo, descripcion, archivo) VALUES (:Nombre,:Correo,:Tipo,:Descripcion, :Archivo)"); 
        $sql->bindParam(":Nombre", $pqrs['Nombre']);
        $sql->bindParam(":Correo", $pqrs['Correo']);
        $sql->bindParam(":Tipo", $pqrs['Tipo']);
        $sql->bindParam(":Descripcion", $pqrs['Descripcion']);
        $sql->bindParam(":Archivo", $pqrs['Archivo']);
        $sql->execute();

        return $sql;
    }
    public static function cambiar_estado_pqrs_model($idpqrs, $nuevo_estado)
    {
        try {
            $sql = mainModel::conectar()->prepare("UPDATE pqrs SET Estado = :nuevo_estado WHERE idPqrs = :idPqrs");
            $sql->bindParam(":nuevo_estado", $nuevo_estado);
            $sql->bindParam(":idPqrs", $idpqrs);
            $sql->execute();

            return $sql;
        } catch (PDOException $e) {
            error_log("Error al cambiar el estado de PQRS: " . $e->getMessage());
            return false;
        }
    }
}    