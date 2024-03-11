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
        <li class="nav-item">
          <a class="nav-link" href="#">Estudio de las Escrituras</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Glosarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('site.contact')}}">Contacto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('site.about')}}">Acerca de</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
