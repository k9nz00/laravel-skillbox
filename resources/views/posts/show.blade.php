<?php  /** @var $post  App\Models\Post */ ?>
@extends('layout.layout')

@section('title', $post->title)

@section('content')
    <div class="col-md-9 blog-main">
        <div class="blog-post">
            <h3 class="">{{$post->title}}</h3>
            <p class="blog-post-meta">{{$post->created_at->longRelativeDiffForHumans()}}</p>
            <p>{{$post->body}}</p>
        </div>
        <a href="{{route('home')}}">К списку статей</a>
    </div>
@endsection
