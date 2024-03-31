@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Gestionar Taxonomía</h1>
    @livewire('taxonomies.manage-taxonomy', ['taxonomyId' => $taxonomyId ?? null])
</div>
@endsection
