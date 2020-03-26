<?php

require_once "clases/service/usuario/usuario_listado.php";
require_once "clases/service/usuario/usuario_salvar.php";

class UsuarioService {
    
    private $usuarioSalvar;
    private $usuarioListado;

    function __construct()
    {
        $this->usuarioSalvar = new UsuarioSalvar();
        $this->usuarioListado = new UsuarioListado();
    }

    public function salvarFavorito(Usuario $usuario, $favoritos){
        $this->usuarioSalvar->salvar($usuario, $favoritos);
    }

    public function listarFavoritos(){
        return $this->usuarioListado->getListadoFavoritos();
    }

    public function listadoFavoritosPorUsuario(Usuario $usuario){
        return $this->usuarioListado->getListadoFavoritosPorUsuario($usuario);
    }

    public function borrarFavorito(Usuario $usuario, $favorito){
        return $this->usuarioSalvar->borrarFavorito($usuario, $favorito);
    }
}