<div>
    <style>
        .news-section {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            background-color: azure;
        }
        .news-item {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .news-item:last-child {
            border-bottom: none;
        }
        .news-link {
            text-decoration: none;
            color: black;
            transition: color 0.3s ease;
        }
        .news-link:hover {
            color: #007bff; /* O el color que prefieras para el hover */
        }
        .news-thumbnail {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            transition: transform 0.3s ease;
        }
        .news-thumbnail:hover {
            transform: scale(1.1);
        }
    </style>

    <div class="row">
        <div class="col-md-6 col-sm-12 news-section">
            <h4 style="border-bottom:1px solid orange;">Últimas noticias</h4>
            @foreach ($latestNews as $news)
                <div class="d-flex align-items-center news-item">
                <a href="{{ route('noticias.show', $news->slug) }}" class="news-link">
                    <img src="{{ $news->featured_image }}" alt="thumbnail" class="news-thumbnail">
                </a>
                    <a href="{{ route('noticias.show', $news->slug) }}" class="news-link">{{ $news->title }}</a>
                </div>
            @endforeach
        </div>
        <div class="col-md-6 col-sm-12 news-section">
            <h4 style="border-bottom:1px solid orange;">Tal vez te interese</h4>
            @foreach ($randomNews as $news)
                <div class="d-flex align-items-center news-item">
                    <img src="{{ $news->featured_image }}" alt="thumbnail" class="news-thumbnail">
                    <a href="{{ route('noticias.show', $news->slug) }}" class="news-link">{{ $news->title }}</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
