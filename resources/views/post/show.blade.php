<?php /** @var $post  App\Models\Post */ ?>
@extends('layouts.masterLayout')

@section('title', $post->title)

@section('content')
    <div class="col-md-9 blog-main">
        <div class="blog-post">
            <h3 class="">{{$post->title}}</h3>
            <p class="blog-post-meta">{{$post->created_at->longRelativeDiffForHumans()}}</p>
            <p>{{$post->body}}</p>
        </div>
        <a href="{{route('post.index')}}" class="btn btn-outline-success">К списку статей</a>
        <div class="service-block mt-2">
            <a href="{{route('post.edit', $post->slug)}}" class="btn btn-outline-primary">Редактировать статью</a>
            @include('post.chunks.deleteArticle')
        </div>
    </div>
@endsection
