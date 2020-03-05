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
        @if($post->isAccessToEdit(Auth::user()))
            <div class="service-block mt-2">
                <a href="{{route('posts.edit', $post->slug)}}" class="btn btn-outline-primary">Редактировать статью</a>
                @include('post.chunks.deleteArticle')
            </div>
        @endif
    </div>
@endsection
