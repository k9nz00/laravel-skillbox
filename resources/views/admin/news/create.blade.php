
@extends('layouts.adminMasterLayout')

@section('navBar')
    @parent
@endsection

@section('content')
    <div class="col-md-8 offset-2 blog-main">

        @include('layouts.layoutsChunk.errorsForm')
        <h3 class="text-center">Создание новости</h3>
        <form action="{{route('admin.news.store')}}" method="post">
            @csrf
            @include('admin.news.chunks.formNews')
            <button type="submit" class="btn btn-primary">Создать новость</button>
            <a href="{{route('admin.news.index')}}" class="btn btn-info">Вернутья</a>
        </form>
    </div>
@endsection
