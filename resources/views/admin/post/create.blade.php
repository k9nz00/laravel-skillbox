
@extends('layouts.adminMasterLayout')

@section('navBar')
    @parent
@endsection

@section('content')
    <div class="col-md-8 offset-2 blog-main">

        @include('layouts.layoutsChunk.errorsForm')
        <h3 class="text-center">Создание статьи</h3>
        <form action="{{route('postsPanel.store')}}" method="post">
            @csrf
            @include('post.chunks.formArticle')
            <button type="submit" class="btn btn-primary">Создать статью</button>
        </form>
    </div>
@endsection
