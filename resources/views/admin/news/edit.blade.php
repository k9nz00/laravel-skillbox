@php
/** @var App\Models\News newsItem */
@endphp

@extends('layouts.adminMasterLayout')

@section('navBar')
    @parent
@endsection

@section('content')
    <div class="col-md-9 blog-main">

        @include('layouts.layoutsChunk.errorsForm')

        <h3>Редактирование новости {{$newsItem->title}}</h3>
        <form action="{{route('admin.news.update', $newsItem->slug)}}" method="post">
            @csrf
            @method('PUT')
            @include('admin.news.chunks.formNews', ['newsItem' => $newsItem])

            <button type="submit" class="btn btn-outline-primary">Обновить новость</button>
        </form>
        @include('admin.news.chunks.deleteNews')
    </div>
@endsection
