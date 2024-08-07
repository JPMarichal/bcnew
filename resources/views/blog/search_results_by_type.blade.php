@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        @livewire('blog-search')
        <h1>{{ $title }}</h1>
        <div class="border rounded text-center mb-3">
            <p>{{ $posts->total() }} resultados encontrados para "{{ $term }}" en esta categoría.</p>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($posts as $post)
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
                        <div class="card-footer row">
                            <div class="col-3" style="color: #ccc;">
                                <span class="p-1"
                                    style="border-radius:50%;background-color:white;border:0px solid #ccc;width:40px;height:40px;font-size:small" title="Identificador único del artículo">
                                    {{ $post->id }}
                                </span>
                                <span class="ml-2">
                                    @if (str_contains($post->featuredImageUrl(), 'b-cdn'))
                                        <i class="fas fa-circle-check" style="color: green;" title="La imagen principal ha sido validada"></i>
                                    @else
                                        @livewire('upload-image', ['postId' => $post->id])
                                    @endif
                                </span>
                            </div>
                            <div class="col-9 text-end">
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary btn-sm" title="Disfruta de este artículo y expresa tu opinión">
                                    <i class="fas fa-arrow-circle-right"></i> Leer ahora
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
