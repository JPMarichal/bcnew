<style>
    .news-item {
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 4px;
        padding: 5px;
        display: flex;
        align-items: flex-start; /* Cambiado de center a flex-start */
    }
    .news-item img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }
    .news-item .title {
        font-weight: bold;
    }
    .news-item .description {
        font-size: small;
    }
</style>

<h3>Últimas noticias</h3>
@foreach($news as $new)
    <div class="news-item">
        @if(!empty($new->featured_image))
            <a href="http://bcnew.top/noticias/{{ $new->slug }}" target="_blank">
                <img src="{{ $new->featured_image }}" alt="{{ $new->title }}">
            </a>
        @endif
        <div>
            <a class="title" href="http://bcnew.top/noticias/{{ $new->slug }}" target="_blank">
                {{ $new->title }}
            </a>
            @if(!empty($new->description))
                <p class="description">{{ $new->description }}</p>
            @endif
        </div>
    </div>
@endforeach