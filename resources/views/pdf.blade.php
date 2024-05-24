<!DOCTYPE html>
<html>
head>
    <title>{{ $post->title }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
        }
    </style>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <p>{!! $post->content !!}</p>
    <div style="background-color:gray;color:white;font-weight:bold" class="text-center p-3" >
    Cortesía
    </div>
</body>
</html>
