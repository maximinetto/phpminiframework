<?php

class URL {

    function getUrl($controlador="usuario",
    $accion="listado",$params=array()){
        $url= URL_BASE.$controlador."/".$accion."/";
        foreach ($params as $key => $value) {
            $url.=$value."/";
        }
        return $url;
    }

}