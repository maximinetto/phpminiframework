<?php

require_once("audiovisual.php");

class Serie extends AudioVisual
{

    public function __construct($array)
    {
        parent::__construct($array);
    }

    public function __construct1($idSerie, $title, $year, $img)
    {
        parent::__construct($idSerie, $title, $year, $img);
    }

    public function tipo()
    {
        return "Serie";
    }
}
