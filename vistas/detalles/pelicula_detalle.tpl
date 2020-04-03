<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="{$url_base}">
    <meta charset="utf-8">
    
    <title>{$proyecto}</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap4.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    
    <link rel="stylesheet" href="css/main.css" />
    
  </head>

  <body>
    {include file="header.tpl"}
    <main class="container-fluid">
        <div class="row m-5">
            <h2>Título: {$audioVisual->getTitle()}</h2>                
        </div>

        <div class="row m-3"> 
            <img src={$audioVisual->getPoster()} alt="foto"/>
        </div>
        <div>
            <h4>Director: </h4> <span> {$audioVisual->getDirector()} </span>
        </div>
        <div>
            <h4>Actores: </h4> <span> {$audioVisual->getActors()} </span>
        </div>
        <div>
            <h4>Duración: </h4> <span> {$audioVisual->getRuntime()} </span>
        </div>
        <div>
            <h4>Año: </h4> <span> {$audioVisual->getYear()} </span>
        </div>
        <div class="rating">
            <h4>Ratings: </h4> 
            <div >
                
                {foreach $audioVisual->getRankings() as $rating} 
                    <p>   
                        {$rating.Source} 
                        <span> {$rating.Value}</span> 
                    </p>
               {/foreach}
            </div>
        </div>
        <div>
            <h4>Género: </h4> <span> {$audioVisual->getGenre()} </span>
        </div>
        <div>
            <h4>Tipo: </h4> <span> {$audioVisual->tipo()} </span>
        </div>
    </main>
    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="js/bootstrap4.min.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" scr="js/main.js"></script>
    
  </body>
</html>