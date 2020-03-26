<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="{$url_base}">
    <meta charset="utf-8">
    
    <title>{$proyecto}</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap4.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="fonts/css/all.min.css" rel="stylesheet" />
    <link href="css/dashboard.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="css/main.css" />
    
  </head>

  <body>
    {include file="header.tpl"}
    <div class="container-fluid">
      <div class="row">
       
        <div class="col-sm-12 col-md-12 main">
          <h1 class="primary">Peliculas</h1>
          <h4>{$titulo}</h4>
          {if $mensaje!=""}
            <div class="alert alert-danger" role="alert">{$mensaje}</div>
          {/if}

          <div class="row">
            {foreach from=$detalles item=detalle key=key}
            <div class="col">
              <div 
                class="card film" 
                id={$detalle->getAudiovisual()->getIdVideo()} 
                style="width: 18rem;"
              >
                <img 
                  src={$detalle->getAudiovisual()->getPoster()} 
                  class="card-img-top" 
                  alt="pelicula"
                   onclick="window.location ='{$url_base}pelicula/detalles/{$detalle->getAudiovisual()->getIdVideo()}'"
                />
                <div class="card-body">
                  <h5 class="card-title">
                    {$detalle->getAudiovisual()->getYear()} - {$detalle->getAudiovisual()->getTitle()}
                  </h5>
                  <div class="row">
                    <button class="favorito"> 
                      {if $detalle->esFavorito()}
                        <i 
                          class="fas fa-star" 
                          id="eliminarFavorito-{$detalle->getAudiovisual()->getIdVideo()}"></i>    
                      {else}
                        <i 
                          class="far fa-star"
                          id="agregarFavorito-{$detalle->getAudiovisual()->getIdVideo()}" 
                        ></i>
                      {/if}
                    </button>
                  </div>
                </div>
              </div>
            </div>
            {/foreach}
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/bootstrap4.min.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    
  </body>
</html>
