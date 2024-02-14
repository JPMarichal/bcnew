<div class="main-header bg-white border" style="display: flex; justify-content: space-between; align-items: center;">
    <div class="logo">
        <!-- Logo, ajusta para ocupar espacio adecuado en móviles y más en pantallas grandes -->
        @include('components.logo')
    </div>

    <!-- Main Menu, se ajusta para usar el espacio disponible de manera efectiva -->
    <div class="main-menu flex-grow-1" style="display: flex; flex-grow: 1;">
        @include('components.main_menu')
    </div>

    <!-- Avatar Menu, ajusta para ocupar espacio restante en móviles -->
    <div class="avatar-menu" style="align-self: center;">
        @include('components.avatar_menu')
    </div>
</div>