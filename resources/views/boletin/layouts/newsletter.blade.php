<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boletín de Biblicomentarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!-- Incluye otros recursos de CSS o JS si es necesario -->
</head>
<body>
<style 
    type="text/css">
    h3{
    color:green;
    background-color:#f2ffe3;
    border-bottom:1px solid green;
    }

    h4{
    color:purple;
    }
    </style>
    <div class="container mt-4">
        <header>
            <h1>Boletín de los Biblicomentarios</h1>
        </header>
        @yield('content')
        <footer class="text-center mt-4">
            <p>Gracias por leer nuestro boletín. Visita <a href="https://bcnew.top">nuestro sitio</a> para más información.</p>
        </footer>
    </div>
</body>
</html>
