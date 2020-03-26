<?php

require_once "clases/usuario.php";
require_once "clases/repository/usuario/user_repository.php";

class UsuarioListado {

    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function getListadoFavoritos(){
        return $this->userRepository->getUsuariosFavoritos();
    }

    public function getListadoFavoritosPorUsuario(Usuario $user){
        return $this->userRepository->getUsuarioFavoritos($user->getid());
    }
}