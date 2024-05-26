<!DOCTYPE html>
<html>

<head>
    <title>{{ $post->title }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Helvetica', sans-serif;
        }

        h1 {
            font-weight: bold;
        }

        h2 {
            color: green;
            font-weight: bold;
        }

        h3 {
            color: purple;
            font-weight: bold;
        }

        blockquote {
            margin-left: 40px;
            margin-right: 40px;
            background-color: #ddd;
            padding: 10px;
            border-left: 3px solid gray;
        }
    </style>
</head>

<body>
    <article class="container mt-5 border rounded p-3">
        <h1>{{ $post->title }}</h1>
        <p>{!! $post->content !!}</p>
    </article>
</body>

</html>
