<nav class="avatar-menu dropdown" style="text-align: center;">
    @auth
        <a href="#" class="d-inline-block" id="avatarMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="position: relative; text-decoration: none;">
            <div class="grid mr-2">
                @if(Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}" alt="Avatar del usuario" class="user-avatar rounded-circle" style="width: 40px; height: 40px;">
                @else
                    <i class="fas fa-user-circle fa-2x"></i> <!-- Icono de FontAwesome como avatar por defecto -->
                @endif
                <span class="d-none d-md-inline-block text-center text-sm" style="font-family: 'Figtree', sans-serif;">
                    {{ Auth::user()->given_name }}
                </span>
            </div>
        </a>
        <ul class="dropdown-menu" aria-labelledby="avatarMenuDropdown" style="position: absolute; left: 50%; transform: translateX(-50%);">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit"></i> Perfil</a></li>
            <li><a class="dropdown-item" href="#"><i class="fas fa-bell"></i> Suscripción</a></li>
            @if(Auth::user()->hasRole('Administrador'))
                <li><a class="dropdown-item" href="#"><i class="fas fa-tools"></i> Panel de Control</a></li>
            @endif
            @if(Auth::user()->hasAnyRole(['Administrador','Autor', 'Editor', 'Colaborador']))
                <li><a class="dropdown-item" href="#"><i class="fas fa-pencil-alt"></i> Colaboraciones</a></li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
                </form>
            </li>
        </ul>
    @else
        <a href="{{ route('login') }}" class="nav-link"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
    @endauth
</nav>
