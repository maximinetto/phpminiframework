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
    <div class="container-fluid">
      <div class="row">
       
        <div class="col-sm-12  col-md-12  main">
          <h1 class="primary">Peliculas</h1>
          <h4 >{$titulo}</h2>
          {if $mensaje!=""}
            <div class="alert alert-danger" role="alert">{$mensaje}</div>
          {/if}

          <div class="row">
            {foreach from=$peliculas item=audiovisual key=key}
            <div class="col">
              <div 
                class="card film" 
                id={$audiovisual["imdbID"]} 
                style="width: 18rem;"
                onclick="window.location ='{$url_base}pelicula/detalles/{$audiovisual['imdbID']}'">
                <img src={$audiovisual["Poster"]} class="card-img-top" alt="pelicula">
                <div class="card-body">
                  <h5 class="card-title">
                    {$audiovisual['Year']} - {$audiovisual['Title']}
                  </h5>
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
    <script src="js/bootstrap4.min.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" scr="js/main.js"></script>
    
  </body>
</html>
