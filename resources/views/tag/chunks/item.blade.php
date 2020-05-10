<?php /** @var $item App\Models\Post */ ?>

@if(!empty($item))
    <div class="blog-post">
        <h4 class="article-title">{{$item['title']}}</h4>
        <p class="post-shortDescription">{{$item['shortDescription']}}</p>
        <hr>
    </div>
@endif
