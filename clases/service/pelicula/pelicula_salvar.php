<?php


class PeliculaSalvar {
    
    private $verRepository;

    public function __construct($params) {
        $this->verRepository = new VerRepository($params);
    }

    public function agregarMasTarde(){
        return $this->verRepository->agregar();
    }

    public function borrarVerMasTarde(){
        return $this->verRepository->borrarMasTarde();
    }
    

}