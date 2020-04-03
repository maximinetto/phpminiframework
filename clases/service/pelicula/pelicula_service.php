<?php

require_once "clases/service/pelicula/pelicula_listado.php";
require_once "clases/service/pelicula/pelicula_salvar.php";

class PeliculaService {
    
    private $peliculaSalvar;
    private $peliculaListado;

    function __construct($params)
    {
        $this->peliculaSalvar = new PeliculaSalvar($params);
        $this->peliculaListado = new PeliculaListado($params);
    }

    public function verSiHayMasTarde(){
        return $this->peliculaListado->getPeliculaVerMasTarde();
    }

    public function peliculasMasTardeUsuario(){
        return $this->peliculaListado->peliculasVerMasTardeUsuario();
    }

    public function agregarMasTarde(){
        return $this->peliculaSalvar->agregarMasTarde();
    }

    public function borrarVerMasTarde(){
        return $this->peliculaSalvar->borrarVerMasTarde();
    }


   
}