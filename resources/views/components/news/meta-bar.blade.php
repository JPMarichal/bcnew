<aside class="border border-secondary my-3 p-2" style="color: darkgrey;">
    <a href="{{ route('noticias.index') }}" class="text-dark" style="text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Todas las noticias
    </a>
    | 
    <span>
        <a href="{{ url('/noticias/' . \Carbon\Carbon::parse($newsItem->pub_date)->format('m') . '/' . \Carbon\Carbon::parse($newsItem->pub_date)->format('Y')) }}" class="text-dark" style="text-decoration: none;">
            {{ \Carbon\Carbon::parse($newsItem->pub_date)->isoFormat('D [de] MMMM [de] YYYY') }}
        </a>
    </span>
    | 
    <span>{{ $newsItem->country }}</span>
</div>
