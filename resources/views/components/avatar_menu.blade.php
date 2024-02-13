<div class="avatar-menu">
    @auth
        <img src="{{ Auth::user()->avatar }}" alt="avatar" class="user-avatar" id="avatarMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <ul class="dropdown-menu" aria-labelledby="avatarMenuDropdown">
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li><a class="dropdown-item" href="#">Suscripción</a></li>
            @if(Auth::user()->hasRole('admin'))
                <li><a class="dropdown-item" href="#">Panel de Control</a></li>
            @endif
            @if(Auth::user()->hasAnyRole(['author', 'editor', 'collaborator']))
                <li><a class="dropdown-item" href="#">Colaboraciones</a></li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Cerrar Sesión</a></li>
        </ul>
    @else
        <a href="{{ route('login') }}">Iniciar sesión</a>
    @endauth
</div>
