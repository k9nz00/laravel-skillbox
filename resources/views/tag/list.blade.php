@extends('layouts.masterLayout')

@section('title', 'Список статей')
@section('content')
    <div class="col-md-9 blog-main">
        <h2 class="pb-3 mb-4 font-italic border-bottom">
            Список элементлов сайта с тегом - <span class="badge badge-info">{{$tagName}}</span>
        </h2>
        <?php /** @var $post App\Models\Post */ ?>
        @foreach($items as $item)
            @include('tag.chunks.item', ['item'=>$item])
        @endforeach
    </div>
@endsection
