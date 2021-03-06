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

require_once('clases/template_usuario.php');
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
		Session::init();
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

		$detalles = self::getDetallesConVerMasTarde($favoritos, $peliculas);
			

		//Llamar a la vista
		$tpl = TemplateUser::getInstance();
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


		$detalles = self::getDetallesConVerMasTarde($favoritos, $peliculas);
			
		//Llamar a la vista
		$tpl = TemplateUser::getInstance();
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

		Session::init();

		$idVideo = $params[0];
		$this->log->putLog($idVideo);
		$params = array(
			"imdbID" => $idVideo,
			"id_usuario" => Session::get('usuario_id')
		);

		PeliculaServiceFactory::createService($params)->borrarVerMasTarde();

		$converter = new AudioVisualConverter();
		$audiovisual = $converter($idVideo);

		$tpl = TemplateUser::getInstance();
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
				$mensaje = "Se ha agregado a ver más tarde";
			} else {
				$mensaje = "Error! No se pudo agregar la película de ver más";
				$res = 0;
			}
		} else {

			$mensaje = "error, no se envío película";
			$res = -1;
		}

		echo json_encode(array("res" => $res, "mensaje" => $mensaje));
		exit;
	}

	function quitar_visto(){
		$mensaje = "";
		Session::init();

		$this->log->putLog("Quitar visto");

		if (isset($_POST["id_pelicula"])) {


			$params =
				array(
					"imdbID" => $_POST["id_pelicula"],
					"id_usuario" => Session::get('usuario_id')
				);

			$audiovisual = $this->getAudioVisual($params["imdbID"]);

			$params["tipo"] = $audiovisual->tipo();

			$para_ver = PeliculaServiceFactory::createService($params);

			if ($para_ver->borrarVerMasTarde()) {
				$res = 1;
				$mensaje = "Se ha borrado la película de ver más tarde";
			} else {
				$mensaje = "Error! No se pudo borrar la película de ver más tarde";
				$res = 0;
			}
		} else {

			$mensaje = "error, no se envío película";
			$res = -1;
		}

		echo json_encode(array("res" => $res, "mensaje" => $mensaje));
		exit;
	}

	function ver_peliculas_mas_tarde()
	{
		$mensaje = "";
		Session::init();

		$this->log->putLog("ver más tarde");

		$idUsuario = $_POST["id_usuario"];

		$this->log->putLog("ID_USUARIO: " . $idUsuario);
		$this->log->putLog("SESSION_ID: " . Session::get("usuario_id"));
		if (!(isset($idUsuario) && $idUsuario == Session::get("usuario_id"))) {
			$respuesta = json_encode(
				array(
					"mensaje" => "Error en la llamada",
					"ok" => false,
					"films" => []
				)
			);

			echo $respuesta;
			exit;
		}

		$params =
			array(
				"id_usuario" => Session::get('usuario_id')
			);

		$audiovisuales = PeliculaServiceFactory::createService($params)->peliculasMasTardeUsuario();

		$respuesta = json_encode(
			array(
				"mensaje" => "Se ha ejecutado correctamente",
				"ok" => true,
				"films" => $audiovisuales
			)
		);

		echo $respuesta;
		exit;
	}

	private function getDetallesConVerMasTarde($favoritos, $peliculas){
		$detalles = DetallesAudioVisual::ponerFavoritoPelicula($favoritos, $peliculas);
		$idUsuario = Session::get("usuario_id");
	    $peliculasMasTarde = PeliculaServiceFactory::createService(array("id_usuario" => $idUsuario))
			->peliculasMasTardeUsuario();
		
		foreach ($peliculasMasTarde as $p) {
			$idVideo = $p->getIdVideo();
			
			if(array_key_exists($idVideo, $detalles)){
				$detalle = $detalles[$idVideo];
				$detalle->setVerMasTarde(true);
				$detalles[$idVideo] = $detalle;
			}

		}

		return $detalles;
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
