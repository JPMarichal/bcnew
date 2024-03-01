<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Noticias</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Listado de Noticias</h1>
        <ul class="list-unstyled">
            @foreach ($news as $newsItem)
                <li class="mb-2">
                    <a href="{{ route('noticias.show', $newsItem->slug) }}">{{ $newsItem->title }}</a>
                </li>
            @endforeach
        </ul>
        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{ $news->links() }}
        </div>
    </div>
    
    <!-- Bootstrap JS and dependencies (Popper) -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
