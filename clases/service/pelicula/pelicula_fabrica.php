<?php

require_once "clases/service/pelicula/pelicula_service.php";

class PeliculaServiceFactory{

    static function createService($params)
    {
        return new PeliculaService($params);
    }

}