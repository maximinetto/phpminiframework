<?php

require "clases/clase_base.php";
require "clases/pelicula.php";
require "clases/detalle_audiovisual.php";
require "clases/service/audiovisual_listado.php";
require "clases/service/usuario/usuario_fabrica.php";
require "clases/service/pelicula/pelicula_fabrica.php";
require "clases/helpers/audiovisual_converter.php";
require "clases/helpers/accion_favorito.php";
require "clases/helpers/agregar_favorito.php";
require "clases/helpers/quitar_favorito.php";

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
		$errorMensage = "";

		try {
			$peliculas = $this->listado->busquedaPorDefecto();
		} catch (ErrorException $error) {
			$errorMensage = $error->getMessage();
		}

		$favoritos = $this->favoritos();


		$detalles = DetallesAudioVisual::ponerFavoritoPelicula($favoritos, $peliculas);


		//Llamar a la vista
		$tpl = Template::getInstance();
		$datos = array(
			'detalles' => $detalles,
			'buscar' => $buscar,
			'titulo' => $titulo,
			'mensaje' => $mensaje,
			'error' => $errorMensage
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
		$errorMensage = "";

		if (isset($_POST["buscar"]) && $_POST["buscar"] != "") {
			$titulo = "Buscando..";
			$buscar = urlencode($_POST['buscar']);
			$this->log->putLog($buscar);
			try {
				$peliculas = $this->listado->buscarPorNombre($buscar);
				$favoritos = $this->favoritos();
				$this->log->putLog("Busqueda con criterios");
			} catch (ErrorException $error) {
				$errorMensage = $error->getMessage();
			}
		} else {
			try {
				$peliculas = $this->listado->busquedaPorDefecto();
				$favoritos = $this->favoritos();
				$this->log->putLog("Busqueda por defecto");
			} catch (ErrorException $error) {
				$errorMensage = $error->getMessage();
			}
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
			'error' => $errorMensage
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

	function agregar_lista()
	{
		$mensaje = "";
		Session::init();

		$this->log->putLog("Agregar a más tarde");

		if (isset($_POST["id_pelicula"])) {
			
			
			$params =
			array(
				"imdbID" => $_POST["id_pelicula"],
				"id_usuario" => Session::get('usuario_id')
			);
			
			$audiovisual = $this->getAudioVisual($params["imdbID"]);

			$params["tipo"] = $audiovisual->tipo();

			$para_ver = PeliculaServiceFactory::createService($params);

			if ($para_ver->agregarMasTarde()) {
				$res = 1;
				$mensaje = "Agregado ok";
			} else {
				$mensaje = "Error! No se pudo agregar la película";
				$res = 0;
			}

		} else {
			
			$mensaje = "error, no se envío película";
			$res = -1;
		
		}

		echo json_encode(array("res" => $res, "msj" => $mensaje));
		exit;
	}

	function agregarFavorito($params = array())
	{
		Session::init();
		$accionFavorito = new AgregarFavorito();
		$this->log->putLog("peticion ajax agregar");
		$this->accionFavorito($params, $accionFavorito);
	}

	function eliminarFavorito($params = array())
	{
		Session::init();
		$this->log->putLog("peticion ajax eliminar favorito");
		$accionFavorito = new BorrarFavorito();
		$this->accionFavorito($params, $accionFavorito);
	}

	private function accionFavorito($params, AccionFavorito $accion)
	{
		$audiovisual = $this->getAudioVisual($params[0]);
		$usuario = self::getUsuario();
		$this->log->putLog($usuario);
		if (isset($audiovisual)) {
			$res = $accion->aplicar($usuario, $audiovisual);
		} else {
			$res = $this->respuestaError();
		}

		self::respuestaServidor($res);
	}

	private function getUsuario()
	{
		$usuario = new Usuario();
		$idUsuario = Session::get("usuario_id");
		$this->log->putLog("Id usuario: " . $idUsuario);
		$usuario = $usuario->getUsuarioByID($idUsuario);
		return $usuario;
	}

	private function favoritos()
	{

		$usuario = self::getUsuario();
		$favoritos = UsuarioServiceFactory::createService()
			->listadoFavoritosPorUsuario($usuario);
		return $favoritos;
	}

	private function getAudioVisual($idVideo)
	{
		$converter = new AudioVisualConverter();
		return $converter($idVideo);
	}

	private function respuestaServidor($res)
	{
		$res = json_encode($res);
		$this->log->putLog("Json: $res");
		echo $res;
	}

	private function respuestaError()
	{
		return array(
			"ok" => false,
			"message" => "Hubo un problema"
		);
	}

	private function guardarFavorito($usuario, $audiovisual)
	{
		$log = Logger::defaultLog();
		$log->putLog($usuario);
		$log->putLog($audiovisual);
		UsuarioServiceFactory::createService()->salvarFavorito($usuario, array($audiovisual));
		return array(
			"ok" => true,
			"message" => "Se ha guardado exitosamente"
		);
	}

	private function borrarFavorito($usuario, $audiovisual)
	{
		UsuarioServiceFactory::createService()->borrarFavorito($usuario, $audiovisual);
		return array(
			"ok" => true,
			"message" => "Se ha borrado exitosamente"
		);
	}
}
