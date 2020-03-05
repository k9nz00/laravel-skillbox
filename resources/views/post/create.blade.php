@extends('layouts.masterLayout')

@section('title', 'Создание статьи')

@section('content')
    <div class="col-md-9 blog-main">

        @include('layouts.layoutsChunk.errorsForm')
        <h3>Создание статьи</h3>
        <form action="{{route('post.store')}}" method="post">
            @csrf
            @include('post.chunks.formArticle')

            <button type="submit" class="btn btn-primary">Создать статью</button>
        </form>
    </div>
@endsection