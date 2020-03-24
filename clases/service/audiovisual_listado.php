<?php 
    require_once("vendor/autoload.php");   
    use GuzzleHttp\Client;

    class AudioVisualListado {
        
        function buscarPorNombre($buscar){
            $client = new Client();
            $response = $client->get(URL_OMDB, [
                'query' => ['s' => $buscar, 'apikey' => API_KEY]
            ]);
            $json_response = json_decode($response->getBody(), true);
            if(isset($json_response["Error"])){
                return $json_response["Error"];
            }
            else{
                $films = $json_response["Search"];
                return $films;
            }
        }
        
        function busquedaPorDefecto(){
            $client = new Client();
            $response = $client->get(URL_OMDB, [
                'query' => ['s' => 'pulp', 'apikey' => API_KEY]
            ]);
            $json_response = json_decode($response->getBody(), true);
            if(isset($json_response["Error"])){
                return $json_response["Error"];
            }
            else{
                $films = $json_response["Search"];
                return $films;
            }
        }

    }
	
?>