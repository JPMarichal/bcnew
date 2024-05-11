@extends('boletin.layouts.newsletter')

@section('content')
    @include('boletin.components.editorial'),
    @include('boletin.components.dailyPassage')
    @include('boletin.components.dailyQuote')
    @include('boletin.components.recommendedArticles')
    @include('boletin.components.newsSection')
@endsection
