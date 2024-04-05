@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Blog</h1>
    @foreach($posts as $post)
        <div class="post">
            <h2><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
            <p>{{ $post->excerpt }}</p>
        </div>
    @endforeach
    {{ $posts->links() }}
</div>
@endsection
