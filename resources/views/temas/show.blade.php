@extends('layouts.main')

@section('content')
<h1>{{ $tema->concepto }}</h1>
<div class="container">
    @foreach ($grupos as $grupo)
        <div class="row">
            <div class="col-12" style="font-weight:bold; background-color:gray; color:white; padding:2px;">
                Grupo: {{ $grupo->concepto }}
            </div>
        </div>
        @foreach ($grupo->groupedThemes as $subtema)
            <div class="row">
                <div class="col-8">
                    {{ $subtema->concepto }}
                </div>
                <div class="col-4">
                    {{ $subtema->tema_type }}
                </div>
            </div>
        @endforeach
    @endforeach
</div>
@endsection
