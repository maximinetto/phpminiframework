<?php

    require_once __DIR__ . "/../serie.php";
    require_once __DIR__ . "/../episodio.php";
    
    final class AudioVisualConverter{
        private static $client;
        private $url;
        private $apikey;
        private $response;

        public function __construct()
        {
            
            $this->url = URL_OMDB;
            $this->apikey = API_KEY;
            self::$client = new GuzzleHttp\Client();
        
        }

        public function __invoke(string $idVideo)
        {
   
            $response = self::$client->get($this->url, [
                'query' => ['i' => $idVideo, 'apikey' => $this->apikey]
            ]);
            $json_response = json_decode($response->getBody(), true);        
            $this->response = $json_response;
            
            $tipo = $json_response['Type'];
            $audiovisual = self::getClase($tipo);
            return $audiovisual;
        }

        private function getClase($tipo){
            if($tipo == "movie")
                return new Film($this->response);
            else if($tipo == "series")
                return new Serie($this->response);

            return new Episode($this->response);   
        }
    }