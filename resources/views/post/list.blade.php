@extends('layouts.masterLayout')

@section('title', 'Список статей')
@section('content')
    <div class="col-md-9 blog-main">
        <h2 class="pb-3 mb-4 font-italic border-bottom">
            Список статей сайта
        </h2>
        <?php /** @var $post App\Models\Post */ ?>
        @foreach($posts as $post)
            @include('post.chunks.post', ['post'=>$post])
        @endforeach
    </div>
@endsection