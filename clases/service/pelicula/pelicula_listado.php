<?php

require_once "clases/repository/pelicula/ver_repository.php";

class PeliculaListado {

    private $verRepository;

    public function __construct($params) {
        $this->verRepository = new VerRepository($params);
    }


    public function getPeliculaVerMasTarde(){
        $data = $this->verRepository->listarPorId();
        if(!isset($data["tipo"])){
            return;
        }

        $idPelicula = $this->verRepository->getIdPelicula();
        $converter = new AudioVisualConverter();
        return $converter($idPelicula);
    
    }

    public function peliculasVerMasTardeUsuario(){
        
        $data = $this->verRepository->listarPorIdUsuario();
        $audiovisuales = array(); 
        foreach($data as $ver){
            $log = Logger::defaultLog();
            $log->putLog(json_encode($ver));
            $idPelicula = $ver["imdbID"];
            $converter = new AudioVisualConverter();
            $audiovisual = $converter($idPelicula);
            $audiovisuales[] = $audiovisual;
        }

        return $audiovisuales;
    }
   
}