@extends('layouts.adminMasterLayout')

@section('navBar')
    @parent
    @include('layouts.layoutsChunk.adminItemsPageNav', ['type'=> 'news', 'itemsCount' => $newsCount])
@endsection

@section('content')
    <table class="table table-hover table-dark">
        <thead>
        <tr>
            <th style="width: 25px" scope="col">id новости</th>
            <th class="text-center" scope="col">Title новости</th>
            <th style="width: 120px" scope="col">Дата создания</th>
            <th class="text-center" scope="col">Управление новостью</th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $newsItem)
            @include('admin.news.chunks.newsItem', ['news'=>$newsItem])
        @endforeach
        </tbody>
    </table>
    {{$news->links()}}
@endsection
