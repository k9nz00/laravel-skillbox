@extends('layout.layout')

@section('content')
    <div class="col-md-9 blog-main">

        @include('layout.layoutsChunk.errorsForm')

        <h3>Создание задачи</h3>
        <form action="/posts" method="post">
            @csrf
            <div class="form-group">
                <label for="inputTitle">Введите название задачи</label>
                <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Название задачи">
            </div>
            <div class="form-group">
                <label for="inputBody">Password</label>
                <input type="text" name="body" class="form-control" id="inputBody" placeholder="описание задачи">
            </div>
            <button type="submit" class="btn btn-primary">Создать задачу</button>
        </form>
    </div>
@endsection