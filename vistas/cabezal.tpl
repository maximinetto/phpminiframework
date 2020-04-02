<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{$proyecto}</a>
            <ul class="nav navbar-nav">
                <li>
                    <a href="{$url_base}pelicula/listado">Peliculas</a>
                </li>
                <li>
                    <a href="{$url_base}usuario/listado">Usuarios</a>
                </li>
            </ul>
        </div>
        <div id="navbar">
            <form class="navbar-form navbar-right" method="post" action="{$url_base}usuario/buscar/">
                <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar..." value='{$buscar}'>
                <input type="submit" value="Buscar" class="form-control btn btn-primary">
            </form>
            <ul class="nav navbar-nav navbar-right">
                {if $nombre != ""}

                <li class="dropdown">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {if $foto != ""}
                        <img src="{$foto}" alt="fotoperfil" class="profile-photo" />
                        {/if}
                        {$nombre}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{$usuario_editar}">Ver Perfil</a></li>

                        <li role="separator" class="divider"></li>
                        <li><a href="{$url_logout}">Cerrar Sesión</a></li>
                    </ul>
                </li>
                {/if}
            </ul>
        </div>
    </div>
</nav>