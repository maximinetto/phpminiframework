<?php

require "clases/clase_base.php";
require "clases/pelicula.php";
require "clases/service/audiovisual_listado.php";
require_once('clases/template.php');
require_once('clases/session.php');
require_once('clases/auth.php');
require_once 'vendor/autoload.php';


class ControladorPelicula extends ControladorIndex
{
	private $listado;

	function __construct()
	{
		$this->listado = new AudioVisualListado();
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
				$this->listado->busquedaPorDefecto();
			}
		} else {
			$this->listado->busquedaPorDefecto();
		}

		//Llamar a la vista
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

	function buscar($params = array())
	{

		Auth::estaLogueado();

		$buscar = "";
		$titulo = "Listado";
		$mensaje = "";
		$peliculas = array();
		if (isset($_POST["buscar"]) && $_POST["buscar"] != "") {
			$titulo = "Buscando..";
			$buscar = urlencode($_POST['buscar']);

			$peliculas = $this->listado->buscarPorNombre($buscar);
		} else {
			$this->listado->busquedaPorDefecto();
		}

		//Llamar a la vista
		//require_once("vistas/peliculas_listado.php");

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

	function getFilmById(string $idVideo)
	{

		$converter = new AudioVisualConverter();
		$audiovisual = $converter();
		return $audiovisual;
	}

	function favoritos()
	{
		$pelicula = new Film();
		$peliculas = $pelicula->getListado();
		echo json_encode($peliculas);
	}
}
