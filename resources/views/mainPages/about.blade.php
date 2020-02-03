@extends('layout.layout')

@php
    $title = 'О нас';
@endphp

@section('title')
    @include('layout.layoutsChunk.titlePage')
@endsection

@section('content')
    <div class="col-md-9 contacts">
       <h2 class="alert alert-info">Страница о нас</h2>
    </div>
@endsection