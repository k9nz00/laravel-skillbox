@extends('layout.layout')

@section('content')
    <div class="col-md-9 blog-main">
        <h2 class="pb-3 mb-4 font-italic border-bottom">
            Список статей
        </h2>
        <?php /** @var $post App\Models\Post */ ?>
        @foreach($posts as $post)
            <div class="blog-post">
                <h4 class="">{{$post->title}}</h4>
                <p class="blog-post-meta">{{$post->created_at->longRelativeDiffForHumans()}}
                    <a href="{{route('post.show', $post->slug)}}">Читать полностью</a>
                </p>
                <p>{{$post->shortDescription}}</p>
                <hr>
            </div>
        @endforeach
    </div>
@endsection