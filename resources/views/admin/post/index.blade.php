@php
    $postNumber = 1;
@endphp

@extends('layouts.adminMasterLayout')

@section('navBar')
    @parent
    <div class="container">
        <div class="row mt-2 mb-2">
            <div class="">
                <a href="{{route('admin.posts.create')}}" class="btn btn-success">Создать пост</a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <table class="table table-hover table-dark">
        <thead>
        <tr>
            <th scope="col">№ поста</th>
            <th scope="col">Title поста</th>
            <th scope="col">Статус публикации</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Управление постом</th>
        </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                @include('admin.post.chunks.postItem', ['post'=>$post, 'postNumber'=> $postNumber])
                @php($postNumber++)
            @endforeach
        </tbody>
    </table>
    <div class="container">
        <div class="row">
            <p><b>Всего постов {{count($posts)}}</b></p>
        </div>
    </div>

@endsection
