<?php

require_once "clases/repository/pelicula/ver_repository.php";

class PeliculaListado {

    private $verRepository;

    public function __construct($params) {
        $this->verRepository = new VerRepository($params);
    }

   
}