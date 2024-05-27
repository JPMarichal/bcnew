@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        @livewire('blog-search')
        <h1>{{ $title }}</h1>
        <div class="border rounded text-center mb-3">
            <p>{{ $posts->sum(fn($group) => $group->count()) }} resultados encontrados para "{{ $term }}".</p>
        </div>

        @foreach ($postTypes as $postType => $postTypeName)
            @if (isset($posts[$postType]) && $posts[$postType]->isNotEmpty())
                <h3>{{ $postTypeName }}</h3>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($posts[$postType]->take(5) as $post)
                        <div class="col">
                            <div class="card h-100">
                                <div class="m-2 p-2 border rounded" style="height:100px;">
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        <img src="{{ $post->featuredImageUrl() }}" class="card-img-top"
                                            style="height: 100px; object-fit: cover;" alt="{{ $post->title }}">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a class="text-success" href="{{ route('blog.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    @if ($post->excerpt)
                                        <div class="card-text small text-muted border rounded p-2">
                                            {{ $post->excerpt }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($posts[$postType]->count() > 5)
                    <div class="mt-2">
                        <a href="{{ route('blog.searchResultsByType', ['type' => $postType, 'term' => $term]) }}" class="btn btn-link">Ver todos los resultados</a>
                    </div>
                @endif
            @endif
        @endforeach
    </div>
@endsection
