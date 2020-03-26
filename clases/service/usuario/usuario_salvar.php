<?php

require_once("clases/usuario.php");
require_once "clases/repository/usuario/user_repository.php";

class UsuarioSalvar{

    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function salvar(Usuario $usuario, $favoritos){
        $this->userRepository->guardar($usuario->getid(), $favoritos);
    }

    public function borrarFavorito(Usuario $usuario, $favorito){
        return $this->userRepository->borrarFavorito($usuario->getid(), $favorito);
    }

}