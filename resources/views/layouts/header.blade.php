<head>
    @include('components.header.meta')
    @include('components.header.robots')
    @include('components.header.favicons')
    @include('components.header.social')
    @include('components.header.fonts')
    @include('components.header.styles')
    @include('components.header.scripts')

    @yield('schema_markup') 
</head>
