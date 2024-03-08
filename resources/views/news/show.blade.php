@extends('layouts.main')
@section('robots', 'index, follow')

@section('title', $newsItem->title)
@section('description', $newsItem->description)
@section('featured_image', $newsItem->featured_image)
@section('published_time', \Carbon\Carbon::parse($newsItem->pub_date)->toIso8601String())
@section('modified_time', \Carbon\Carbon::parse($newsItem->updated_at)->toIso8601String())
@section('author', 'Juan Pablo Marichal')
@section('type', 'article')
@section('twitter_author', 'JPMarichal')

@section('schema_markup')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ url()->current() }}"
  },
  "headline": "{{ $newsItem->title }}",
  "image": [
    "{{ $newsItem->featured_image }}"
  ],
  "datePublished": "{{ \Carbon\Carbon::parse($newsItem->pub_date)->toIso8601String() }}",
  "dateModified": "{{ \Carbon\Carbon::parse($newsItem->updated_at)->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "Juan Pablo Marichal"
  },
  "publisher": {
    "@type": "Organization",
    "name": "BcNew"
    // Aquí se omitió el "logo"
  },
  "description": "{{ $newsItem->description }}"
}
</script>
@endsection

@section('content')
<style>
    .news-image {
        max-width: 45%;
        border-radius: 20px;
        float: right;
        margin-left: 10px;
    }

    @media (max-width: 768px) {
        .news-image {
            max-width: 100%;
            float: none;
            margin: 0 auto 20px;
            display: block;
        }
    }
</style>

<div class="container mt-5">
    <h1>{{ $newsItem->title }}</h1>

    <x-news.meta-bar :newsItem="$newsItem" />

    <div class="row">
        <div class="col-md-1">
            <x-social-share-bar />
        </div>

        <div class="col-md-11">
            <img src="{{ $newsItem->featured_image }}" class="news-image" alt="{{ $newsItem->title }}" title="{{ $newsItem->title }}">
            {!! $newsItem->content !!}
            @livewire('news-suggestion')
        </div>
    </div>

    <a href="{{ route('noticias.index') }}" class="btn btn-primary mt-3">
        <i class="fas fa-arrow-left"></i> Regresar al listado
    </a>
</div>
@endsection
