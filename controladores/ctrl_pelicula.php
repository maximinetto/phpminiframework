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
		
		Session::set("detalles", $detalles);

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

		
		$detalles = DetallesAudioVisual::ponerFavoritoPelicula($favoritos, $peliculas);

		Session::set("detalles", $detalles);

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

	function agregarFavorito($params = array()){
		$this->log->putLog("peticion ajax agregar");
		$audiovisual = $this->getAudioVisual($params);
		$usuario = self::getUsuario();
		$this->log->putLog($usuario);
		if(isset($audiovisual)){
			$res = $this->guardarFavorito($usuario, $audiovisual);
		}
		else{
			$res = $this->respuestaError();
		}

		self::respuestaServidor($res);
	}

	function eliminarFavorito($params = array()){
		$this->log->putLog("peticion ajax eliminar favorito");
		$audiovisual = self::getAudioVisual($params);
		$usuario = self::getUsuario();
		if(isset($audiovisual)){
			$res = self::borrarFavorito($usuario, $audiovisual);
		}
		else{
			$res = self::respuestaError();
		}

		self::respuestaServidor($res);
	}

	private function getUsuario(){
		$usuario = new Usuario();
		$idUsuario = Session::get("usuario_id");
		$this->log->putLog("Id usuario: " . $idUsuario);
		$usuario = $usuario->getUsuarioByID($idUsuario);
		return $usuario;
	}

	private function favoritos(){
		
		$usuario = self::getUsuario();
		$favoritos = UsuarioServiceFactory::createService()
					  ->listadoFavoritosPorUsuario($usuario);
	    return $favoritos;
	}

	private function getAudioVisual($params){
		$idVideo = $params[0];
		$converter = new AudioVisualConverter();
		return $converter($idVideo);
	}

	private function respuestaServidor($res){
		header('Content-Type: application/json');
		$res = json_encode($res, true);
		$this->log->putLog("Json: $res");
		echo $res;
	}

	private function respuestaError(){
		return array(
			"ok" => false, 
		"message" => "Hubo un problema");

	}

	private function guardarFavorito($usuario, $audiovisual){
		$log = Logger::defaultLog();
		$log->putLog($usuario);
		$log->putLog($audiovisual);
		UsuarioServiceFactory::createService()->salvarFavorito($usuario, array($audiovisual));
		return array(
				"ok" => true, 
			"message" => "Se ha guardado exitosamente");

	}

	private function borrarFavorito($usuario, $audiovisual){
		UsuarioServiceFactory::createService()->borrarFavorito($usuario, $audiovisual);
		return array(
			"ok" => true, 
		"message" => "Se ha guardado exitosamente");
	}

	
}
