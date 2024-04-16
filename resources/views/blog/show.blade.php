@extends('layouts.main')
@section('robots', 'index, follow')

@section('title', $post->title)
@section('description', $post->excerpt)
@section('featured_image', $post->featuredImageUrl())
@section('published_time', \Carbon\Carbon::parse($post->publish_date)->toIso8601String())
@section('modified_time', \Carbon\Carbon::parse($post->updated_at)->toIso8601String())
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
        "headline": "{{ $post->title }}",
        "image": [
            "{{ $post->featuredImageUrl() }}"
        ],
        "datePublished": "{{ \Carbon\Carbon::parse($post->publish_date)->toIso8601String() }}",
        "dateModified": "{{ \Carbon\Carbon::parse($post->updated_at)->toIso8601String() }}",
        "author": {
            "@type": "Person",
            "name": "Juan Pablo Marichal"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Biblicomentarios",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('android-chrome-512x512.png') }}"
            }
        },
        "description": "{{ $post->excerpt }}"
    }
</script>
@endsection

@section('content')
    <style>
        .featuredImage {
            background-image: url('{{ $post->featuredImageUrl() }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 600px;
            margin: 15px auto;
        }

        .featuredH1 {
            color: white;
            text-align: center;
            font-size: 40px;
            background-color: black;
            opacity: 0.9;
            padding: 1%;
            margin-top: 260px;
        }
    </style>
    <article class="container mt-5">
        <div class="p-1 mt-0 mb-0 border rounded bg-light small row">
            <div class="col-11">
                <a href="{{ route('blog.index') }}">
                    <i class="fa fa-arrow-left"></i> Artículos
                </a> |
                <a href="javascript:history.back();">
                    Atrás
                </a>
            </div>
            <div class="col-1 text-end" style="color:#aaa">
                {{$post->id}}
            </div>
        </div>

        <!-- Imagen destacada -->
        @if ($post->featuredImageUrl())
            <header class="featuredImage text-center bg-light border rounded" style="max-height: 400px; overflow: hidden;">

                <h1 class="featuredH1">{{ $post->title }}</h1>
            </header>
        @else
            <h1>{{ $post->title }}</h1>
        @endif
        @if ($post->excerpt)
            <div class="p-2 mb-2 text-center border rounded" style="background-color:#ffffb9">{{ $post->excerpt }}</div>
        @endif
        <section id="blog_content" class="border rounded p-2 mb-3">
            {!! $post->content !!}
        </section>
    </article>

    <livewire:comment-section :post="$post" />

@endsection
