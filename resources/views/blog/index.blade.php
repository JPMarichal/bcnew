@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($posts as $post)
            <div class="col">
                <div class="card h-100">
                    <div class="m-2 p-2 border rounded" style="height:100px;">
                    <!-- Asume que $post->image_url es la URL de la imagen del post -->
                    <a href="{{ route('blog.show', $post->slug) }}">
                        <img src="{{ $post->featuredImageUrl() }}" class="card-img-top" alt="{{ $post->title }}">
                    </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h5>
                        <p class="card-text text-small">{{ $post->excerpt }}</p>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-arrow-circle-right"></i> Leer ahora
                        </a>
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
