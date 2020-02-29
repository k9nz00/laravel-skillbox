@extends('layouts.masterLayout')

@section('title', 'Создание статьи')

@section('content')
    <div class="col-md-9 blog-main">

        @include('layouts.layoutsChunk.errorsForm')
        <h3>Создание статьи</h3>
        <form action="{{route('post.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="inputSlug" class="field-label">
                    <span class="">
                        <svg class="material-icon-size" viewBox="0 0 24 24">
                                    <path d="M12.89,3L14.85,3.4L11.11,21L9.15,20.6L12.89,3M19.59,12L16,8.41V5.58L22.42,12L16,18.41V15.58L19.59,12M1.58,12L8,5.58V8.41L4.41,12L8,15.58V18.41L1.58,12Z"/>
                         </svg>
                        Символьный код для статьи
                    </span>
                </label>
                <input type="text"
                       name="slug"
                       class="form-control"
                       id="inputSlug"
                       placeholder="Slug"
                       required>
            </div>
            <div class="form-group">
                <label for="inputTitle" class="field-label">
                    <span class="">
                        <svg class="material-icon-size" viewBox="0 0 24 24">
                            <path d="M5,4V7H10.5V19H13.5V7H19V4H5Z"/>
                        </svg>
                        Название статьи
                    </span>
                </label>
                <input type="text"
                       name="title"
                       class="form-control"
                       id="inputTitle"
                       placeholder="title"
                       required>
            </div>
            <div class="form-group">
                <label for="inputShortDescription" class="field-label">
                   <span class="">
                        <svg class="material-icon-size" viewBox="0 0 24 24">
                            <path d="M17,7H22V17H17V19A1,1 0 0,0 18,20H20V22H17.5C16.95,22 16,21.55 16,21C16,21.55 15.05,22 14.5,22H12V20H14A1,1 0 0,0 15,19V5A1,1 0 0,0 14,4H12V2H14.5C15.05,2 16,2.45 16,3C16,2.45 16.95,2 17.5,2H20V4H18A1,1 0 0,0 17,5V7M2,7H13V9H4V15H13V17H2V7M20,15V9H17V15H20M8.5,12A1.5,1.5 0 0,0 7,10.5A1.5,1.5 0 0,0 5.5,12A1.5,1.5 0 0,0 7,13.5A1.5,1.5 0 0,0 8.5,12M13,10.89C12.39,10.33 11.44,10.38 10.88,11C10.32,11.6 10.37,12.55 11,13.11C11.55,13.63 12.43,13.63 13,13.11V10.89Z"/>
                         </svg>
                        Краткое описание статьи
                    </span>
                </label>
                <input type="text"
                       name="shortDescription"
                       class="form-control"
                       id="inputShortDescription"
                       placeholder="inputShortDescription"
                       required>
            </div>
            <div class="form-group">
                <label for="inputBody" class="field-label">
                   <span class="">
                        <svg class="material-icon-size" viewBox="0 0 24 24">
                            <path d="M20,20H4A2,2 0 0,1 2,18V6A2,2 0 0,1 4,4H20A2,2 0 0,1 22,6V18A2,2 0 0,1 20,20M4,6V18H20V6H4M6,9H18V11H6V9M6,13H16V15H6V13Z"/>
                         </svg>
                        Текст статья
                    </span>
                </label>
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
                <label class="form-check-label field-label" for="inputPublish">
                   <span class="">
                        <svg class="material-icon-size" viewBox="0 0 24 24">
                            <path d="M17.9,17.39C17.64,16.59 16.89,16 16,16H15V13A1,1 0 0,0 14,12H8V10H10A1,1 0 0,0 11,9V7H13A2,2 0 0,0 15,5V4.59C17.93,5.77 20,8.64 20,12C20,14.08 19.2,15.97 17.9,17.39M11,19.93C7.05,19.44 4,16.08 4,12C4,11.38 4.08,10.78 4.21,10.21L9,15V16A2,2 0 0,0 11,18M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                         </svg>
                        Опубликовано
                    </span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Создать статью</button>
        </form>
    </div>
@endsection