<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $newsItem->title }}</title>
</head>
<body>
    <h1>{{ $newsItem->title }}</h1>
    <!-- Mostrar el contenido de la noticia, que es HTML -->
    <div>
        {!! $newsItem->content !!}
    </div>
    <!-- Enlace para regresar al listado principal de noticias -->
    <a href="{{ route('noticias.index') }}">Regresar al listado de noticias</a>
</body>
</html>
