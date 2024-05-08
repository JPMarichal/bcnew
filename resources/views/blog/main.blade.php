@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <h1>{{ $title }}</h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($types as $key => $name)
                <div class="col">
                    <a href="{{ route('blog.filter', $key) }}">
                        <h3>{{ $name }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
