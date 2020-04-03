<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Framework</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{$url_base}usuario/listado">Usuarios <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{$url_base}pelicula/listado">Peliculas</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="post" action="{$url_base}pelicula/buscar/">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" id="buscar" name="buscar">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
        {if $nombre != ""}
        <div class="dropdown">
            <a class="btn btn-secondary" type="button" id="iniciarSesion" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {if $foto != ""}
                <img src="{$foto}" alt="fotoperfil" class="profile-photo" />
                {/if}
                {$nombre}
            </a>
            <div class="dropdown-menu" aria-labelledby="iniciarSesion">
                <a class="dropdown-item" href="{$usuario_editar}">Ver Perfil</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{$url_logout}">Cerrar Sessión</a>
            </div>
        </div>
        {/if}
    </div>
</nav>