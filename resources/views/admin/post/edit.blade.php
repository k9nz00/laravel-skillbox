
@extends('layouts.adminMasterLayout')

@section('navBar')
    @parent
@endsection

@section('content')
    <div class="col-md-9 blog-main">

        @include('layouts.layoutsChunk.errorsForm')

        <h3>Редактирование статьи {{$post->title}}</h3>
        <form action="{{route('admin.posts.update', $post->slug)}}" method="post" id="editPostForm">
            @csrf
            @method('PUT')
            @include('post.chunks.formArticle', ['post' => $post])

            <button type="submit" class="btn btn-outline-primary">Обновить статью</button>
        </form>
        <div class="mt-2">
            @include('post.chunks.deleteArticle')
        </div>

    </div>
@endsection
