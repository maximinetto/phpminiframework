<?php

class BorrarFavorito implements AccionFavorito{
    
    function aplicar($usuario, $audiovisual){
        $log = Logger::defaultLog();
		$log->putLog($usuario);
		$log->putLog($audiovisual);
		UsuarioServiceFactory::createService()->borrarFavorito($usuario, $audiovisual);
		return array(
			"ok" => true, 
		"message" => "Se ha borrado exitosamente");
    }
}