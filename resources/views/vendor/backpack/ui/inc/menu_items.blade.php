{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-users" :link="backpack_url('user')" />

<x-backpack::menu-dropdown title="Escrituras" icon="la la-book">
    <x-backpack::menu-dropdown-item title="Volúmenes" icon="la la-book" :link="backpack_url('escrituras/volumen')" />
    <x-backpack::menu-dropdown-item title="Divisiones" icon="la la-book" :link="backpack_url('escrituras/division')" />
    <x-backpack::menu-dropdown-item title="Libros" icon="la la-book" :link="backpack_url('escrituras/libro')" />
    <x-backpack::menu-dropdown-item title="Partes" icon="la la-book" :link="backpack_url('escrituras/parte')" />
    <x-backpack::menu-dropdown-item title="Capitulos" icon="la la-book" :link="backpack_url('escrituras/capitulo')" />
    <x-backpack::menu-dropdown-item title="Pericopas" icon="la la-book" :link="backpack_url('escrituras/pericopa')" />
    <x-backpack::menu-dropdown-item title="Versiculos" icon="la la-book" :link="backpack_url('escrituras/versiculo')" />
    <x-backpack::menu-dropdown-item title="Comentarios" icon="la la-book" :link="backpack_url('escrituras/versiculocomentario')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Noticias" icon="la la-newspaper">
    <x-backpack::menu-dropdown-item title="Newsitems" icon="la la-newspaper" :link="backpack_url('newsitem')" />
    <x-backpack::menu-dropdown-item title="Newsposts" icon="la la-newspaper" :link="backpack_url('newspost')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-dropdown title="Taxonomías" icon="fas fa-book">
<x-backpack::menu-dropdown-item title="Taxonomies" icon="la la-book" :link="backpack_url('taxonomy')" />
</x-backpack::menu-dropdown>
