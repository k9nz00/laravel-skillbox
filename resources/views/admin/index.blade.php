@extends('layouts.masterLayout')

@section('title', 'Главная страница админки')

@section('content')
    <div class="col-md-9 contacts">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Имя раздела</th>
                <th scope="col">Ссылка</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>feedbacks</td>
                <td><a href="{{route('admin.feedback')}}">Отзывы пользователей</a></td>
            </tr>
            <tr>
                <td>Управление статьями</td>
                <td><a href="{{route('admin.posts.index')}}">Панель управления постами</a></td>
            </tr>
            <tr>
                <td>Управление новостями</td>
                <td><a href="{{ route('admin.news.index') }}">Панель управления новостями</a></td>
            </tr>
            <tr>
                <td>Отчеты</td>
                <td><a href="{{ route('admin.reports') }}">Отчеты для администратора</a></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
