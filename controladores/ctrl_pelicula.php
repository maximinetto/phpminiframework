<?php

require "clases/clase_base.php";
require "clases/pelicula.php";
require "clases/detalle_audiovisual.php";
require "clases/service/audiovisual_listado.php";
require "clases/service/usuario/usuario_fabrica.php";
require "clases/helpers/audiovisual_converter.php";
require_once('clases/template.php');
require_once('clases/session.php');
require_once('clases/auth.php');
require_once 'vendor/autoload.php';
require_once 'config/log.php';


class ControladorPelicula extends ControladorIndex
{
	private $listado, $log;


	function __construct()
	{
		$this->listado = new AudioVisualListado();
		$this->log = Logger::defaultLog();
	}

	function listado($params = array())
	{
		Auth::estaLogueado();

		$buscar = "";
		$titulo = "Listado";
		$mensaje = "";
		$peliculas = array();
		$favoritos = array();
		
		if (!empty($params)) {
			
		} else {
			$peliculas = $this->listado->busquedaPorDefecto();
			$favoritos = $this->favoritos();
		}

		$detalles = DetallesAudioVisual::ponerFavoritoPelicula($favoritos, $peliculas);

		//Llamar a la vista
		$tpl = Template::getInstance();
		$datos = array(
			'detalles' => $detalles,
			'buscar' => $buscar,
			'titulo' => $titulo,
			'mensaje' => $mensaje,
		);

		$tpl->mostrar('peliculas_listado', $datos);
	}

	function buscar($params = array())
	{

		Auth::estaLogueado();

		$this->log->putLog("Entra en buscar");
		$buscar = "";
		$titulo = "Listado";
		$mensaje = "";
		$peliculas = array();
		$favoritos = array();

		if (isset($_POST["buscar"]) && $_POST["buscar"] != "") {
			$titulo = "Buscando..";
			$buscar = urlencode($_POST['buscar']);
			$this->log->putLog($buscar);
			$peliculas = $this->listado->buscarPorNombre($buscar);
			$favoritos = $this->favoritos();
		} else {
			$peliculas = $this->listado->busquedaPorDefecto();
			$favoritos = $this->favoritos();
			$this->log->putLog("Busqueda por defecto");
		}

		//Llamar a la vista
		//require_once("vistas/peliculas_listado.php");

		$this->log->getLog();

		$detalles = DetallesAudioVisual::ponerFavoritoPelicula($favoritos, $peliculas);

		//Llamar a la vista
		$tpl = Template::getInstance();
		$datos = array(
			'detalles' => $detalles,
			'buscar' => $buscar,
			'titulo' => $titulo,
			'mensaje' => $mensaje,
		);

		$tpl->mostrar('peliculas_listado', $datos);
	}

	function detalles($params = array())
	{
		$idVideo = $params[0];
		$this->log->putLog($idVideo);
		$converter = new AudioVisualConverter();
		$audiovisual = $converter($idVideo);
		
		$tpl = Template::getInstance();
		$datos = array(
			'buscar' => '',
			'titulo' => $audiovisual->getTitle(),
			'mensaje' => '',
			'audioVisual' => $audiovisual
		);

		$tpl->mostrar('detalles/pelicula_detalle', $datos);
	}

	function cambiarFavorito($params = array()){
		var_dump($params);
		$json = json_encode($params);
		echo $json;
	}


	private function favoritos(){
		
		$usuario = new Usuario();
		$idUsuario = Session::get("usuario_id");
		$usuario = $usuario->getUsuarioByID($idUsuario);
		$favoritos = UsuarioServiceFactory::createService()
					  ->listadoFavoritosPorUsuario($usuario);
	    return $favoritos;
	}

	
}
