<?php /** @var $item App\Models\Post */ ?>

@if(!empty($item))
    <div class="blog-post">
        <h4 class="article-title">{{$item['title']}}</h4>
        <p class="post-shortDescription">{{$item['shortDescription']}}</p>
        <p class="text-info">
            <a href="{{'/'.$item['type'].'/'.$item['slug']}}">Перейти к полной странице элемента элемента</a>
        </p>
        <hr>
    </div>
@endif
