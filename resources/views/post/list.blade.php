@extends('layouts.masterLayout')

@section('title', 'Список статей')
@section('content')
    <div class="col-md-9 blog-main">
        <h2 class="pb-3 mb-4 font-italic border-bottom">
            Список статей сайта
        </h2>
        <?php /** @var $post App\Models\Post */ ?>
        @foreach($posts as $post)
            <div class="blog-post">
                <h4 class="article-title">{{$post->title}}</h4>
                <p class="blog-post-meta">{{$post->created_at->longRelativeToNowDiffForHumans()}}

                </p>
                <p class="post-shortDescription">{{$post->shortDescription}}</p>
                <a href="{{route('post.show', $post->slug)}}">Читать статью полностью</a>
                <hr>
            </div>
        @endforeach
    </div>
@endsection