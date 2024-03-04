@extends('layouts.main')

@section('title', 'Cerrar Sesión')

@section('content')
<div class="text-center mt-3">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning">Cerrar Sesión</button>
    </form>
</div>
@endsection
