{{-- resources/views/escrituras/versiculos/admin/comentarios.blade.php --}}

@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Comentarios a {{ $versiculo->referencia }} (admin)</h1>
            @livewire('escrituras.comentarios-admin', ['versiculoId' => $versiculo->id])
</div>
@endsection
