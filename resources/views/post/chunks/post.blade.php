<?php /** @var $post App\Models\Post */ ?>

@if(!empty($post))
    <div class="blog-post">
        <h4 class="article-title">{{$post->title}}</h4>
        <p class="blog-post-meta">{{$post->created_at->longRelativeToNowDiffForHumans()}}

        </p>
        <p class="post-shortDescription">{{$post->shortDescription}}</p>
        @include('post.chunks.tags', ['tags'=>$post->tags])
        <a href="{{route('post.show', $post->slug)}}">Читать статью полностью</a>
        <hr>
    </div>
@endif