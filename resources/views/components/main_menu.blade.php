<nav class="navbar navbar-expand-sm navbar-light mt-0 mx-auto menu-principal">
  <div class="container-fluid">
    <!-- Botón hamburguesa para pantallas pequeñas -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Contenido del menú -->
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('noticias') || request()->is('noticias/*') ? 'active' : '' }}" href="/noticias">Noticias de la Iglesia</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('articulos') || request()->is('articulos/*') ? 'active' : '' }}" href="#">Artículos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('estudio-de-las-escrituras') || request()->is('estudio-de-las-escrituras/*') ? 'active' : '' }}" href="#">Estudio de las Escrituras</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('glosarios') || request()->is('glosarios/*') ? 'active' : '' }}" href="#">Glosarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('site.contact') ? 'active' : '' }}" href="{{route('site.contact')}}">Contacto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('site.about') ? 'active' : '' }}" href="{{route('site.about')}}">Acerca de</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
