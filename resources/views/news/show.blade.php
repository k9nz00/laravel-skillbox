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
    </div>
@endsection
