<?php

class DetallesAudioVisual
{

    private $audiovisual;
    private $favorito;
    private $verMasTarde;


    function __construct(AudioVisual $audioVisual, bool $favorito)
    {
        $this->audiovisual = $audioVisual;
        $this->favorito = $favorito;
        $this->verMasTarde = false;
    }

    /**
     * Get the value of audiovisual
     */
    public function getAudiovisual()
    {
        return $this->audiovisual;
    }

    /**
     * Set the value of audiovisual
     *
     * @return  self
     */
    public function setAudiovisual($audiovisual)
    {
        $this->audiovisual = $audiovisual;

        return $this;
    }

    /**
     * Get the value of favorito
     */
    public function esFavorito()
    {
        return $this->favorito;
    }

    /**
     * Set the value of favorito
     *
     * @return  self
     */
    public function setFavorito($favorito)
    {
        $this->favorito = $favorito;

        return $this;
    }

    public function verMasTarde(){
        return $this->verMasTarde;
    }

    public function setVerMasTarde($verMasTarde){
        $this->verMasTarde = $verMasTarde;
    }

    static function ponerFavoritoPelicula($favoritos, $audiovisuales){
        $log = Logger::defaultLog();
		$resultados = array();
		foreach($audiovisuales as $audio){
            $audio = FactoryAudioVisual::getAudiovisual($audio["Type"], $audio);
            $encontrado = false;
			
			foreach($favoritos as $favorito){
              
                if($favorito->getIdVideo() === $audio->getIdVideo()){
                    $encontrado = true;
                    $detalle = new DetallesAudioVisual($audio, true);
					$resultados[$favorito->getIdVideo()] = $detalle;
					break;	
				}	
			}

			if(!$encontrado){
                $detalle = new DetallesAudioVisual($audio, false);
				$resultados[$audio->getIdVideo()] = $detalle;
            }
        }
        
        return $resultados;

    }
    
    static function getFavoritoByIdVideo($detalles,$idVideo) : DetallesAudioVisual{
        
        return $detalles[$idVideo];
    }

}
