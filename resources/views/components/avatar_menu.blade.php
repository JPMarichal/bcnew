<div class="avatar-menu dropdown" style="text-align: center;">
    @auth
        <a href="#" class="d-inline-block" id="avatarMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="position: relative;text-decoration:none;">
           <div class="grid mr-2">
                @if(Auth::user()->avatar)
                    <div class="flex" style="width:100%;text-align:center">
                        <img src="{{ Auth::user()->avatar }}" alt="avatar" class="user-avatar rounded-circle" style="width: 40px; height: 40px;">
                    </div>
                @else
                    <i class="fas fa-user-circle fa-2x"></i> <!-- Icono de FontAwesome como avatar por defecto -->
                @endif
                <div class="d-none d-md-inline-block text-center text-sm" style="font-family:figtree;">
                    {{ Auth::user()->given_name }}
                </div>
            </div>
        </a>
        <ul class="dropdown-menu" aria-labelledby="avatarMenuDropdown" style="position: absolute; left: 50%; transform: translateX(-50%);">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
            <li><a class="dropdown-item" href="#">Suscripción</a></li>
            @if(Auth::user()->hasRole('Administrador'))
                <li><a class="dropdown-item" href="#">Panel de Control</a></li>
            @endif
            @if(Auth::user()->hasAnyRole(['Administrador','Autor', 'Editor', 'Colaborador']))
                <li><a class="dropdown-item" href="#">Colaboraciones</a></li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}">Cerrar Sesión</a></li>
        </ul>
    @else
        <a href="{{ route('login') }}" class="nav-link">Iniciar sesión</a>
    @endauth
</div>
