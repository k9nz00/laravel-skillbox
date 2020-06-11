<?php /** @var $news  App\Models\Post */ ?>
@extends('layouts.masterLayout')

@section('title', $news->title)

@section('content')
    <div class="col-md-9 blog-main mb-2">
        <div class="blog-post">
            <h3 class="">{{$news->title}}</h3>
            <p class="blog-post-meta">{{$news->created_at->longRelativeDiffForHumans()}}</p>
            <p>{{$news->body}}</p>
            @include('post.chunks.tags', ['tags'=>$news->tags])
        </div>
        <a href="{{route('posts.index')}}" class="btn btn-outline-success">К списку статей</a>
        <div class="mt-3">Комментарии к статье:</div>

        @include('layouts.layoutsChunk.errorsForm')
        @if(!Auth::check())
            <div class="mt-3">
                Только авторизованные пользователи могут оставлять комментарии.<br>
                Пожалуйста авторизуйтесь!
            </div>
        @else
            @include('layouts.layoutsChunk.createCommentForm', ['route'=>'news.comment.store', 'slug'=>$news->slug])
        @endif

        @if(!empty($news->comments))
            <div class="">
                @foreach($news->comments as $comment)
                    @include('layouts.layoutsChunk.commentItem', ['comment'=>$comment])
                @endforeach
            </div>
        @endif

    </div>
@endsection
