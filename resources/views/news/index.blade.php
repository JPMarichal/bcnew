<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Noticias</title>
</head>
<body>
    <h1>Listado de Noticias</h1>
    <ul>
        @foreach ($news as $newsItem)
            <li>
                <a href="{{ route('noticias.show', $newsItem->slug) }}">{{ $newsItem->title }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
