<?php

require_once("audiovisual.php");

class Serie extends AudioVisual
{

    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }

    public function __construct1($array)
    {
        parent::__construct($array);
    }

    public function __construct2($idFilm, $title, $year, $img)
    {
        $array = array($idFilm, $title, $year, $img);
        parent::__construct($array);
    }

    public function tipo()
    {
        return "Serie";
    }
}
