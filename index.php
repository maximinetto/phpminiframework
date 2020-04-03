<?php
require "db/db.php";
require 'vendor/autoload.php';
require "controladores/ctrl_index.php";
require_once "clases/auth.php";
require_once('clases/template.php');

$log = Logger::defaultLog();

function isURLLogin(){
	$uri = $_SERVER['REQUEST_URI'];
	return $uri == URL_BASE . "usuario/login/";
}

$controlIndex=new ControladorIndex();



$ipAddress = IP_ADDRESS;
$url = "http://$ipAddress" . URL_BASE;

$tpl = Template::getInstance();
$tpl->asignar('url_base', $url);
$tpl->asignar('url_logout',$controlIndex->getUrl("usuario","logout"));
$tpl->asignar('proyecto',"Apps Web");

//Cargamos controladores y acciones

if(!isURLLogin()){
	
	$log->putLog("Entra: " );
	Auth::estaLogueado();
}

if(isset($_GET['url'])){

	$query = $_GET['url'];
	$request = explode('/', $query);
	$controller = (!empty($request[0])) ? $request[0] : 'usuario';
	$action = (!empty($request[1])) ? $request[1] : 'listado';
	$params=array();
	for ($i=2; $i <count($request) ; $i++) { 
		$params[]=$request[$i];
	}
	
}else{
	$controller="usuario";
	$action="listado";
	$params=array();
}



$controllerObj=$controlIndex->cargarControlador($controller);
$controlIndex->ejecutarAccion($controllerObj,$action,$params);

