<?php

    require_once("audiovisual.php");

    class Film extends AudioVisual{

        public function __construct()
        {
            $array = array('');
            parent::__construct($array);
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



        public function tipo(){
            return "Película";
        }
        
    }

?>