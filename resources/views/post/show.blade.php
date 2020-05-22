<?php /** @var $post  App\Models\Post */ ?>
@extends('layouts.masterLayout')

@section('title', $post->title)

@section('content')
    <div class="col-md-9 blog-main mb-2">
        <div class="blog-post">
            <h3 class="">{{$post->title}}</h3>
            <p class="blog-post-meta">{{$post->created_at->longRelativeDiffForHumans()}}</p>
            <p>{{$post->body}}</p>
            @include('post.chunks.tags', ['tags'=>$post->tags])
        </div>
        <a href="{{route('posts.index')}}" class="btn btn-outline-success">К списку статей</a>

        {{--блок кнопок. Показывать только тем пользователям, у которых есть права на управление статьей--}}
        @if(Gate::allows('isAccessToEdit',$post))
            <div class="service-block mt-2">
                @isAdmin
                <a href="{{route('admin.posts.edit', $post->slug)}}" class="btn btn-outline-primary">
                    Редактировать статью
                </a>
                @else
                    <a href="{{route('posts.edit', $post->slug)}}" class="btn btn-outline-primary">
                        Редактировать статью
                    </a>
                    @endisAdmin
                    @include('post.chunks.deleteArticle')
            </div>
        @endif

        <div class="mt-3">Комментарии к статье:</div>
        @include('layouts.layoutsChunk.errorsForm')
        @if(!Auth::check())
            <div class="mt-3">
                Только авторизованные пользователи могут оставлять комментарии.<br>
                Пожалуйста авторизуйтесь!
            </div>
        @else
            @include('layouts.layoutsChunk.createCommentForm', ['route'=>'post.comment.store', 'slug'=>$post->slug])
        @endif

        @if(!empty($post->comments))
            <div class="">
                @foreach($post->comments as $comment)
                    @include('layouts.layoutsChunk.commentItem', ['comment'=>$comment])
                @endforeach
            </div>
        @endif
    </div>
@endsection
