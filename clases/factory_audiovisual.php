<?php

require_once('clases/pelicula.php');
require_once('clases/serie.php');
require_once('clases/episodio.php');

class FactoryAudioVisual{
    public static function getAudiovisual(String $tipo, $attributes){
        switch($tipo){
            case "movie":
            case "Pelicula":
                return new Film($attributes);
            break;
            
            case "Serie":
            case "series":    
                return new Serie($attributes);
            break;    
            
            case "Episodio":
            case "episodie":     
                return new Episode($attributes);
            break;
            
            default:
                throw new ErrorException("el tipo no especifica con ningún audiovisual");
        }
            
    }
}