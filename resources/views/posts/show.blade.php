@extends('layout.layout')

@section('content')
    <?php
    use App\Models\Post;
    /** @var  Post $post  */ ?>
    <div class="col-md-9 blog-main">

        <h1>{{$post->title}}</h1>
        <p>{{$post->body}}</p>
        <p>{{$post->slug}}</p>

    </div>


@endsection