@extends('layout.layout')
@php
    $title = 'Создать статью';
@endphp

@section('title')
    @include('layout.layoutsChunk.titlePage')
@endsection

@section('content')
    <div class="col-md-9 blog-main">

        @include('layout.layoutsChunk.errorsForm')

        <h3>Создание статьи</h3>
        <form action="{{route('post.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="inputSlug">Символьный код для статьи</label>
                <input type="text"
                       name="slug"
                       class="form-control"
                       id="inputSlug"
                       placeholder="Slug"
                       required>
            </div>
            <div class="form-group">
                <label for="inputTitle">Название статьи</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       id="inputTitle"
                       placeholder="title"
                       required>
            </div>
            <div class="form-group">
                <label for="inputShortDescription">Краткое описание статьи</label>
                <input type="text"
                       name="shortDescription"
                       class="form-control"
                       id="inputShortDescription"
                       placeholder="inputShortDescription"
                       required>
            </div>
            <div class="form-group">
                <label for="inputBody">Статья</label>
                <textarea
                        class="form-control"
                        id="inputBody"
                        name="body"
                        required
                        rows="5"></textarea>
            </div>
            <div class="form-group form-check">
                <input type="checkbox"
                       class="form-check-input"
                       name="publish"
                       id="inputPublish">
                <label class="form-check-label" for="inputPublish">Опубликовано</label>
            </div>
            <button type="submit" class="btn btn-primary">Создать статью</button>
        </form>
    </div>
@endsection