<?php

class Episode extends AudioVisual{
    public function __construct($array)
    {
        parent::__construct($array);
    }

    public function __construct1($idEpisode, $title, $year, $img)
    {
        parent::__construct($idEpisode, $title, $year, $img);
    }

    public function tipo(){
        return "Episodio";
    }
}