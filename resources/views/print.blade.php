<!DOCTYPE html>
<html>
<head>
    <title>{{ $post->title }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
        }
    </style>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
</body>
</html>
