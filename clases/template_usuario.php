<?php

require_once "clases/template.php";
require_once "clases/helpers/url.php";

class TemplateUser
{
    private static $tpl;
    private static $url;

    protected function __construct()
    {
 
    }

    public static function getInstance()
    {

        self::$tpl = Template::getInstance();
        self::$url = new URL();

        self::$tpl->asignar("nombre", Session::get("usuario_nombre"));
        self::$tpl->asignar("foto", Session::get("foto"));
        self::$tpl->asignar(
            "usuario_nuevo",
            self::$url->getUrl("usuario", "nuevo")
        );
        self::$tpl->asignar(
            "usuario_editar",
            self::$url->getUrl("usuario", "editar")
        );

        return self::$tpl;
    }
}
