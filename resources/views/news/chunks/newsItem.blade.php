<?php /** @var $newsItem App\Models\News */ ?>

@if(!empty($newsItem))
    <div class="blog-post">
        <h4 class="article-title">{{$newsItem->title}}</h4>
        <p class="blog-post-meta">
            {{$newsItem->created_at->toDateTimeString()}} |
            <span>
                автор: {{$newsItem->owner->name}}
            </span>
        </p>
        <p class="post-shortDescription">{{$newsItem->shortDescription}}</p>
        @include('tag.tagsForEntity', ['tags'=>$newsItem->tags])
        <a href="{{route('news.show', $newsItem->slug)}}">Перейти к полному тексту новости...</a>
        <hr>
    </div>
@endif
