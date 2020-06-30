@extends('layouts.masterLayout')

@section('content')
    <div class="col-md-9">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Имя статических даннх</th>
                <th scope="col">Значение</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Количество статей на сайте</td>
                <td>{{$statistics['countPosts']}}</td>
            </tr>
            <tr>
                <td>Количество новостей на сайте</td>
                <td>{{$statistics['countNews']}}</td>
            </tr>
            <tr>
                <td>ФИО автора, у которого больше всего статей на сайте</td>
                <td>{{$statistics['author']}}</td>
            </tr>
            <tr>
                <td>Самая длинная статья</td>
                <td>
                    <a href="{{route('posts.show', $statistics['maxLengthPost']['slug'])}}">{{$statistics['maxLengthPost']['title']}}</a>
                    - {{$statistics['maxLengthPost']['length']}} {{Lang::choice('wordsForms.symbol', $statistics['maxLengthPost']['length'])}}
                </td>
            </tr>
            <tr>
                <td>Самая короткая статья</td>
                <td>
                    <a href="{{route('posts.show', $statistics['minLengthPost']['slug'])}}">{{$statistics['minLengthPost']['title']}}</a>
                    - {{$statistics['minLengthPost']['length']}} {{Lang::choice('wordsForms.symbol', $statistics['minLengthPost']['length'])}}
                </td>
            </tr>
            <tr>
                <td>Средние количество статей у “активных” пользователей</td>
                <td>{{$statistics['averageCountPosts']}} {{Lang::choice('wordsForms.post', $statistics['averageCountPosts'])}}
                </td>
            </tr>
            <tr>
                <td>Самая непостоянная статья</td>
                <td>
                    <a href="{{route('posts.show', $statistics['postHasMaximumChanges']['slug'])}}">{{$statistics['postHasMaximumChanges']['title']}}</a>
                    - {{$statistics['postHasMaximumChanges']['count']}} {{Lang::choice('wordsForms.count', $statistics['postHasMaximumChanges']['count'])}}
                    была изменена
                </td>
            </tr>
            <tr>
                <td>Самая обсуждаемая статья</td>
                <td>
                    <a href="{{route('posts.show', $statistics['postHasMaximumComments']['slug'])}}">{{$statistics['postHasMaximumComments']['title']}}</a>
                    - {{$statistics['postHasMaximumComments']['count']}} {{Lang::choice('wordsForms.count', $statistics['postHasMaximumComments']['count'])}}
                    комментариев содержит
                </td>
            </tr>
            <tr>
                <td>Количестов используемых тегов</td>
                <td>{{$statistics['tagsCount']}}</td>
            </tr>
            <tr>
                <td>Самый часто используемый тег у статей</td>
                <td>
                    <a href="{{route('tags.list', $statistics['mostPopularTagWithPosts']['name'])}}">{{$statistics['mostPopularTagWithPosts']['name']}}</a>
                    - {{$statistics['mostPopularTagWithPosts']['count']}} {{Lang::choice('wordsForms.post', $statistics['mostPopularTagWithPosts']['count'])}}
                    содержат этот тег
                </td>
            </tr>
            <tr>
                <td>Количество зарегистрированных пользователей на сайте</td>
                <td>{{$statistics['countUsers']}}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
