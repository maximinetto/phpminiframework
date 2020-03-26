<?php

require_once("clases/usuario.php");

require_once "clases/service/usuario/usuario_service.php";

class UsuarioServiceFactory{

    static function createService()
    {
        return new UsuarioService();
    }

}