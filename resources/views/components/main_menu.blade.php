<nav class="navbar navbar-expand-sm navbar-light mt-0 mx-auto">
  <div class="container-fluid">
    <!-- Botón hamburguesa para pantallas pequeñas -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Contenido del menú -->
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/noticias">Noticias de la Iglesia</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Artículos</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Estudio de las Escrituras</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Glosarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contacto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('site.about')}}">Acerca de</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
