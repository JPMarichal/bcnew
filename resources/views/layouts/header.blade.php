<head>
    @include('components.header.meta')
    @include('components.header.robots')
    @include('components.header.favicons')
    @include('components.header.social')
    @include('components.header.fonts')
    @include('components.header.styles')
    @include('components.header.wysiwyg')
    @include('components.header.bladewindui')
    @include('components.header.scripts')

    @yield('schema_markup') 
</head>
