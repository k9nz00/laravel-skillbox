<?php /** @var $news App\Models\News */ ?>
<form class="d-inline-block" action="{{route('admin.news.destroy', $newsItem->slug)}}" method="POST">
    @csrf
    @method("DELETE")
    <button type="submit" class="btn btn-outline-danger">Удалить новость</button>
</form>
