<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Título dinámico -->
<title>@yield('title', 'Biblicomentarios.com')</title>
<!-- Descripción dinámica -->
<meta name="description" content="@yield('description', 'Descripción predeterminada de tu sitio')">
<link rel="icon" href="{{ asset('icons/favicon.png') }}" type="image/png">
