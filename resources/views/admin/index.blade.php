@extends('layout.layout')

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
                <td><a href="{{route('admin.feedbacks')}}">{{route('admin.feedbacks')}}</a></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection