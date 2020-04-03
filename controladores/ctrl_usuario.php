<?php
require "clases/clase_base.php";
require "clases/usuario.php";
require_once('clases/template_usuario.php');
require_once('clases/session.php');
require_once('clases/auth.php');
require_once('clases/helpers/utils.php');


class ControladorUsuario extends ControladorIndex
{

	function listado($params = array())
	{
		
		$buscar = "";
		$titulo = "Listado";
		$mensaje = "";
		if (!empty($params)) {
			if ($params[0] == "borrar") {
				$usuario = new Usuario();
				$idABorrar = $params[1];
				if ($usuario->borrar($idABorrar)) {
					//Redirigir al listado
					//header('Location: index.php');exit;
					$this->redirect("usuario", "listado");
				} else {
					//Mostrar error
					$usr = $usuario->obtenerPorId($idABorrar);
					//$mensaje="Error!! No se pudo borrar el usuario  <b>".$usr->getNombre()." ".$usr->getApellido()."</b>";
					$mensaje = "ERROR. No existe el usuario";
					$usuarios = $usuario->getListado();
				}
			} else {
				$usuario = new Usuario();
				$usuarios = $usuario->getListado();
			}
		} else {
			$usuario = new Usuario();
			$usuarios = $usuario->getListado();
		}
		
		$tpl = TemplateUser::getInstance();
		//Llamar a la vista
		$datos = array(
			'usuarios' => $usuarios,
			'buscar' => $buscar,
			'titulo' => $titulo,
			'mensaje' => $mensaje,
		);
		
		$tpl->mostrar('usuarios_listado', $datos);
	}
	
	function buscar($params = array())
	{
		
		$buscar = "";
		$titulo = "Listado";
		$mensaje = "";
		$usuarios = array();
		if (isset($_POST["buscar"]) && $_POST["buscar"] != "") {
			$titulo = "Buscando..";
			$usuario = new Usuario();
			$buscar = $_POST["buscar"];
			$usuarios = $usuario->getBusqueda($buscar);
		} else {
			$usuario = new Usuario();
			$usuarios = $usuario->getListado();
		}
		
		//Llamar a la vista
		//require_once("vistas/usuarios_listado.php");
		
		$tpl = TemplateUser::getInstance();
		$datos = array(
			'usuarios' => $usuarios,
			'buscar' => $buscar,
			'titulo' => $titulo,
			'mensaje' => $mensaje,
		);


		$tpl->mostrar('usuarios_listado', $datos);
	}

	function nuevo()
	{
		
		$tpl = TemplateUser::getInstance();
		$mensaje = "";
		if (isset($_POST["nombre"])) {
			$fotoValida = false;
			$rutaFoto = "";
			if (isset($_FILES['foto'])) {
				$chequeoFoto = uploadImagen($_FILES['foto']);
				$fotoValida = $chequeoFoto["res"];
				$mensaje = $chequeoFoto["error"];
				$rutaFoto = $chequeoFoto["ruta"];
			}
			if ($fotoValida) {
				$usr = new Usuario();
				$usr->setNombre($_POST["nombre"]);
				$usr->setApellido($_POST["apellido"]);
				$usr->setCI($_POST["ci"]);
				$usr->setEdad($_POST["edad"]);
				$usr->setEmail($_POST["email"]);
				$usr->setFoto($rutaFoto);
				if ($usr->agregar()) {
					$this->redirect("usuario", "listado");
					exit;
				} else {
					$mensaje = "Error! No se pudo agregar el usuario";
				}
			}
		}

		$tpl->asignar('titulo', "Nuevo Usuario");
		$tpl->asignar('buscar', "");
		$tpl->asignar('mensaje', $mensaje);
		$tpl->mostrar('usuarios_nuevo', array());
	}

	function editar()
	{
		Session::init();
		$tpl = TemplateUser::getInstance();
		$mensaje = "";
		if (isset($_POST["nombre"])) {
			$fotoValida = false;
			$rutaFoto = "";
			if (isset($_FILES['foto'])) {
				$chequeoFoto = uploadImagen($_FILES['foto']);
				$fotoValida = $chequeoFoto["res"];
				$mensaje = $chequeoFoto["error"];
				$rutaFoto = $chequeoFoto["ruta"];
			}
			if ($fotoValida) {
				$usr = new Usuario();
				$usr->setNombre($_POST["nombre"]);
				$usr->setPassword($_POST["pass"]);
				$usr->setApellido($_POST["apellido"]);
				$usr->setCI($_POST["ci"]);
				$usr->setEdad($_POST["edad"]);
				$usr->setEmail($_POST["email"]);
				$usr->setFoto($rutaFoto);
				if ($usr->editar()) {
					Session::set("foto", $rutaFoto);
					$this->redirect("usuario", "listado");
					exit;
				} else {
					$mensaje = "Error! No se pudo editar el usuario";
				}
			}
		}


		$usuario = new Usuario();
		$usuario = $usuario->getUsuarioByID(Session::get("usuario_id"));
		$data = objectToArray($usuario);
		$tpl->asignar('titulo', "Editar Usuario");
		$tpl->asignar('buscar', "");
		$tpl->asignar('mensaje', $mensaje);
		$tpl->mostrar('usuarios_editar', $data);
	
	}

	function login()
	{

		$mensaje = "";
		session_start();

		if (isset($_POST["email"])) {
			$usr = new Usuario();
			
			$email = $_POST["email"];
			$pass = sha1($_POST["password"]);
			
			if ($usr->login($email, $pass)) {
				
				$this->redirect("usuario", "listado");
				exit;
			} else {
				$mensaje = "USUARIO Y/O PASSWORD INCORRECTO";
			}
		}
		
		$tpl = TemplateUser::getInstance();
		$tpl->asignar('titulo', "Nuevo Usuario");
		$tpl->asignar('loginUrl', "");
		$tpl->asignar('buscar', "");
		$tpl->asignar('mensaje', $mensaje);
		$tpl->mostrar('usuarios_login', array());
	}

	function logout()
	{
		$usr = new Usuario();
		$usr->logout();
		$this->redirect("usuario", "login");
	}

	function favoritos()
	{
		$usuario = new Usuario();
		$usuarios = $usuario->getListado();
		echo json_encode($usuarios);
	}
}
