<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="{$url_base}">
    <meta charset="utf-8">
    
    <title>{$proyecto}</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/main.css" />
    
  </head>

  <body>
    {include file="cabezal.tpl"}
    <div class="container-fluid">
      <div class="row">
       
        <div class="col-sm-12  col-md-12  main">
          <h1 class="page-header">Peliculas</h1>
          <h2 class="sub-header">{$titulo} 
            <button id="agregar" 
              name="agregar" 
              class="btn 
              btn-success 
              pull-right" 
              onClick="window.location='{$pelicula_nuevo}'">
                Agregar
            </button>
          </h2>
          {if $mensaje!=""}
            <div class="alert alert-danger" role="alert">{$mensaje}</div>
          {/if}
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Edad</th>
                  <th>Ci</th>
                  <th>Email</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                {foreach from=$usuarios item=persona}
                  <tr>
                    <td>{$persona->getNombre()|upper}</td>
                    <td>{$persona->getApellido()}</td>
                    <td>{$persona->getEdad()}</td>
                    <td>{$persona->getCI()}</td>
                    <td>{$persona->getEmail()}</td>
                    <td>
                      <input type="button" value="Borrar" class="btn btn-danger" onClick="window.location='{$url_base}usuario/listado/borrar/{$persona->getId()}/'"/>
                     
                      
                    </td>
                  </tr>
                {/foreach}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
    <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" scr="js/main.js"></script>
    
  </body>
</html>
