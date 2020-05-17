@php
    $newsItem = $newsItem ?? new \App\Models\News();
@endphp
<tr>
    <?php /** @var $newsItem App\Models\News */ ?>
    <th scope="row">{{$newsItem->id}}</th>
    <td>{{$newsItem->title}}</td>
    <td>{{$newsItem->created_at->toDateTimeString()}}</td>
    <td class="d-flex align-items-center justify-content-around">
        <a href="{{route('admin.news.edit', $newsItem->slug)}}" class="btn btn-outline-primary">Редактировать</a>
        <a href="{{route('news.show', $newsItem->slug)}}" class="btn btn-outline-warning">Открыть на сайте</a>
        @include('admin.news.chunks.deleteNews')
    </td>
</tr>
