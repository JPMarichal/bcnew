@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Gestionar términos de taxonomía</h1>
    @livewire('taxonomy-terms.taxonomy-terms-crud', ['taxonomyTermId' => $taxonomyTermId ?? null])
</div>
@endsection
