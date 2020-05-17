@extends('layouts.adminMasterLayout')

@section('navBar')
    @parent
    @include('layouts.layoutsChunk.adminItemsPageNav', ['type'=> 'posts', 'itemsCount' => $postsCount])
@endsection

@section('content')
    <table class="table table-hover table-dark">
        <thead>
        <tr>
            <th scope="col">id поста</th>
            <th scope="col">Title поста</th>
            <th scope="col">Статус публикации</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Управление постом</th>
        </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                @include('admin.post.chunks.postItem', ['post'=>$post])
            @endforeach
        </tbody>
    </table>
    {{$posts->links()}}
@endsection
