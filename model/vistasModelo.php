<?php

class vistasModelo{
    /*--- modelo obtener vistas ---*/
    protected static function obtener_vistas_modelo($vistas,$modulo,$idioma){
        $listaBlanca=["login","perfil","index","product","new-product","home","new-user","ver-producto",
        "lista-clientes", "lista-administradores", "pqrs-usuario", "ver-pqrs", "perfil-admin","productos",
        "carrito","empresa","actualizar-usuario", "recuperar-contraseña-email", "actualizar-clientes",
        "actualizar-datos-cliente", "actualizar-producto", "category-new", "category-list", "category-search", "category-update","details", "confirma-datos", "restablecerClave","formRestablecerClave","verificarCodigo"];
        if (in_array($vistas, $listaBlanca)){
            if (is_file("./views/contenidos/".$idioma."/".$modulo."-"."$vistas".".php")) {
                $contenido="./views/contenidos/".$idioma."/".$modulo."-"."$vistas".".php";

            } else {
                $contenido = "404";
            }
        }elseif ($vistas=="singin") {
            $contenido="singin";
        } elseif ($vistas == "registro") {
            $contenido = "registro";
        } else{
            $contenido = "404";
        }
        return $contenido;
    }
}
