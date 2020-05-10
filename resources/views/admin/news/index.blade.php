@php
    $newsNumber = 1;
@endphp

@extends('layouts.adminMasterLayout')

@section('navBar')
    @parent
    <div class="container">
        <div class="row mt-2 mb-2">
            <div class="">
                <a href="{{route('admin.news.create')}}" class="btn btn-success">Создать новость</a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <table class="table table-hover table-dark">
        <thead>
        <tr>
            <th scope="col">№ новости</th>
            <th scope="col">Title новости</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Управление новостью</th>
        </tr>
        </thead>
        <tbody>
            @foreach($news as $newsItem)
                @include('admin.news.chunks.newsItem', ['news'=>$newsItem, 'newsNumber'=> $newsNumber])
                @php($newsNumber++)
            @endforeach
        </tbody>
    </table>
    <div class="container">
        <div class="row">
            <p><b>Всего новостей {{count($news)}}</b></p>
        </div>
    </div>

@endsection
