<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título dinámico -->
    <title>@yield('title', 'Biblicomentarios.com')</title>
    <!-- Descripción dinámica -->
    <meta name="description" content="@yield('description', 'Descripción predeterminada de tu sitio')">
    <link rel="icon" href="{{ asset('icons/favicon.png') }}" type="image/png">
    <!-- Fuentes principales -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=abeezee:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=alatsi:400,500,600&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" rel="stylesheet">
    <!-- Vite: tus estilos y JS personalizados -->
    @vite(['resources/js/app.js'])
</head>

