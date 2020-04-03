<?php
require_once "clases/session.php";
require_once "config/log.php";

class Auth extends ControladorIndex
{
    public  static function estaLogueado()
    {
        
    	Session::init();
        if (!isset($_SESSION['usuario_id'])) {
            Session::destroy();
            self::redirect("usuario","login");
            exit();
        }
    }

    
}?>