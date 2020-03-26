<?php /** @var $post App\Models\Post */ ?>
<form class="d-inline-block" action="{{route('admin.post.destroy', $post->slug)}}" method="POST">
    @csrf
    @method("DELETE")
    <button type="submit" class="btn btn-outline-danger">Удалить пост</button>
</form>
