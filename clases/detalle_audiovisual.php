<?php

class DetallesAudioVisual
{

    private $audiovisual;
    private $favorito;

    function __construct(AudioVisual $audioVisual, bool $favorito)
    {
        $this->audiovisual = $audioVisual;
        $this->favorito = $favorito;
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

    static function ponerFavoritoPelicula($favoritos, $audiovisuales){

		$resultados = array();
		foreach($audiovisuales as $audio){
            $audio = FactoryAudioVisual::getAudiovisual($audio["Type"], $audio);
            $encontrado = false;
			
			foreach($favoritos as $favorito){
              
                if($favorito->getIdVideo() === $audio->getIdVideo()){
                    $encontrado = true;
                    $detalle = new DetallesAudioVisual($audio, true);
					$resultados[] = $detalle;
					break;	
				}	
			}

			if(!$encontrado){
                $detalle = new DetallesAudioVisual($audio, false);
				$resultados[] = $detalle;
            }
        }
        
        return $resultados;

    }
    
    static function getFavoritoByIdVideo($detalles,$idVideo){
        
        foreach ($detalles as $detalle) {
            if($detalle->getAudiovisual()->getIdVideo() === $idVideo){
                return $detalle->getAudiovisual();
            }
        }
    }

}
