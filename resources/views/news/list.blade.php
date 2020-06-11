@extends('layouts.masterLayout')

@section('title', 'Список новостей')
@section('content')
    <div class="col-md-9 blog-main">
        <h2 class="pb-3 mb-4 font-italic border-bottom">
            Список новостей сайта
        </h2>

        <?php /** @var $post App\Models\Post */ ?>
        @foreach($news as $newsItem)
            @include('news.chunks.newsItem', ['newsItem'=>$newsItem])
        @endforeach

        {{$news->links()}}
    </div>
@endsection
