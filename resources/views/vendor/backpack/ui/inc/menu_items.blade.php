{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-users" :link="backpack_url('user')" />
<x-backpack::menu-item title="Newsitems" icon="la la-newspaper" :link="backpack_url('newsitem')" />
<x-backpack::menu-item title="Newsposts" icon="la la-newspaper" :link="backpack_url('newspost')" />
<x-backpack::menu-item title="Volúmenes" icon="la la-book" :link="backpack_url('escrituras/volumen')" />
<x-backpack::menu-item title="Partes" icon="la la-book" :link="backpack_url('escrituras/parte')" />