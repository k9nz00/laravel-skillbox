@extends('layouts.masterLayout')

@section('aside')
@endsection

@section('content')
    <div class="justify-content-center">
        Добро пожаловать на мой учебный сайт посвященный <span class="badge badge-info">Laravel!</span>
        <div>
            Я решил немного переделать условия из домашней работы №3 и из главной страницы убрал
            все статьи. Они расположены по по адресу
            <a href="{{route('post.index')}}">/posts</a>
            <p>Дальнейшую историю и некоторую дополнительную информацию я буду размещать на этой страинце</p>
        </div>
        <div class="">
            Для работы проекта после скачивания из репозитория необходимо выполнить
            команду "npm run dev" чтобы собрать фронт. Он не под GIT-ом.
        </div>
    </div>


@endsection
