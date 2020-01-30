@extends('layout.layout')

@section('content')
    <div class="col-md-9 blog-main">
        <div class="row mb-2">
            <?php /** @var $post \App\Models\Post */ ?>
            @foreach($posts as $post)
                <div class="col-md-6">
                    <div class="card" style="width: 18rem;">
                        <img src="{{asset('img/post.jpg')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->title}}</h5>
                            <p class="card-text">{{$post->body}}</p>
                            <small>{{$post->created_at->format('d.m.Y H:i:s')}}</small>
                            <a href="/posts/{{$post->id}}" class="btn btn-primary ml-5">Читать полностью</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection