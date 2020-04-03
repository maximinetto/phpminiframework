<?php
	define("DB_HOST", "localhost");
	define("DB_USR", "root");
	define("DB_PASS", "");
    define("DB_DB", "framework");
    

    define("URL_OMDB", 'http://www.omdbapi.com');
    define("API_KEY",'e9aefa8c');

	//define(DB_TYPE, "mysql");

	$template_config = 
    array(
        'template_dir' => 'vistas/',
        'compile_dir' => 'libs/smarty/templates_c/',
        'cache_dir' => 'libs/smarty/cache/',
        'config_dir' => 'libs/smarty/configs/',
        );
    define ("URL_BASE","/tip/framework/");
    define("IP_ADDRESS", "localhost");
?>