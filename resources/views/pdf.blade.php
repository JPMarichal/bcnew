<!DOCTYPE html>
<html>
head>
<title>{{ $post->title }}</title>
<style>
    body {
        font-family: 'Helvetica', sans-serif;
    }

    .excerpt {
        background-color: lightyellow;
        border: orange 1px solid;
        border-radius: 20px;
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 5px;
    }

    h2 {
        color: green;
    }

    h3 {
        color: purple;
    }

    blockquote {
        background-color: #ccc;
        padding:5px;
    }
</style>
</head>

<body>
    <div style="background-color:gray;color:white;font-weight:bold;margin-bottom:10px;text-align:center;"
        class="text-center p-3">
        Artículos de los Biblicomentarios.com
    </div>
    <h1>{{ $post->title }}</h1>
    <div style="text-align:center">
        <img src="{{ $post->featuredImageUrl() }}" style="width:800px">
    </div>
    <div class="excerpt">{{ $post->excerpt }}</div>
    <p>{!! $post->content !!}</p>
    <div style="background-color:gray;color:white;font-weight:bold;margin-top:10px" class="text-center p-3">
        Cortesía de Juan Pablo Marichal Catalán - Prohibida su reproducción
    </div>
</body>

</html>
