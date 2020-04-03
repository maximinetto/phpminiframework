<?php

class AgregarFavorito implements AccionFavorito{

    function aplicar($usuario, $audiovisual){
        $log = Logger::defaultLog();
		$log->putLog($usuario);
		$log->putLog($audiovisual);
		UsuarioServiceFactory::createService()->salvarFavorito($usuario, array($audiovisual));
		return array(
				"ok" => true, 
			"message" => "Se ha guardado exitosamente");
    }

}