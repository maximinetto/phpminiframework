<?php

require "clases/clase_base.php";
require "clases/pelicula.php";
require "clases/service/audiovisual_listado.php";
require "clases/helpers/audiovisual_converter.php";
require_once('clases/template.php');
require_once('clases/session.php');
require_once('clases/auth.php');
require_once 'vendor/autoload.php';
require_once 'config/log.php';

$log = new Logger("log.txt");
$log->setTimestamp("D M d 'y h.i A");

$log->putLog("Iniciando clase controlador película");

class ControladorPelicula extends ControladorIndex
{
	private $listado, $log;


	function __construct()
	{
		$this->listado = new AudioVisualListado();
		$this->log = new Logger("log.txt");
		$this->log->setTimestamp("D M d 'y h.i A");
	
	}

	function listado($params = array())
	{

		Auth::estaLogueado();

		$buscar = "";
		$titulo = "Listado";
		$mensaje = "";
		$peliculas = array();
		
		if (!empty($params)) {
			if ($params[0] == "borrar") {
				$pelicula = new Film();
				$idABorrar = $params[1];
				if ($pelicula->borrar($idABorrar)) {
					//Redirigir al listado
					//header('Location: index.php');exit;
					$this->redirect("usuario", "listado");
				} else {
					//Mostrar error
					$usr = $pelicula->obtenerPorId($idABorrar);
					//$mensaje="Error!! No se pudo borrar el usuario  <b>".$usr->getNombre()." ".$usr->getApellido()."</b>";
					$mensaje = "ERROR. No existe el usuario";
					$peliculas = $pelicula->getListado();
				}
			} else {
				$peliculas = $this->listado->busquedaPorDefecto();
			}
		} else {
			$peliculas = $this->listado->busquedaPorDefecto();
		}

		//Llamar a la vista
		$tpl = Template::getInstance();
		$datos = array(
			'peliculas' => $peliculas,
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
		if (isset($_POST["buscar"]) && $_POST["buscar"] != "") {
			$titulo = "Buscando..";
			$buscar = urlencode($_POST['buscar']);
			$this->log->putLog($buscar);
			$peliculas = $this->listado->buscarPorNombre($buscar);
		} else {
			$peliculas = $this->listado->busquedaPorDefecto();
			$this->log->putLog("Busqueda por defecto");
		}

		//Llamar a la vista
		//require_once("vistas/peliculas_listado.php");

		$this->log->getLog();

		$tpl = Template::getInstance();
		$datos = array(
			'peliculas' => $peliculas,
			'buscar' => $buscar,
			'titulo' => $titulo,
			'mensaje' => $mensaje,
		);


		$tpl->asignar('pelicula_nuevo', $this->getUrl("usuario", "nuevo"));
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

	function favoritos()
	{
		$pelicula = new Film();
		$peliculas = $pelicula->getListado();
		echo json_encode($peliculas);
	}
}
